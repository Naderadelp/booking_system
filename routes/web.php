<?php

use App\Bookings\ServiceSlotAvailability;
use App\Bookings\SlotRangeGenerator;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingEmployeeController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Carbon::setTestNow(Carbon::tomorrow()->setTimeFromTimeString('1:00:00'));
Route::resource('/employee', EmployeeController::class);


Route::get('/', function () {
  $employees = Employee::get();

  $service = Service::find(2);
  $availability = (new ServiceSlotAvailability($employees, $service))
    ->forPeriod(now()->startOfDay(), now()->addDay()->endOfDay());

  dd($availability->firstAvailableDate());


    // $generator = (new SlotRangeGenerator(now()->startOfDay(), now()->addDay()->endOfDay()));
      // dd($generator->generate(30) );
});

Route::get('booking' , BookingController::class)->name('booking');

Route::get('booking/{employee:slug}' , BookingEmployeeController::class)->name('booking.employee');