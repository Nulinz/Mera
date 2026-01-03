@extends('dlr.layouts.app')

@section('title', 'Add Project')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
<style>
    .modal {
        --bs-modal-width: 1000px;
    }
</style>
@endpush

@section('content')

{{-- Back --}}
<div class="sidebodyback my-3" onclick="window.history.back()">
    <div class="backhead">
        <h5><i class="fas fa-arrow-left"></i></h5>
        <h6>Add Project Form</h6>
    </div>
</div>

{{-- Header --}}
<div class="sidebodyhead my-3">
    <h4 class="m-0">Project Details</h4>
</div>

<form id="form_data"
      method="POST"
      action="{{ route('project.store') }}"
      onsubmit="pro_sub(this); return false;">

    @csrf

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Title <span>*</span></label>
                <input type="text" name="title" class="form-control" required autofocus>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Branch <span>*</span></label>
                <input type="text" name="branch" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Building Type <span>*</span></label>
                <select name="buildtype" id="buildtype" class="form-select" required>
                    @foreach($buildingTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Budget <span>*</span></label>
                <input type="text" name="budget" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="1"></textarea>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Radius (Eg - 1000 m)</label>
                <input type="number" name="radius" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Start Date <span>*</span></label>
                <input type="date" name="startdate" id="startdate" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>End Date <span>*</span></label>
                <input type="date" name="enddate" id="enddate" class="form-control" required>
            </div>

        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" id="sub_btn" class="formbtn">Submit</button>
    </div>
</form>

{{-- Preview Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background-color:#F8E528">
            <div class="modal-header border-0">
                <h4>Project Details (Preview)</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="sub_prv"></div>
            <div class="modal-footer justify-content-center border-0">
                <button class="formbtn" data-bs-dismiss="modal">Close</button>
                <button class="formbtn" id="prv_save">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
