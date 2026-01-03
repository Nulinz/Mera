@extends('dlr.layouts.app')

@section('title', 'Contractor Report')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
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
        <h4 class="m-0">Contractor Report Details</h4>
    </div>

    {{-- Filter Form --}}
    <form method="POST" action=""> {{-- {{ route('reports.contractor') }} --}}
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
                    <input type="date" name="sdate" id="sdate" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3 inputs">
                    <label>End Date</label>
                    <input type="date" name="edate" id="edate" class="form-control" required>
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
        <h4 class="m-0">
            Contractor Workdone Report - {{ $projectData['title'] ?? '' }}
        </h4>

        <a href=""> {{-- {{ route('reports.contractor.excel', request()->only('project','sdate','edate')) }} --}}
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
                    <th>Work Done</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $index => $row)
                    @php
                        $contractor = con_name($row->cont_id ?? null);
                        $hasDoc = !empty($row->remarks) && $row->remarks !== 'NULL';
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') }}</td>
                        <td>{{ $contractor['name'] ?? '-' }}</td>
                        <td>{{ $row->work_done ?? '-' }}</td>
                        <td>
                            @if($hasDoc)
                                <a href="{{ $buck_link . $row->remarks }}" target="_blank">
                                    Document
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- @endif --}}

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.example').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: false,
        responsive: true,
        pageLength: 10,
        dom: '<"top"f>rt<"bottom"lp><"clear">'
    });
});

document.getElementById('sdate')?.addEventListener('change', function () {
    document.getElementById('edate').min = this.value || '1000-01-01';
});
</script>
@endpush
