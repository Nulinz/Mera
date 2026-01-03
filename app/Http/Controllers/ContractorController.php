<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index()
    {
        $contractors = [];
        $contractorTypes = [];
        return view('dlr.contractor.list', compact('contractors', 'contractorTypes'));
    }

    public function add()
    {
        $contractorTypes = [];
        return view('dlr.contractor.add', compact('contractorTypes'));
    }

    public function view()
    {
        $contractor = [];
        $employees = [];
        $assignedTeam = [];
        $assignedEmpIds = [];
        return view('dlr.contractor.view', compact('contractor', 'employees', 'assignedTeam', 'assignedEmpIds'));
    }

    public function edit()
    {
        $contractor = [];
        $types = [];

        return view('dlr.contractor.edit', compact('contractor', 'types'));
    }
}
