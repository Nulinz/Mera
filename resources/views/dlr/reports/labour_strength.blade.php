@extends('dlr.layouts.app')

@section('title', 'Report List')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
<style>
.modal { --bs-modal-width: 1000px; }
</style>
@endpush

@section('content')

<div class="sidebodydiv mb-3">
    <div class="sidebodyback my-3" onclick="history.back()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Report List</h6>
        </div>
    </div>

    <div class="sidebodyhead my-3">
        <h4 class="m-0">Report Details</h4>
    </div>

    {{-- Filter Form --}}
    <form method="POST" action="">{{-- {{ route('reports.labour') }} --}}
        @csrf
        <div class="container-fluid maindiv">
            <div class="row">

                <div class="col-md-4 mb-3 inputs">
                    <label>Project</label>
                    <select name="project" class="form-select" required>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">
                                {{ $project->title ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3 inputs">
                    <label>Start Date</label>
                    <input type="date" name="sdate" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3 inputs">
                    <label>End Date</label>
                    <input type="date" name="edate" class="form-control" required>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="formbtn">Submit</button>
        </div>
    </form>
</div>

{{-- Report Table --}}
{{-- @if($reports->count()) --}}
<div class="sidebodydiv">
    <div class="sidebodyhead d-flex justify-content-between align-items-center">
        <h4 class="m-0">Projectwise Labour Strength Report</h4>

        <a href=""> {{-- {{ route('reports.excel', request()->only('project','sdate','edate')) }} --}}
            <img src="{{ asset('assets/images/excel.png') }}" height="35">
        </a>
    </div>

    <div class="table-wrapper mt-3">
        <table class="example table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Contractor</th>
                    <th>Trade</th>
                    <th>Qty</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $row)
                    @php
                        $lab = lab_name($row->emp_id);
                        $contractor = con_name($lab['con_id'] ?? null);
                        $trade = DB::table('m_cat')
                                    ->where('id', $lab['desgination'] ?? null)
                                    ->where('cat', 'Trade')
                                    ->first();
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->cap_in)->format('d-m-Y') }}</td>
                        <td>{{ $contractor['name'] ?? '-' }}</td>
                        <td>{{ $trade->title ?? '-' }}</td>
                        <td>{{ $row->count_emp ?? 0 }}</td>
                        <td>{{ $row->shift_in ? date('h:i a', strtotime($row->shift_in)) : '-' }}</td>
                        <td>{{ $row->shift_out ? date('h:i a', strtotime($row->shift_out)) : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- @endif --}}

@endsection
