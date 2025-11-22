<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ScheduleFactory::new();
    }

    public function getWorkingHoursForDate(Carbon $date)
    {
        $startAt = $this->{strtolower($date->format('l')).'_start_at'};
        $endAt = $this->{strtolower($date->format('l')).'_end_at'};

        return [
            'start_at' => $startAt,
            'end_at' => $endAt,
        ];
    }
}