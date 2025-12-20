<?php

namespace App\Bookings;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SlotRangeGenerator
{
  public function __construct(protected Carbon $startAt, protected Carbon $endAt)
  {

  }

  public function generate(int $interval)
  {
    $collection = new DateCollection();

    $days = CarbonPeriod::create($this->startAt, '1 day', $this->endAt);

    foreach($days as $day)
    {
      $date = new Date($day);
      $times = CarbonPeriod::create($day->startOfDay() , sprintf('%d minutes', $interval), $day->copy()->endOfDay());
      foreach($times as $time)
      {
        $date->addSlot(new Slot($time));
      }

      $collection->push($date);
    }
    return $collection;
  }

}