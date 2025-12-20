<?php

namespace App\Bookings;

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Spatie\Period\Boundaries;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;
use Spatie\Period\Precision;

class ServiceSlotAvailability
{
  public function __construct(protected Collection $employees , protected Service $service)
  {

  }

  public function forPeriod(Carbon $startAt, Carbon $endAt)
  {
    $range = (new SlotRangeGenerator($startAt, $endAt))->generate($this->service->duration);

    $this->employees->each(function (Employee $employee) use ($startAt, $endAt, &$range)
    {
      $periods = (new ScheduleAvailbaility($employee, $this->service))
            ->forPeriod($startAt, $endAt);

            $periods = $this->removeAppointments($periods , $employee);

      foreach($periods as $period) {
        $this->addAvailableEmployeeForPeriod($range, $period, $employee);
      }

    });
    $range = $this->removeEmptySlots($range);

    return $range;

  }

  protected function addAvailableEmployeeForPeriod(SupportCollection $range, Period $period, Employee $employee)
  {
    $range->each(function (Date $date) use ($period, $employee)
    {
      $date->slots->each(function (Slot $slot) use ($period, $employee)
      {
        if($period->contains($slot->time))
        {
          $slot->addEmployee($employee);
        }
      });
    });
  }

  protected function removeEmptySlots(SupportCollection $range)
  {
    return $range->filter(function (Date $date) {
       $date->slots = $date->slots->filter(function (Slot $slot)
       {
        return $slot->hasEmployess();
       });

       return true;
    });
  }

  protected function removeAppointments(PeriodCollection $period, Employee $employee)
  {
    $employee->appointments->whereNull('cancelled_at')->each(function (Appointment $appointment) use ($period){
      $period->subtract(Period::make(
        $appointment->start_at->copy()->subMinutes($this->service->duration)->addMinute(),
        $appointment->end_at,
        Precision::MINUTE(),
        Boundaries::EXCLUDE_ALL()
      ));
    });

    return $period;
  }
}