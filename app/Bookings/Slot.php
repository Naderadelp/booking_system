<?php

namespace App\Bookings;

use Carbon\Carbon;

class Slot
{

  public $employee = [];
  public function __construct(public Carbon $time)
  {
    // $this->time = $time;
  }


}

