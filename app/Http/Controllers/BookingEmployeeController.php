<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingEmployeeController extends Controller
{
    public function __invoke()
    {
        return view('booking.employee');
    }
}
