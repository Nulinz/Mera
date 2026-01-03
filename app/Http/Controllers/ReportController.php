<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function labour_strength(Request $request)
    {
        // $projects = Project::where('status', 'Active')->get();
        $projects = [];
        $reports = [];

        if ($request->filled(['project', 'sdate', 'edate'])) {
            $reports = DB::table('m_attend')
                ->selectRaw('*, count(emp_id) as count_emp')
                ->where('pro_id', $request->project)
                ->whereBetween(DB::raw('date(cap_in)'), [$request->sdate, $request->edate])
                ->groupBy(DB::raw('date(cap_in)'), 'emp_id')
                ->orderBy(DB::raw('date(cap_in)'))
                ->get();
        }

        return view('dlr.reports.labour_strength', compact('projects', 'reports'));
    }

    public function contractor_report()
    {
        $projects = [];
        $reports = [];
        $projectData = null;

        return view('dlr.reports.contractor_report', compact('projects', 'reports', 'projectData'));
    }

}
