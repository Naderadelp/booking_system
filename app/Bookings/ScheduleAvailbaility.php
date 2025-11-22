<?php

namespace App\Bookings;

use App\Models\Employee;
use App\Models\Service;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

class ScheduleAvailbaility
{
  protected PeriodCollection $periods;

  protected Employee $employee;

  protected Service $service;

  public function __construct(Employee $employee, Service $service)
  {
    $this->periods = PeriodCollection::make();
    $this->employee = $employee;
    $this->service = $service;
  }

  public function forPeriod(Carbon $startAt, Carbon $endAt)
  {
    collect(CarbonPeriod::create($startAt, $endAt)->days()
    )->each(function ($date) {
        $this->addAvailabilityFromSchedule($date);
    });
  }

  protected function addAvailabilityFromSchedule(Carbon $date)
  {
    if(!$schedule = $this->employee->schedules()->where('start_at', '<=', $date)->where('end_at', '>=', $date)->first())
    {
      return;
    }
    dd($schedule->getWorkingHoursForDate($date));
  }

}