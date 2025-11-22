<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function schedules()
    {
        return $this->hasMany(schedule::class);
    }

    public function scheduleExclusions()
    {
        return $this->hasMany(ScheduleExclusion::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
