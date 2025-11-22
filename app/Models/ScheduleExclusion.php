<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleExclusion extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleExclusionFactory> */
    use HasFactory;

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
