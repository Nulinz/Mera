@extends('dlr.layouts.app')

@section('title', 'Project List')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
@endpush

@section('content')

{{-- Header --}}
<div class="sidebodyhead">
    <h4 class="m-0">Project List</h4>
    <a href="{{ route('project.add') }}">
        <button class="listbtn">+ Add Project</button>
    </a>
</div>

<div class="container-fluid px-0 mt-2 listtable">

    {{-- Filters --}}
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select class="headerDropdown form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="customSearch"
                   class="form-control filterInput"
                   placeholder="Search">
        </div>

        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href="">{{-- {{ route('project.excel') }} --}}
                    <img src="{{ asset('assets/images/excel.png') }}" height="35">
                </a>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="example table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Building Type</th>
                    <th>Location</th>
                    <th>Radius</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sunrise Apartments</td>
                    <td>Residential</td>
                    <td>New York, NY</td>
                    <td>5 km</td>
                    <td>01-02-2023</td>
                    <td>30-06-2023</td>
                    <td class="active">Completed</td>
                    <td>
                        <a href="{{ route('project.view') }}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Greenwood Mall</td>
                    <td>Commercial</td>
                    <td>Los Angeles, CA</td>
                    <td>10 km</td>
                    <td>15-03-2023</td>
                    <td>15-12-2023</td>
                    <td class="active">Ongoing</td>
                    <td>
                        <a href="{{ route('project.view') }}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Riverside Office Park</td>
                    <td>Office</td>
                    <td>Chicago, IL</td>
                    <td>8 km</td>
                    <td>01-05-2023</td>
                    <td>31-10-2023</td>
                    <td class="active">Ongoing</td>
                    <td>
                        <a href="{{ route('project.view') }}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Lakeside Villas</td>
                    <td>Residential</td>
                    <td>Miami, FL</td>
                    <td>3 km</td>
                    <td>10-01-2023</td>
                    <td>20-09-2023</td>
                    <td class="active">Completed</td>
                    <td>
                        <a href="{{ route('project.view') }}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Sunset Industrial Hub</td>
                    <td>Industrial</td>
                    <td>Houston, TX</td>
                    <td>15 km</td>
                    <td>05-06-2023</td>
                    <td>05-12-2023</td>
                    <td class="active">Ongoing</td>
                    <td>
                        <a href="{{ route('project.view') }}"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>

            @foreach($projects as $index => $project)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->buildingType->title ?? '-' }}</td>
                    <td>{{ $project->loc }}</td>
                    <td>{{ $project->radius }}</td>
                    <td>{{ $project->st_date?->format('d-m-Y') }}</td>
                    <td>{{ $project->end_date?->format('d-m-Y') }}</td>
                    <td class="active">{{ $project->status }}</td>
                    <td>
                        <a href="{{ route('project.show', $project->id) }}" target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    var table = $('.example').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: false,
        responsive: true,
        pageLength: 10,
        dom: '<"top"f>rt<"bottom"lp><"clear">'
    });

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

});
</script>
@endpush
