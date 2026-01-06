<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class BookingEmployeeController extends Controller
{
    public function __invoke(Employee $employee)
    {
        $services =  $employee->services()->orderBy('price' , 'asc')->get();
        return view('booking.employee' , compact('employee','services'));
    }
}
