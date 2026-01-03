@extends('dlr.layouts.app')

@section('title', $project->title ?? 'View Project')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
<style>
    .leftct .row div {
        display: grid;
        grid-template-columns: 45% 2% 45%;
        padding-right: 0px;
    }
</style>
@endpush

@section('content')

<div class="sidebodyback my-3" onclick="goBack()">
    <div class="backhead">
        <h5 class="m-0"><i class="fas fa-arrow-left"></i></h5>
        <h6 class="m-0">Project Details</h6>
    </div>
    <div>
        <a href="{{ route('project.edit') }}">{{-- {{ route('projects.edit', ['project' => $project->id]) }} --}}
            <button class="headbtn">Edit Details</button>
        </a>
    </div>
</div>

<div class="mainbdy">
    <div class="leftcntnt">
        <div class="sidebodyhead my-3">
            <h4 class="m-0">{{ $project->title ?? 'Nil' }}</h4>
        </div>

        <div class="container-fluid leftct">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Branch</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->branch ?? 'Nil' }}</h6>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Description</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->des ?? 'Nil' }}</h6>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Building Type</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->b_type_title ?? 'Nil' }}</h6>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Start Date</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">01-01-2026</h6>{{-- {{ optional($project->st_date)->format('d-m-Y') ?? 'Nil' }} --}}
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Budget</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->budget ?? 'Nil' }}</h6>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">End Date</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">01-01-2026</h6>{{-- {{ optional($project->end_date)->format('d-m-Y') ?? 'Nil' }} --}}
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Location</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->loc ?? 'Nil' }}</h6>
                </div>

                <div class="col-sm-12 col-md-6 col-xl-6 mb-2">
                    <h6 class="txtgray">Radius</h6>
                    <h6 class="txtblack">:</h6>
                    <h6 class="txtblack">{{ $project->radius ?? 'Nil' }}</h6>
                </div>

            </div>
        </div>

        {{-- ================= Assign Team Form ================= --}}
        <div class="sidebodyhead my-3">
            <h4 class="m-0">Assign Team</h4>
        </div>

        <div class="container-fluid">
            <form action="" method="POST" id="assign_team_form">{{-- {{ route('projects.assignTeam', $project->id) }} --}}
                @csrf
                <div class="row ps-4 pe-0 pt-4 pb-1"
                     style="box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.10)">
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3 row">

                        <div class="col-sm-6 col-md-3 col-xl-3">
                            <label for="engineer">Engineer</label>
                        </div>

                        <div class="col-sm-6 col-md-5 col-xl-5">
                            <div class="dropdown-center tble-dpd">
                                <button class="w-100 text-start border-0 form-select" type="button"
                                        data-bs-toggle="dropdown">
                                    Select Options
                                </button>
                                <ul class="dropdown-menu w-100 px-3">
                                    @foreach($employees ?? [] as $emp)
                                        @if(!in_array($emp->id, $assignedEmpIds ?? []))
                                            <li class="d-flex align-items-center w-100">
                                                <input type="checkbox" class="me-2 checkbox"
                                                       name="lab[]" value="{{ $emp->id }}">
                                                <label>{{ $emp->name ?? 'Nil' }}</label>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-xl-4 d-flex justify-content-center align-items-center">
                            <button class="formbtn" type="submit">Assign Team</button>
                        </div>

                    </div>
                </div>

                {{-- ================= Team List Table ================= --}}
                <div class="sidebodyhead px-0 mt-3">
                    <h4 class="m-0">Team List</h4>
                </div>

                <div class="container-fluid px-0 py-1 listtable">
                    <div class="table-wrapper">
                        <table class="example table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Team</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedTeam ?? [] as $i => $team)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $team->employee->name ?? 'Nil' }}</td>
                                        <td>
                                            @can('edit-project')
                                                <a class="e_team" data-id="{{ $team->id }}"
                                                   data-bs-toggle="modal" data-bs-target="#edit_popup">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('projects.removeTeam', $project->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                                                    <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this Member?')">
                                                        <i class="fa-solid fa-trash" style="padding:5px;"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

{{-- ================= Edit Team Modal ================= --}}
<div class="modal fade" id="edit_popup" tabindex="-1" aria-labelledby="edit_popupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="edit_popupLabel">Edit Assigned Team</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">{{-- {{ route('projects.updateTeam', $project->id) }} --}}
                    @csrf
                    <input type="hidden" name="assign_id" id="assign_id">
                    <div class="col-sm-12 col-md-12 col-xl-12 mb-3">
                        <label for="engineer">Engineer</label>
                        <select name="emp_assign" id="emp_id" class="form-select">
                            @foreach($employees ?? [] as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->name ?? 'Nil' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit" class="modalbtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('.example').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "bDestroy": true,
            "info": false,
            "responsive": true,
            "pageLength": 10,
            "dom": '<"top"f>rt<"bottom"lp><"clear">'
        });

        $('.e_team').on('click', function() {
            var edit_id = $(this).data("id");

            $.ajax({
                url: "",
                method: "POST",
                data: { edit_assign: edit_id, _token: '{{ csrf_token() }}' },
                dataType: "JSON",
                success: function(data) {
                    $('#assign_id').val(data.id);
                    $('#emp_id').val(data.emp_id).change();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
@endpush
