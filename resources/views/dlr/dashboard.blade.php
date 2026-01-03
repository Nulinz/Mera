@extends('dlr.layouts.app')

@section('title','Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endpush

@section('content')

<div class="sidebodyhead mb-3">
    <h5 class="mb-3">Dashboard</h5>

    <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
        <select name="company" id="company" class="form-select">
            @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->title }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="charts mt-4">
    <div class="row">

        {{-- Project wise Labour --}}
        <div class="col-md-6 mb-4">
            <div class="charthead d-flex justify-content-between mb-2">
                <h6>Project wise Labour Count</h6>
                <input type="date" id="pie_date" value="{{ date('Y-m-d') }}" class="form-control w-50">
            </div>
            <div class="bg-white p-2 rounded-4">
                <div id="chart1"></div>
            </div>
        </div>

        {{-- Weekly Labour --}}
        <div class="col-md-6 mb-4">
            <div class="charthead d-flex justify-content-between mb-2">
                <h6>Weekly Labour Strength</h6>
                <select id="week_mon" class="form-select w-50">
                    @for($i=1;$i<=12;$i++)
                        <option value="{{ sprintf('%02d',$i) }}">{{ date("F",strtotime("2025-$i-01")) }}</option>
                    @endfor
                </select>
            </div>
            <div class="bg-white p-2 rounded-4">
                <div id="chart3"></div>
            </div>
        </div>

        {{-- Daily --}}
        <div class="col-md-12 mb-4">
            <h6>Daily Labour Count</h6>
            <div class="bg-white p-2 rounded-4">
                <div id="chart2"></div>
            </div>
        </div>

        {{-- Monthly --}}
        <div class="col-md-6 mb-4">
            <h6>Monthly Labour Strength</h6>
            <div class="bg-white p-2 rounded-4">
                <div id="chart4"></div>
            </div>
        </div>

        {{-- Contractor --}}
        <div class="col-md-6 mb-4">
            <h6>Contractor Wise</h6>
            <div class="bg-white p-2 rounded-4">
                <div id="chart5"></div>
            </div>
        </div>

        {{-- Trade --}}
        <div class="col-md-6 mb-4">
            <h6>Trade Wise</h6>
            <select id="trade" class="form-select mb-2"></select>
            <div class="bg-white p-2 rounded-4">
                <div id="chart6"></div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
var projectWiseSeries = @json($projectWiseSeries);
var projectWiseLabels = @json($projectWiseLabels);
var dailyData = @json($dailyData);
var weeklyData = @json($weeklyData);
var monthlyData = @json($monthlyData);
var contractorSeries = @json($contractorSeries);
var contractorLabels = @json($contractorLabels);
</script>

<script>
var chart1 = new ApexCharts(document.querySelector("#chart1"), {
    chart:{ type:'donut', height:300 },
    series: projectWiseSeries,
    labels: projectWiseLabels
});
chart1.render();

var chart2 = new ApexCharts(document.querySelector("#chart2"), {
    chart:{ type:'line', height:300 },
    series:[{ data: dailyData.map(x=>x.count) }],
    xaxis:{ categories: dailyData.map(x=>x.date) }
});
chart2.render();

var chart3 = new ApexCharts(document.querySelector("#chart3"), {
    chart:{ type:'pie', height:300 },
    series: weeklyData,
    labels:['Week 1','Week 2','Week 3','Week 4']
});
chart3.render();

var chart4 = new ApexCharts(document.querySelector("#chart4"), {
    chart:{ type:'line', height:300 },
    series:[{ data: monthlyData }],
    xaxis:{ categories:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] }
});
chart4.render();

var chart5 = new ApexCharts(document.querySelector("#chart5"), {
    chart:{ type:'donut', height:300 },
    series: contractorSeries,
    labels: contractorLabels
});
chart5.render();
</script>
@endpush
