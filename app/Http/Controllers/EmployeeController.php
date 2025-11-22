<?php

namespace App\Http\Controllers;

use App\Bookings\ScheduleAvailbaility;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::find(1);
        $service = Service::find(1);
        $availability = (new ScheduleA vailbaility($employee, $service))
                        ->forPeriod(
                            now()->startOfDay(),
                            now()->addMonth()->endOfDay()
                        );
        return $availability;
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
        return view('employee.show', compact('employee'));
    }

    public function show(Employee $employee)
    {
        dd($employee->services);
    }

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }
}
