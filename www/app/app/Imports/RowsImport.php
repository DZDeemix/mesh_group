<?php

namespace App\Imports;

use App\Models\Row;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Redis;

class RowsImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow, WithEvents, SkipsOnFailure
{
    use RemembersRowNumber, SkipsFailures, Queueable;

    private static string $fileHash;

    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row): Model|Row|null
    {
        $this->saveProgress();

        return new Row([
            'name' => $row['name'],
            'date' => $this->formatExcelDate($row['date']),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $event) {
                Log::alert('Import failed', [$event->getException()]);
            },
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            Log::alert('Excel Import validator failure',
                [$failure->row(), $failure->attribute(), $failure->errors(), $failure->values()]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'date' => [
                'required',
                'date_format:Y-m-d',
            ],
        ];
    }


    public function formatExcelDate($excelDate):string
    {
        // Преобразование даты Excel в дату PHP
        $unixTimestamp = ($excelDate - 25569) * 86400; // Для формата Excel 1900 года
        return Carbon::parse($unixTimestamp)->format('Y-m-d');
    }

    public static function getHash(): string
    {
        if(empty(self::$fileHash)) {
            return self::$fileHash = Hash::make(self::class);
        }
        return self::$fileHash;
    }

    public function saveProgress():void
    {
        Redis::set(self::getHash(), $this->getRowNumber());
    }

}
