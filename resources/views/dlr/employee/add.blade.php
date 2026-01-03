@extends('dlr.layouts.app')

@section('title', 'Add Employee')

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

{{-- Back Button --}}
<div class="sidebodyback my-3" onclick="window.history.back()">
    <div class="backhead">
        <h5><i class="fas fa-arrow-left"></i></h5>
        <h6>Add Employee Form</h6>
    </div>
</div>

{{-- Personal Details --}}
<div class="sidebodyhead my-3">
    <h4 class="m-0">Personal Details</h4>
</div>

<form id="form_data"
      method="POST"
      action="{{ route('employee.store') }}"
      enctype="multipart/form-data"
      onsubmit="form_sub(this); return false;">

    @csrf

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Code <span>*</span></label>
                <input type="text" name="code" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Full Name <span>*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Email ID <span>*</span></label>
                <input type="email" name="mail" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Contact Number <span>*</span></label>
                <input type="number" name="contact" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Password <span>*</span></label>
                <input type="password" name="password" minlength="6" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Aadhar Number <span>*</span></label>
                <input type="number" name="aadhar" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>PAN Number <span>*</span></label>
                <input type="text" name="pan" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Profile Image <span>*</span></label>
                <input type="file" name="image" class="form-control" required>
            </div>

        </div>
    </div>

    {{-- Job Details --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Job Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Designation</label>
                <select name="designation" id="designation" class="form-select">
                    @foreach($designations as $des)
                        <option value="{{ $des->id }}">{{ $des->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Experience <span>*</span></label>
                <input type="text" name="experience" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Joining Date <span>*</span></label>
                <input type="date" name="jdate" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Employment Type <span>*</span></label>
                <select name="emptype" id="emptype" class="form-select" required>
                    @foreach($empTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Location <span>*</span></label>
                <input type="text" name="location" class="form-control" required>
            </div>

        </div>
    </div>

    {{-- Address Details --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Address Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Address Line 1 <span>*</span></label>
                <input type="text" name="address1" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Address Line 2</label>
                <input type="text" name="address2" class="form-control">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>City <span>*</span></label>
                <input type="text" name="city" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>District <span>*</span></label>
                <input type="text" name="district" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>State <span>*</span></label>
                <input type="text" name="state" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Pincode <span>*</span></label>
                <input type="number" name="pin" class="form-control" required>
            </div>

        </div>
    </div>

    <div class="text-center my-4">
        <button type="submit" id="sub_btn" class="formbtn">Submit</button>
    </div>

</form>

{{-- Preview Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Employee Details (Preview)</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="sub_prv"></div>
            <div class="modal-footer justify-content-center">
                <button class="formbtn" data-bs-dismiss="modal">Close</button>
                <button class="formbtn" id="prv_save">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
