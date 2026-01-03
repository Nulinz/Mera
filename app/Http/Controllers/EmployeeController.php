<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = [];
        return view('dlr.employee.list', compact('employees'));
    }

    public function view()
    {
        $employee = [];
        $address = [];
        $profile = [];
        $permissions = [];
        return view('dlr.employee.view', compact(
            'employee',
            'address',
            'profile',
            'permissions'
        ));
    }

    public function add()
    {
        $designations = [];
        $empTypes = [];
        return view('dlr.employee.add', compact('designations', 'empTypes'));
    }

    public function edit()
    {
        $employee = [];
        $designations = [];
        $empTypes = [];
        return view('dlr.employee.edit', compact('employee', 'designations', 'empTypes'));
    }
}
