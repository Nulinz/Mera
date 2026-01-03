<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ProjectController extends Controller
{

    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        /* =======================
           Active Projects
        ======================= */
        $projects = [];

        $defaultProject =  0; //$projects->first()?->id ??

        /* =======================
           Project Wise Labour
        ======================= */
        $projectWise = [];

        $projectWiseSeries = 2;
        $projectWiseLabels = 1;

        /* =======================
           Daily Labour
        ======================= */
        $startDate = /* DB::table('m_pro')->where('id',$defaultProject)->value('st_date') ?? */ $today;

        $dailyData = [];
        // DB::table('m_attend')
        //     ->select(DB::raw('DATE(cap_in) as day'), DB::raw('COUNT(id) as total'))
        //     ->where('pro_id',$defaultProject)
        //     ->whereBetween(DB::raw('DATE(cap_in)'), [$startDate, $today])
        //     ->groupBy(DB::raw('DATE(cap_in)'))
        //     ->orderBy('day')
        //     ->get()
        //     ->map(fn($d)=>[
        //         'date' => Carbon::parse($d->day)->format('d/m'),
        //         'count'=> (int)$d->total
        //     ]);

        /* =======================
           Weekly Labour
        ======================= */
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $weeklyData = [];

        $ranges = [
            [1,7], [8,14], [15,21], [22,31]
        ];

        foreach($ranges as $r){
            $weeklyData[] = 1;
            // DB::table('m_attend')
            //     ->where('pro_id',$defaultProject)
            //     ->whereMonth('cap_in',$month)
            //     ->whereBetween(DB::raw('DAY(cap_in)'), [$r[0],$r[1]])
            //     ->count();
        }

        /* =======================
           Monthly Labour
        ======================= */
        $monthlyData = [];

        for($m=1;$m<=12;$m++){
            $monthlyData[] = 2;
            // DB::table('m_attend')
            //     ->where('pro_id',$defaultProject)
            //     ->whereYear('cap_in',$year)
            //     ->whereMonth('cap_in',$m)
            //     ->count();
        }

        /* =======================
           Contractor Wise
        ======================= */
        $contractorData = 3;
        // DB::table('m_attend as a')
        //     ->join('m_lab as l','l.id','=','a.emp_id')
        //     ->join('m_con as c','c.id','=','l.con_id')
        //     ->select('c.id','c.name', DB::raw('COUNT(a.id) as total'))
        //     ->where('l.pro_id',$defaultProject)
        //     ->groupBy('c.id','c.name')
        //     ->get();

        $contractorSeries = 5; // $contractorData->pluck('total')
        $contractorLabels = 'name';// $contractorData->pluck('name')

        return view('dlr.dashboard', compact(
            'projects',
            'projectWiseSeries','projectWiseLabels',
            'dailyData','weeklyData','monthlyData',
            'contractorSeries','contractorLabels'
        ));
    }

    public function index()
    {
        $projects = [];
        return view('dlr.project.list', compact('projects'));
    }

    public function add()
    {
        $buildingTypes = [];
        $empTypes = [];
        return view('dlr.project.add', compact('buildingTypes', 'empTypes'));
    }

    public function view()
    {
        $project = [];
        $employees = [];
        $assignedTeam = [];
        $assignedEmpIds = [];
        return view('dlr.project.view', compact('project', 'employees', 'assignedTeam', 'assignedEmpIds'));
    }

    public function edit()
    {
        $project = [];
        $buildingTypes = [];

        return view('dlr.project.edit', compact('project', 'buildingTypes'));
    }

    public function bulk_upload()
    {
        $projects = [];
        $contractors = [];
        $trades = [];

        return view('dlr.bulk_upload', compact('projects', 'contractors', 'trades'));
    }

    public function attendence()
    {
        $attendances = [];

        return view('dlr.attendence', compact('attendances'));
    }

    public function settings()
    {
        $categories = [];

        return view('dlr.settings', compact('categories'));
    }
}
