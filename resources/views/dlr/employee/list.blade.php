@extends('dlr.layouts.app')

@section('title', 'Employee List')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
@endpush

@section('content')

{{-- Header --}}
<div class="sidebodyhead">
    <h4 class="m-0">Employee List</h4>
    <a href="{{ route('employee.add') }}">
        <button class="listbtn">+ Add Employee</button>
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
                <a href="">{{-- {{ route('employee.excel') }} --}}
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
                    <th>Code</th>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email Id</th>
                    <th>Designation</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>1</td>
                    <td>EMP001</td>
                    <td>John Doe</td>
                    <td>+1-555-1234</td>
                    <td>johndoe@example.com</td>
                    <td>Software Engineer</td>
                    <td>2022-03-15</td>
                    <td>Active</td>
                    <td>
                        <a href="{{ route('employee.view') }}" target="_blank">
                                <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>EMP002</td>
                    <td>Jane Smith</td>
                    <td>+1-555-5678</td>
                    <td>janesmith@example.com</td>
                    <td>Project Manager</td>
                    <td>2021-07-10</td>
                    <td>Active</td>
                    <td>
                        <a href="{{ route('employee.view') }}" target="_blank">
                                <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>EMP003</td>
                    <td>Michael Brown</td>
                    <td>+1-555-9101</td>
                    <td>michaelbrown@example.com</td>
                    <td>UI/UX Designer</td>
                    <td>2023-01-20</td>
                    <td>Inactive</td>
                    <td>
                        <a href="{{ route('employee.view') }}" target="_blank">
                                <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>EMP004</td>
                    <td>Emily Davis</td>
                    <td>+1-555-1122</td>
                    <td>emilydavis@example.com</td>
                    <td>QA Engineer</td>
                    <td>2020-09-05</td>
                    <td>Active</td>
                    <td>
                        <a href="{{ route('employee.view') }}" target="_blank">
                                <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>EMP005</td>
                    <td>David Wilson</td>
                    <td>+1-555-3344</td>
                    <td>davidwilson@example.com</td>
                    <td>HR Specialist</td>
                    <td>2019-11-30</td>
                    <td>Inactive</td>
                    <td>
                        <a href="{{ route('employee.view') }}" target="_blank">
                                <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>

                @foreach($employees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee->code }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->contact }}</td>
                        <td>{{ $employee->mail }}</td>
                        <td>{{ $employee->designation->title ?? '-' }}</td>
                        <td>{{ $employee->doj?->format('d-m-Y') }}</td>
                        <td class="active">{{ $employee->status }}</td>
                        <td>
                            <a href="{{ route('employee.show', $employee->id) }}" target="_blank">
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
