@extends('dlr.layouts.app') {{-- Your main layout --}}

@section('title', 'Edit Project')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endpush

@section('content')
<div class="sidebodydiv mb-3">
    <div class="sidebodyback my-3" onclick="history.back()">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Edit Project Form</h6>
        </div>
    </div>

    <div class="sidebodyhead my-3">
        <h4 class="m-0">Project Details</h4>
    </div>

    <form action="" method="POST" id="from_datas"> {{-- {{ route('projects.update', $project->id) }} --}}
        @csrf
        <div class="container-fluid maindiv">
            <div class="row">

                {{-- Title --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="title">Title <span>*</span></label>
                    <input type="text" class="form-control" name="title" id="title"
                           placeholder="Enter Title" value="{{ old('title', $project->title ?? '') }}" required>
                </div>

                {{-- Branch --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="branch">Branch <span>*</span></label>
                    <input type="text" class="form-control" name="branch" id="branch"
                           placeholder="Enter Branch" value="{{ old('branch', $project->branch ?? '') }}" required>
                </div>

                {{-- Building Type --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="buildtype">Building Type <span>*</span></label>
                    <select name="buildtype" id="buildtype" class="form-select" required>
                        <option value="{{ $project->b_type ?? '' }}" selected>
                            {{-- {{ optional($project->buildingType)->title ?? 'Select Type' }} --}}
                        </option>
                        @foreach($buildingTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Budget --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="budget">Budget <span>*</span></label>
                    <input type="text" class="form-control" name="budget" id="budget"
                           placeholder="Enter Budget" value="{{ old('budget', $project->budget ?? '') }}" required>
                </div>

                {{-- Description --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="1"
                              placeholder="Enter Description">{{ old('description', $project->des ?? '') }}</textarea>
                </div>

                {{-- Location --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="location">Location <span>*</span></label>
                    <input type="text" class="form-control" name="location" id="location"
                           placeholder="Enter Location" value="{{ old('location', $project->loc ?? '') }}" required>
                </div>

                {{-- Radius --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="radius">Radius (Eg: 1000) <span>*</span></label>
                    <input type="text" class="form-control" name="radius" id="radius"
                           placeholder="Enter Radius" value="{{ old('radius', $project->radius ?? '') }}" required>
                </div>

                {{-- Start Date --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="startdate">Start Date <span>*</span></label>
                    <input type="date" class="form-control" name="startdate" id="startdate"
                           value="{{ old('startdate', $project->st_date ?? '') }}" required>
                </div>

                {{-- End Date --}}
                <div class="col-sm-12 col-md-4 col-xl-4 mb-3 inputs">
                    <label for="enddate">End Date <span>*</span></label>
                    <input type="date" class="form-control" name="enddate" id="enddate"
                           value="{{ old('enddate', $project->end_date ?? '') }}" required>
                </div>

            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-xl-12 d-flex justify-content-center align-items-center">
            <button type="submit" class="formbtn">Update</button>
        </div>
    </form>
</div>
@endsection
