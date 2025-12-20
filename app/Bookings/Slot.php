<?php

namespace App\Bookings;

use App\Models\Employee;
use Carbon\Carbon;

class Slot
{

  public $employee = [];
  public function __construct(public Carbon $time)
  {
    // $this->time = $time;
  }


  public function addEmployee(Employee $employee)
  {
    $this->employee[] = $employee;
  }

  public function hasEmployess(){
    return !empty($this->employee);
  }

}

