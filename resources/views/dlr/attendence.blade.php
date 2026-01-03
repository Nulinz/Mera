@extends('dlr.layouts.app')

@section('title', 'Attendance List')

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
        <h4 class="m-0">Attendance List</h4>
    </div>

    <div class="container-fluid px-0 mt-2 listtable">

        {{-- Filters --}}
        <div class="filter-container row mb-3">
            <div class="custom-search-container col-md-8">
                <select class="headerDropdown form-select filter-option">
                    <option value="All">All</option>
                </select>
                <input type="text" id="customSearch" class="form-control filterInput" placeholder="Search">
            </div>
        </div>

        {{-- Table --}}
        <div class="table-wrapper">
            <table class="example table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Date</th>
                        <th>Labour Name <br> (Aadhar No)</th>
                        <th>In-Time</th>
                        <th>Out-Time</th>
                        <th>Work Location</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Project Alpha</td>
                        <td>01-01-2025</td>
                        <td>Ramesh Kumar <br> 1234-5678-9012</td>
                        <td>09:05 AM</td>
                        <td>06:10 PM</td>
                        <td>Lat: 12.9716 <br> Long: 77.5946</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Project Beta</td>
                        <td>02-01-2025</td>
                        <td>Suresh Naidu <br> 2345-6789-0123</td>
                        <td>08:55 AM</td>
                        <td>05:45 PM</td>
                        <td>Lat: 13.0827 <br> Long: 80.2707</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Project Gamma</td>
                        <td>03-01-2025</td>
                        <td>Manoj Singh <br> 3456-7890-1234</td>
                        <td>09:10 AM</td>
                        <td>06:00 PM</td>
                        <td>Lat: 28.7041 <br> Long: 77.1025</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Project Delta</td>
                        <td>04-01-2025</td>
                        <td>Arun Patel <br> 4567-8901-2345</td>
                        <td>09:00 AM</td>
                        <td>05:50 PM</td>
                        <td>Lat: 23.0225 <br> Long: 72.5714</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Project Epsilon</td>
                        <td>05-01-2025</td>
                        <td>Vijay Sharma <br> 5678-9012-3456</td>
                        <td>08:45 AM</td>
                        <td>05:30 PM</td>
                        <td>Lat: 26.9124 <br> Long: 75.7873</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Project Zeta</td>
                        <td>06-01-2025</td>
                        <td>Rahul Das <br> 6789-0123-4567</td>
                        <td>09:20 AM</td>
                        <td>06:15 PM</td>
                        <td>Lat: 22.5726 <br> Long: 88.3639</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Project Eta</td>
                        <td>07-01-2025</td>
                        <td>Anil Yadav <br> 7890-1234-5678</td>
                        <td>08:50 AM</td>
                        <td>05:40 PM</td>
                        <td>Lat: 19.0760 <br> Long: 72.8777</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Project Theta</td>
                        <td>08-01-2025</td>
                        <td>Kiran Rao <br> 8901-2345-6789</td>
                        <td>09:00 AM</td>
                        <td>06:00 PM</td>
                        <td>Lat: 17.3850 <br> Long: 78.4867</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Project Iota</td>
                        <td>09-01-2025</td>
                        <td>Sunil Verma <br> 9012-3456-7890</td>
                        <td>08:40 AM</td>
                        <td>05:25 PM</td>
                        <td>Lat: 18.5204 <br> Long: 73.8567</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Project Kappa</td>
                        <td>10-01-2025</td>
                        <td>Deepak Mehta <br> 0123-4567-8901</td>
                        <td>09:15 AM</td>
                        <td>06:05 PM</td>
                        <td>Lat: 21.1702 <br> Long: 72.8311</td>
                    </tr>

                    @forelse($attendances as $index => $att)
                        @php
                            $location = $att->loc_in ? explode(',', $att->loc_in) : [];
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $att->project->title ?? '-' }}</td>

                            <td>{{ $att->cap_in ? \Carbon\Carbon::parse($att->cap_in)->format('d-m-Y') : '-' }}</td>

                            <td>
                                {{ $att->labour->lab_name ?? '-' }} <br>
                                {{ $att->labour->id_proof ?? '-' }}
                            </td>

                            <td>{{ $att->shift_in ?? '-' }}</td>

                            <td>{{ $att->shift_out ?? '-' }}</td>

                            <td>
                                @if(count($location) === 2)
                                    Lat: {{ $location[0] }} <br>
                                    Long: {{ $location[1] }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No Attendance Records Found</td>
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
$(document).ready(function () {
    let table = $('.example').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        info: false,
        pageLength: 10,
        dom: '<"top"f>rt<"bottom"lp><"clear">'
    });

    $('#customSearch').on('keyup', function () {
        table.search(this.value).draw();
    });
});
</script>
@endpush
