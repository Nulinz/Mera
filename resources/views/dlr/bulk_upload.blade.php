@extends('dlr.layouts.app')

@section('title', 'Add Bulk Upload Labour')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
@endpush

@section('content')
<div class="sidebodydiv mb-3">
    <div class="sidebodyback my-3 d-flex align-items-center" onclick="window.history.back()" style="cursor:pointer;">
        <div class="backhead d-flex align-items-center">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6 class="m-0 ms-2">Add Bulk Upload Labour Form</h6>
        </div>
    </div>

    <div class="sidebodyhead my-3 d-flex justify-content-between align-items-center">
        <h4 class="m-0">Bulk Upload Labour Details</h4>
        <a href="{{ asset('assets/sample/sample_bulk.csv') }}" download>Sample</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="" method="POST" enctype="multipart/form-data"> {{-- {{ route('labour.bulk.store') }} --}}
        @csrf
        <div class="container-fluid maindiv">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="project">Project <span>*</span></label>
                    <select name="project" id="project" class="form-select" required autofocus>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="contractor">Contractor <span>*</span></label>
                    <select name="cont" id="cont" class="form-select" required>
                        @foreach ($contractors as $contractor)
                            <option value="{{ $contractor->id }}">{{ $contractor->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="trade">Trade <span>*</span></label>
                    <select name="trade" id="trade" class="form-select" required>
                        @foreach ($trades as $trade)
                            <option value="{{ $trade->id }}">{{ $trade->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="file_excel">File <span>*</span></label>
                    <input type="file" class="form-control" name="file_excel" id="file_excel" required>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-center align-items-center gap-2 mt-3">
            <button type="submit" class="formbtn">Submit</button>
        </div>
    </form>
</div>
@endsection
