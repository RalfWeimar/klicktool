<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): Response
    {
        $employees = Employee::all();

        return view('employee.index', compact('employees'));
    }

    public function create(Request $request): Response
    {
        return view('employee.create');
    }

    public function store(EmployeeStoreRequest $request): Response
    {
        $employee = Employee::create($request->validated());

        $request->session()->flash('employee.id', $employee->id);

        return redirect()->route('employees.index');
    }

    public function show(Request $request, Employee $employee): Response
    {
        return view('employee.show', compact('employee'));
    }

    public function edit(Request $request, Employee $employee): Response
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee): Response
    {
        $employee->update($request->validated());

        $request->session()->flash('employee.id', $employee->id);

        return redirect()->route('employees.index');
    }

    public function destroy(Request $request, Employee $employee): Response
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
