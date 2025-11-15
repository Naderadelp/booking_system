<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
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
