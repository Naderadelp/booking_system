<?php

namespace App\Bookings;

use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\Period\Period;

class ServiceSlotAvailability
{
  public function __construct(protected Collection $employees , protected Service $service)
  {

  }

  public function forPeriod(Carbon $startAt, Carbon $endAt)
  {
    $range = (new SlotRangeGenerator($startAt, $endAt))->generate($this->service->duration);

    $this->employees->each(function (Employee $employee) use ($startAt, $endAt, &$range) {
      $periods = (new ScheduleAvailbaility($employee, $this->service))
            ->forPeriod($startAt, $endAt);

      foreach($periods as $period) {
        $this->addAvailableEmployeeForPeriod($range, $period, $employee);
      }
    });

    return $range;

  }

  protected function addAvailableEmployeeForPeriod(SupportCollection $range, Period $period, Employee $employee)
  {
    $range->each(function (Date $date) use ($period, $employee) {
      $date->slots->each(function (Slot $slot) use ($period, $employee) {
        if($period->contains($slot->time)) {
          $slot->addEmployee($employee);
        }
      });
    });
  }
}