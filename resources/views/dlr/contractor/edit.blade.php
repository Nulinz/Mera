@extends('dlr.layouts.app')

@section('title', 'Edit Contractor')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endpush

@section('content')

<div class="sidebodydiv mb-3">

    {{-- Back --}}
    <div class="sidebodyback my-3" onclick="window.history.back()" style="cursor:pointer;">
        <div class="backhead">
            <h5><i class="fas fa-arrow-left"></i></h5>
            <h6>Edit Contractor Form</h6>
        </div>
    </div>

    <div class="sidebodyhead my-3">
        <h4 class="m-0">Contractor Details</h4>
    </div>

    <form method="POST"
          action="{{ route('contractor.update') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="container-fluid maindiv">
            <div class="row">

                {{-- Contractor Person Name --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Contractor Person Name <span>*</span></label>
                    <input type="text" class="form-control"
                           name="cpn"
                           value="{{ old('cpn', $contractor->name ?? '') }}" required>
                </div>

                {{-- Business Name --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Contractor Business Name</label>
                    <input type="text" class="form-control"
                           name="cbn"
                           value="{{ old('cbn', $contractor->bus_name ?? '') }}">
                </div>

                {{-- Email --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Email ID</label>
                    <input type="email" class="form-control"
                           name="mail"
                           value="{{ old('mail', $contractor->mail ?? '') }}">
                </div>

                {{-- Contact --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Contact Number <span>*</span></label>
                    <input type="number" class="form-control"
                           name="contact"
                           value="{{ old('contact', $contractor->con_num ?? '') }}" required>
                </div>

                {{-- Tax --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Tax ID / SSN</label>
                    <input type="text" class="form-control"
                           name="taxid"
                           value="{{ old('taxid', $contractor->tax ?? '') }}">
                </div>

                {{-- Contractor Type --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Contractor Type <span>*</span></label>
                    <select name="conttype" class="form-select" required>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}"
                                @selected(old('conttype', $contractor->con_type) == $type->id)>
                                {{ $type->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Contract Duration --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Contract Duration <span>*</span></label>
                    <input type="text" class="form-control"
                           name="contdur"
                           value="{{ old('contdur', $contractor->duration ?? '') }}" required>
                </div>

                {{-- Bank --}}
                @foreach(['b_name'=>'Bank Name','b_branch'=>'Branch','ac_name'=>'A/C Name','ac_no'=>'A/C No','ifsc'=>'IFSC','gst'=>'GST','pan'=>'PAN'] as $field=>$label)
                    <div class="col-md-4 mb-3 inputs">
                        <label>{{ $label }} <span>*</span></label>
                        <input type="text" class="form-control"
                               name="{{ $field }}"
                               value="{{ old($field, $contractor->$field ?? '') }}" required>
                    </div>
                @endforeach

                {{-- Image --}}
                <div class="col-md-4 mb-3 inputs">
                    <label>Profile Image</label>
                    <input type="file" name="edit_img" class="form-control">
                    <img id="preview"
                         src="" {{-- {{ $contractor->file ? asset('storage/docs/'.$contractor->file) : '' }} --}}
                         width="200" class="mt-2">
                </div>
            </div>
        </div>

        {{-- Professional Reference --}}
        <div class="sidebodyhead my-3">
            <h4 class="m-0">Professional Reference</h4>
        </div>

        <div class="container-fluid maindiv">
            <div class="row">
                <div class="col-md-4 mb-3 inputs">
                    <label>Name <span>*</span></label>
                    <input type="text" class="form-control"
                           name="name"
                           value="{{ old('name', $contractor->pro_name ?? '') }}" required>
                </div>

                <div class="col-md-4 mb-3 inputs">
                    <label>Contact Info <span>*</span></label>
                    <input type="text" class="form-control"
                           name="cinfo"
                           value="{{ old('cinfo', $contractor->pro_contact ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button class="formbtn">Update</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.querySelector('input[name="edit_img"]')?.addEventListener('change', e => {
    const reader = new FileReader();
    reader.onload = ev => document.getElementById('preview').src = ev.target.result;
    reader.readAsDataURL(e.target.files[0]);
});
</script>
@endpush
