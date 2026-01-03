@extends('dlr.layouts.app')

@section('title', 'Labour List')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
@endpush

@section('content')

<div class="sidebodyhead">
    <h4 class="m-0">Labour List</h4>
    <a href="{{ route('labour.add') }}">
        <button class="listbtn">+ Add Labour</button>
    </a>
</div>

<div class="container-fluid px-0 mt-2 listtable">

    {{-- Filters --}}
    <div class="filter-container row mb-3">
        <div class="custom-search-container col-sm-12 col-md-8">
            <select class="headerDropdown form-select filter-option">
                <option value="All" selected>All</option>
            </select>
            <input type="text" id="customSearch" class="form-control filterInput" placeholder="Search">
        </div>

        <div class="select1 col-sm-12 col-md-4 mx-auto">
            <div class="d-flex gap-3">
                <a href=""> {{-- {{ route('labour.excel') }} --}}
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
                    <th>Project Name</th>
                    <th>Contractor Name</th>
                    <th>Labour Name</th>
                    <th>Labour Contact</th>
                    <th>Trade</th>
                    <th>Aadhar</th>
                    <th>Joining Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Sunrise Apartments</td>
                    <td>Johnson Electricals</td>
                    <td>Ravi Kumar</td>
                    <td>+91-9876543210</td>
                    <td>Electrician</td>
                    <td>1234-5678-9012</td>
                    <td>01-03-2023</td>
                    <td>
                        <a href="{{ route('labour.edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Greenwood Mall</td>
                    <td>Thompson Plumbing Co.</td>
                    <td>Priya Sharma</td>
                    <td>+91-9123456780</td>
                    <td>Plumber</td>
                    <td>2345-6789-0123</td>
                    <td>15-04-2023</td>
                    <td>
                        <a href="{{ route('labour.edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Riverside Office Park</td>
                    <td>Wilson Construction</td>
                    <td>Arjun Singh</td>
                    <td>+91-9988776655</td>
                    <td>Mason</td>
                    <td>3456-7890-1234</td>
                    <td>01-05-2023</td>
                    <td>
                        <a href="{{ route('labour.edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Lakeside Villas</td>
                    <td>Martinez Landscaping</td>
                    <td>Sneha Reddy</td>
                    <td>+91-9876501234</td>
                    <td>Gardener</td>
                    <td>4567-8901-2345</td>
                    <td>10-01-2023</td>
                    <td>
                        <a href="{{ route('labour.edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Sunset Industrial Hub</td>
                    <td>Davis Cleaning Services</td>
                    <td>Manoj Patel</td>
                    <td>+91-9123456700</td>
                    <td>Cleaner</td>
                    <td>5678-9012-3456</td>
                    <td>05-06-2023</td>
                    <td>
                        <a href="{{ route('labour.edit') }}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>

                @foreach($labours as $index => $labour)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $labour->project->title ?? '-' }}</td>
                        <td>{{ $labour->contractor->name ?? '-' }}</td>
                        <td>{{ $labour->lab_name }}</td>
                        <td>{{ $labour->lab_con }}</td>
                        <td>{{ $labour->trade->title ?? '-' }}</td>
                        <td>{{ $labour->id_proof }}</td>
                        <td>{{ $labour->doj->format('d-m-Y') }}</td>
                        <td>
                            @can('edit-labour')
                            <a href="{{ route('labour.edit', $labour->id) }}" target="_blank">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            @endcan
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
