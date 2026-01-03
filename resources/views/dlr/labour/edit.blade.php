@extends('dlr.layouts.app')
@section('title', 'Edit Labour')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">

@section('content')

    <div class="sidebodyback my-3" onclick="history.back()">
        <h6><i class="fas fa-arrow-left"></i> Edit Labour</h6>
    </div>

    <form method="POST" action="{{ route('labour.update') }}" enctype="multipart/form-data">
        @csrf
        {{-- <input type="hidden" name="lab_id" value="{{ $labour->id }}"> --}}

        <div class="row">

            <div class="col-md-4 mb-3">
                <label>Project</label>
                <select name="project" class="form-select">
                    @foreach ($projects as $p)
                        <option value="{{ $p->id }}" {{ $labour->pro_id == $p->id ? 'selected' : '' }}>
                            {{ $p->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Contractor</label>
                <select name="cont" class="form-select">
                    @foreach ($contractors as $c)
                        <option value="{{ $c->id }}" {{ $labour->con_id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Labour Name</label>
                <input name="name" class="form-control" value="{{ $labour->lab_name ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Contact</label>
                <input name="lab_con" class="form-control" value="{{ $labour->lab_con ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Trade</label>
                <select name="designation" class="form-select">
                    @foreach ($trades as $t)
                        <option value="{{ $t->id }}" {{ $labour->desgination == $t->id ? 'selected' : '' }}>
                            {{ $t->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Medical No</label>
                <input name="medicalno" class="form-control" value="{{ $labour->med_no ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Safety Card</label>
                <input name="safetycard" class="form-control" value="{{ $labour->saf_no ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Unit Rate</label>
                <input name="unit" class="form-control" value="{{ $labour->unit ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>NMR</label>
                <input name="nmr" class="form-control" value="{{ $labour->nmr ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Induction Renewal</label>
                <input type="date" name="ind_ren" class="form-control" value="{{ $labour->induction_ren ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>ID Proof</label>
                <input name="id_proof" class="form-control" value="{{ $labour->id_proof ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Remarks</label>
                <textarea name="remarks" class="form-control">{{ $labour->remark ?? '' }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label>Induction Date</label>
                <input type="date" name="dateind" class="form-control" value="{{ $labour->induction_date ?? '' }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Joining Date</label>
                <input type="date" name="datejoin" class="form-control" value="{{ $labour->doj ?? '' }}">
            </div>

            {{-- Images --}}
            <div class="col-md-4 mb-3">
                <label>Aadhar Front</label>
                <input type="file" name="fimage" class="form-control">
                {{-- <img src="{{ $bucket_link.$files['fimage']->file ?? '' }}" width="250"> --}}
            </div>

            <div class="col-md-4 mb-3">
                <label>Aadhar Back</label>
                <input type="file" name="bimage" class="form-control">
                {{-- <img src="{{ $bucket_link.$files['bimage']->file ?? '' }}" width="250"> --}}
            </div>

            <div class="col-md-4 mb-3">
                <label>Profile Photo</label>
                {{-- <img src="{{ $bucket_link.$files['image']->file ?? '' }}" width="250"> --}}
            </div>

        </div>

        <button class="formbtn">Update</button>

    </form>
@endsection
