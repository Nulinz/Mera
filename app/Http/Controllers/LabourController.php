<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LabourController extends Controller
{
    public function index()
    {
        $labours = [];
        return view('dlr.labour.list', compact('labours'));
    }

    public function add()
    {
        $trades = [];
        return view('dlr.labour.add', compact('trades'));
    }

    public function edit()
    {
        $labour = [];//DB::table('m_lab')->where('id',$id)->first();

        $projects = []; // DB::table('m_pro')->where('status','Active')->get();
        $contractors = []; // DB::table('m_con')->where('status','Active')->get();
        $trades = []; // DB::table('m_cat')->where('cat','Trade')->where('status','Active')->get();

        $files = []; //DB::table('m_file')->where('f_id',$id)->get()->keyBy('cat');

        return view('dlr.labour.edit', compact('labour','projects','contractors','trades','files'));
    }



    public function update(Request $request)
    {

    }
}
