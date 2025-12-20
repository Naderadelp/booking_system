<?php

namespace App\Bookings;

use App\Models\Employee;
use App\Models\ScheduleExclusion;
use App\Models\Service;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Spatie\Period\Boundaries;
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

        $this->employee->scheduleExclusions()->each(function (ScheduleExclusion $exclusion)
        {
          $this->subtractScheduleExclusion($exclusion);
        });

        $this->excludeTimePassedToday();
    });

    foreach($this->periods as $period)
    {
      // dump($period->asString());
    }

    return $this->periods;
  }

  protected function addAvailabilityFromSchedule(Carbon $date)
  {
    if(!$schedule = $this->employee->schedules()->where('start_at', '<=', $date)->where('end_at', '>=', $date)->first())
    {
      return;
    }
    if(![$startAt, $endAt] = $schedule->getWorkingHoursForDate($date))
    {
      return;
    }
    $this->periods = $this->periods->add(
      Period::make(
        $date->copy()->setTimeFromTimeString($startAt),
        $date->copy()->setTimeFromTimeString($endAt)->subMinutes($this->service->duration),
        Precision::Minute()
          )
      );
  }

  protected function subtractScheduleExclusion(ScheduleExclusion $exclusion)
  {
    $this->periods = $this->periods->subtract(
      Period::make(
      $exclusion->start_at,
      $exclusion->end_at,
      Precision::MINUTE(),
      Boundaries::EXCLUDE_END()
      )
    );
  }

  protected function excludeTimePassedToday()
  {
    $this->periods = $this->periods->subtract(
      Period::make(
      now()->startOfDay(),
      now()->endOfHour(),
      Precision::MINUTE(),
      Boundaries::EXCLUDE_START()
      )
    );
  }

}