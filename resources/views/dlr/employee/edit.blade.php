@extends('dlr.layouts.app')

@section('title', 'Edit Employee')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endpush

@section('content')

{{-- Back --}}
<div class="sidebodyback my-3" onclick="window.history.back()">
    <div class="backhead">
        <h5><i class="fas fa-arrow-left"></i></h5>
        <h6>Edit Employee Form</h6>
    </div>
</div>

<form method="POST"
      action="" {{-- {{ route('employee.update', $employee->id) }} --}}
      enctype="multipart/form-data">

    @csrf

    {{-- PERSONAL DETAILS --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Personal Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Code</label>
                <input type="text"
                       class="form-control"
                       value="{{ old('code', $employee->code ?? '') }}"
                       readonly>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Full Name</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $employee->name ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Email ID</label>
                <input type="email"
                       name="mail"
                       class="form-control"
                       value="{{ old('mail', $employee->mail ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Contact Number</label>
                <input type="number"
                       name="contact"
                       class="form-control"
                       value="{{ old('contact', $employee->contact ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Leave blank to keep existing">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Aadhar Number</label>
                <input type="number"
                       name="aadhar"
                       class="form-control"
                       value="{{ old('aadhar', $employee->aadhar ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>PAN Number</label>
                <input type="text"
                       name="pan"
                       class="form-control"
                       value="{{ old('pan', $employee->pan ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Profile Image</label>
                <input type="file" name="image" class="form-control">
                @if(!empty($employee->image))
                    <small class="text-muted">Current image exists</small>
                @endif
            </div>

        </div>
    </div>

    {{-- JOB DETAILS --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Job Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Designation</label>
                <select name="designation" class="form-select">
                    <option value="">Select</option>
                    @foreach($designations as $des)
                        <option value="{{ $des->id }}"
                            {{ old('designation', $employee->designation ?? '') == $des->id ? 'selected' : '' }}>
                            {{ $des->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Experience</label>
                <input type="text"
                       name="experience"
                       class="form-control"
                       value="{{ old('experience', $employee->experience ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Joining Date</label>
                <input type="date"
                       name="jdate"
                       class="form-control"
                       value="{{ old('jdate', $employee->jdate ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Employment Type</label>
                <select name="emptype" class="form-select">
                    <option value="">Select</option>
                    @foreach($empTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ old('emptype', $employee->emptype ?? '') == $type->id ? 'selected' : '' }}>
                            {{ $type->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Location</label>
                <input type="text"
                       name="location"
                       class="form-control"
                       value="{{ old('location', $employee->location ?? '') }}">
            </div>

        </div>
    </div>

    {{-- BANK DETAILS --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Bank Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Bank Name</label>
                <input type="text"
                       name="bankname"
                       class="form-control"
                       value="{{ old('bankname', $employee->bankname ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Account Number</label>
                <input type="text"
                       name="acctnum"
                       class="form-control"
                       value="{{ old('acctnum', $employee->acctnum ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>IFSC Code</label>
                <input type="text"
                       name="ifsc"
                       class="form-control"
                       value="{{ old('ifsc', $employee->ifsc ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Branch</label>
                <input type="text"
                       name="branch"
                       class="form-control"
                       value="{{ old('branch', $employee->branch ?? '') }}">
            </div>

        </div>
    </div>

    {{-- ADDRESS DETAILS --}}
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Address Details</h4>
    </div>

    <div class="container-fluid maindiv">
        <div class="row">

            <div class="col-md-4 mb-3 inputs">
                <label>Address Line 1</label>
                <input type="text"
                       name="address1"
                       class="form-control"
                       value="{{ old('address1', $employee->address1 ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>Address Line 2</label>
                <input type="text"
                       name="address2"
                       class="form-control"
                       value="{{ old('address2', $employee->address2 ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>City</label>
                <input type="text"
                       name="city"
                       class="form-control"
                       value="{{ old('city', $employee->city ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>District</label>
                <input type="text"
                       name="district"
                       class="form-control"
                       value="{{ old('district', $employee->district ?? '') }}">
            </div>

            <div class="col-md-4 mb-3 inputs">
                <label>State</label>
                <input type="text"
                       name="state"
                       class="form-control"
                       value="{{ old('state', $employee->state ?? '') }}">
            </div>

        </div>
    </div>

    <div class="text-center my-4">
        <button type="submit" class="formbtn">Update</button>
    </div>

</form>

@endsection
