@extends('dlr.layouts.app')

@section('title', 'Contractor List')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
<style>
.table tr th,
.table tr td {
    font-size: 12px;
}
</style>
@endpush

@section('content')
<div class="sidebodydiv">

    <div class="sidebodyhead">
        <h4 class="m-0">Contractor List</h4>
        <a href="{{ route('contractor.add') }}">
            <button class="listbtn">+ Add Contractor</button>
        </a>
    </div>

    <div class="container-fluid px-0 mt-2 listtable">
        <div class="filter-container row mb-3">
            <div class="custom-search-container col-sm-12 col-md-8">
                <select class="headerDropdown form-select filter-option">
                    <option value="All" selected>All</option>
                </select>
                <input type="text" id="customSearch" class="form-control filterInput" placeholder=" Search">
            </div>

            <div class="select1 col-sm-12 col-md-4 mx-auto">
                <div class="d-flex gap-3">
                    <a href="">{{-- {{ route('contractors.exportExcel') }} --}}
                        <img src="{{ asset('assets/images/excel.png') }}" id="excel" alt="" height="35px">
                    </a>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="example table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Contact Person Name</th>
                        <th>Contact Business Name</th>
                        <th>Email Id</th>
                        <th>Contact Number</th>
                        <th>Contractor Type</th>
                        <th>Contract Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Sarah Johnson</td>
                        <td>Johnson Electricals</td>
                        <td>sarah.johnson@example.com</td>
                        <td>+1-555-1010</td>
                        <td>Electrical</td>
                        <td>12 Months</td>
                        <td>
                            <a href="{{ route('contractor.view') }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Mark Thompson</td>
                        <td>Thompson Plumbing Co.</td>
                        <td>mark.thompson@example.com</td>
                        <td>+1-555-2020</td>
                        <td>Plumbing</td>
                        <td>6 Months</td>
                        <td>
                            <a href="{{ route('contractor.view') }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Linda Martinez</td>
                        <td>Martinez Landscaping</td>
                        <td>linda.martinez@example.com</td>
                        <td>+1-555-3030</td>
                        <td>Landscaping</td>
                        <td>24 Months</td>
                        <td>
                            <a href="{{ route('contractor.view') }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>James Wilson</td>
                        <td>Wilson Construction</td>
                        <td>james.wilson@example.com</td>
                        <td>+1-555-4040</td>
                        <td>Construction</td>
                        <td>18 Months</td>
                        <td>
                            <a href="{{ route('contractor.view') }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Emily Davis</td>
                        <td>Davis Cleaning Services</td>
                        <td>emily.davis@example.com</td>
                        <td>+1-555-5050</td>
                        <td>Cleaning</td>
                        <td>3 Months</td>
                        <td>
                            <a href="{{ route('contractor.view') }}"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>

                    @forelse($contractors as $i => $contractor)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $contractor->name ?? 'N/A' }}</td>
                            <td>{{ $contractor->bus_name ?? 'N/A' }}</td>
                            <td>{{ $contractor->mail ?? 'N/A' }}</td>
                            <td>{{ $contractor->con_num ?? 'N/A' }}</td>
                            <td>{{ $contractorTypes[$contractor->con_type] ?? 'N/A' }}</td>
                            <td>{{ $contractor->duration ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('contractors.show', $contractor->id) }}" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No contractors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('.example').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        bDestroy: true,
        info: false,
        responsive: true,
        pageLength: 10,
        dom: '<"top"f>rt<"bottom"lp><"clear">'
    });

    $('#customSearch').on('keyup', function() {
        table.search($(this).val()).draw();
    });
});
</script>
@endpush
