<?php

use App\Bookings\SlotRangeGenerator;
use App\Http\Controllers\EmployeeController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

// Carbon::setTestNow(now()->setTimeFromTimeString('1:00:00'));
Route::resource('/employee', EmployeeController::class);


Route::get('/', function () {
    $generator = (new SlotRangeGenerator(now()->startOfDay(), now()->addDay()->endOfDay()));
      dd($generator->generate(30) );
});