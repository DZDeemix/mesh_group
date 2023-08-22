<?php

namespace App\Models;

use App\Events\RowCreated;
use App\Events\RowSaved;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $fillable = ['id', 'name', 'date'];
    public $timestamps = false;

    protected $dispatchesEvents = [
        'created' => RowCreated::class,
    ];

    public function broadcastOn(string $event): array
    {
        return match ($event) {
            'created' => [],
            default => [$this],
        };
    }
}
