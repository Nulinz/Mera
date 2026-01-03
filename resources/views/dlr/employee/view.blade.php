@extends('dlr.layouts.app')

@section('title', 'View Employee')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
@endpush

@section('content')

{{-- BACK --}}
<div class="sidebodyback my-3" onclick="window.history.back()">
    <div class="backhead">
        <h5 class="m-0"><i class="fas fa-arrow-left"></i></h5>
        <h6 class="m-0">Employee Details</h6>
    </div>
</div>

<div class="mainbdy">

    {{-- LEFT CONTENT --}}
    <div class="leftcntnt">

        {{-- ================= PERSONAL DETAILS ================= --}}
        <div class="container-fluid leftct">
            <div class="row">

                <div class="sidebodyhead mb-3 col-12">
                    <h4 class="m-0">Personal Details</h4>
                    <button class="headbtn" data-bs-toggle="modal" data-bs-target="#modalPersonal">
                        Edit
                    </button>
                </div>

                @foreach([
                    'Code' => $employee->code ?? 'Nil',
                    'Full Name' => $employee->name ?? 'Nil',
                    'Email ID' => $employee->mail ?? 'Nil',
                    'Contact Number' => $employee->contact ?? 'Nil',
                    'Password' => $employee->pwd ?? 'Nil',
                    'Aadhar Number' => $employee->ad_no ?? 'Nil',
                    'PAN Number' => $employee->pan ?? 'Nil',
                ] as $label => $value)
                    <div class="col-12 mb-2 d-flex gap-2">
                        <h6 class="txtgray">{{ $label }}</h6>
                        <h6>:</h6>
                        <h6 class="txtblack">{{ $value }}</h6>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- ================= JOB DETAILS ================= --}}
        <div class="container-fluid leftct">
            <div class="row">

                <div class="sidebodyhead mb-3 col-12">
                    <h4 class="m-0">Job Details</h4>
                    <button class="headbtn" data-bs-toggle="modal" data-bs-target="#modalJob">
                        Edit
                    </button>
                </div>

                <div class="col-12 mb-2 d-flex gap-2">
                    <h6 class="txtgray">Designation</h6>
                    <h6>:</h6>
                    <h6 class="txtblack">{{ $employee->designation_title ?? 'Nil' }}</h6>
                </div>

                <div class="col-12 mb-2 d-flex gap-2">
                    <h6 class="txtgray">Experience</h6>
                    <h6>:</h6>
                    <h6 class="txtblack">{{ $employee->exp ?? 'Nil' }}</h6>
                </div>

                <div class="col-12 mb-2 d-flex gap-2">
                    <h6 class="txtgray">Joining Date</h6>
                    <h6>:</h6>
                    <h6 class="txtblack">
                        {{-- {{ $employee->doj ? \Carbon\Carbon::parse($employee->doj)->format('d-m-Y') : 'Nil' }} --}}
                    </h6>
                </div>

                <div class="col-12 mb-2 d-flex gap-2">
                    <h6 class="txtgray">Employment Type</h6>
                    <h6>:</h6>
                    <h6 class="txtblack">{{ $employee->emp_type_title ?? 'Nil' }}</h6>
                </div>

                <div class="col-12 mb-2 d-flex gap-2">
                    <h6 class="txtgray">Location</h6>
                    <h6>:</h6>
                    <h6 class="txtblack">{{ $employee->loc ?? 'Nil' }}</h6>
                </div>

            </div>
        </div>

        {{-- ================= ADDRESS DETAILS ================= --}}
        <div class="container-fluid leftct">
            <div class="row">

                <div class="sidebodyhead mb-3 col-12">
                    <h4 class="m-0">Address Details</h4>
                    <button class="headbtn" data-bs-toggle="modal" data-bs-target="#modalAddress">
                        Edit
                    </button>
                </div>

                @foreach([
                    'Address Line 1' => $address->ad_1 ?? 'Nil',
                    'Address Line 2' => $address->ad_2 ?? 'Nil',
                    'City' => $address->city ?? 'Nil',
                    'District' => $address->district ?? 'Nil',
                    'State' => $address->state ?? 'Nil',
                    'Pin Code' => $address->pin ?? 'Nil',
                ] as $label => $value)
                    <div class="col-12 mb-2 d-flex gap-2">
                        <h6 class="txtgray">{{ $label }}</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ $value }}</h6>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- ================= PERMISSIONS ================= --}}
        <div class="container-fluid leftct">
            <div class="row">
                <div class="sidebodyhead mb-3 col-12">
                    <h4 class="m-0">Permissions</h4>
                </div>

                <form method="POST" action=""{{-- {{ route('employees.permission.update') }} --}}>
                    @csrf

                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Module</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>

                        @php
                            $modules = ['Employee','Project','Labour','Contractor'];
                        @endphp

                        @foreach($modules as $i => $module)
                            @php
                                $types = [];
                            @endphp  {{-- $permissions[$module]?->pluck('type')->toArray() ??  --}}
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $module }}</td>
                                <td><input type="checkbox" name="create[{{ $module }}]" {{ in_array('create',$types) ? 'checked':'' }}></td>
                                <td><input type="checkbox" name="edit[{{ $module }}]" {{ in_array('edit',$types) ? 'checked':'' }}></td>
                                <td><input type="checkbox" name="delete[{{ $module }}]" {{ in_array('delete',$types) ? 'checked':'' }}></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    {{-- <input type="hidden" name="emp" value="{{ $employee->id }}"> --}}
                    <button class="headbtn">Update</button>
                </form>
            </div>
        </div>

    </div>

    {{-- RIGHT CONTENT --}}
    <div class="rightcntnt">
        @php
            $pic = asset('assets/images/avatar.png');
            if(!empty($profile?->file) && $profile->file !== 'No file'){
                $pic = $bucket_link . $profile->file;
            }
        @endphp
        <div class="pfimg">
            <img src="{{ $pic }}" class="rounded-3" height="150">
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    $('#edit_img').on('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => $('#preview').attr('src', e.target.result);
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
