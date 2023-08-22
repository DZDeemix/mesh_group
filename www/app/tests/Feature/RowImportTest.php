<?php

namespace Tests\Feature;

use App\Imports\RowsImport;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RowImportTest extends TestCase
{
    private RowsImport $rowImport;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->rowImport = new RowsImport();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDateFormat()
    {
        $excelDate = 44291;

        $formattedDate = $this->rowImport->formatExcelDate($excelDate);

        $expectedDate = '2021-04-05';

        $this->assertEquals($expectedDate, $formattedDate);
    }
}
