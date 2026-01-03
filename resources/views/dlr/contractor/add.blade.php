@extends('dlr.layouts.app')

@section('title', 'Add Contractor')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<style>
.modal { --bs-modal-width: 1000px; }
</style>
@endpush

@section('content')
<div class="sidebodydiv mb-3">
    <div class="sidebodyback my-3" onclick="window.history.back()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Add Contractor Form</h6>
        </div>
    </div>
    <div class="sidebodyhead my-3">
        <h4 class="m-0">Contractor Details</h4>
    </div>

    <form action="{{ route('contractor.add') }}" method="POST" enctype="multipart/form-data" id="form_data">
        @csrf
        <div class="container-fluid maindiv">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="cpn">Contractor Person Name <span>*</span></label>
                    <input type="text" class="form-control" name="cpn" id="cpn" placeholder="Enter Contractor Person Name" value="{{ old('cpn') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cbn">Contractor Business Name</label>
                    <input type="text" class="form-control" name="cbn" placeholder="Enter Contractor Business Name" value="{{ old('cbn') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mail">Email ID</label>
                    <input type="email" class="form-control" name="mail" placeholder="Enter Email ID" value="{{ old('mail') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="contact">Contact Number <span>*</span></label>
                    <input type="text" class="form-control" name="contact" placeholder="Enter Contact Number" value="{{ old('contact') }}" maxlength="10" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="taxid">Tax ID / SSN</label>
                    <input type="text" class="form-control" name="taxid" placeholder="Enter Tax ID / SSN" value="{{ old('taxid') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="conttype">Contractor Type <span>*</span></label>
                    <select name="conttype" class="form-select" required>
                        <option value="">Select Type</option>
                        @foreach($contractorTypes as $type)
                            <option value="{{ $type->id }}" {{ old('conttype') == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="contdur">Contract Duration <span>*</span></label>
                    <input type="text" class="form-control" name="contdur" placeholder="Enter Contract Duration" value="{{ old('contdur') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="b_name">Bank Name <span>*</span></label>
                    <input type="text" class="form-control" name="b_name" placeholder="Enter Bank Name" value="{{ old('b_name') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="b_branch">Branch <span>*</span></label>
                    <input type="text" class="form-control" name="b_branch" placeholder="Enter Branch" value="{{ old('b_branch') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ac_name">A/C Name <span>*</span></label>
                    <input type="text" class="form-control" name="ac_name" placeholder="Enter Account Holder Name" value="{{ old('ac_name') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ac_no">A/C No <span>*</span></label>
                    <input type="text" class="form-control" name="ac_no" placeholder="Enter Account No" value="{{ old('ac_no') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ifsc">IFSC Code <span>*</span></label>
                    <input type="text" class="form-control" name="ifsc" placeholder="Enter IFSC code" value="{{ old('ifsc') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="gst">GST <span>*</span></label>
                    <input type="text" class="form-control" name="gst" placeholder="Enter GST" value="{{ old('gst') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="pan">PAN Card <span>*</span></label>
                    <input type="text" class="form-control" name="pan" placeholder="Enter PAN Card" value="{{ old('pan') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="image">Upload License / Certification <span>*</span></label>
                    <input type="file" class="form-control" name="image" required>
                </div>
            </div>
        </div>

        <div class="sidebodyhead my-3">
            <h4 class="m-0">Professional Preference</h4>
        </div>
        <div class="container-fluid maindiv">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="name">Name <span>*</span></label>
                    <input type="text" class="form-control" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cinfo">Contact Info <span>*</span></label>
                    <input type="text" class="form-control" name="cinfo" placeholder="Enter Contact Info" value="{{ old('cinfo') }}" required>
                </div>
            </div>
        </div>

        <div class="col-md-12 d-flex justify-content-center">
            <button type="submit" class="formbtn">Submit</button>
        </div>
    </form>
</div>
@endsection
