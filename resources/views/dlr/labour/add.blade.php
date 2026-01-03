@extends('dlr.layouts.app')

@section('title', 'Add Labour')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
@endpush

@section('content')

    <div class="sidebodyback my-3" onclick="history.back()">
        <h6><i class="fas fa-arrow-left"></i> Add Labour</h6>
    </div>

    <form action="{{ route('labour.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <div class="col-md-4 mb-3">
                <label>Labour Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Contact</label>
                <input type="text" name="lab_con" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Trade</label>
                <select name="trade" class="form-select">
                    @foreach ($trades as $t)
                        <option value="{{ $t->id }}">{{ $t->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Aadhar No</label>
                <input type="text" name="id_proof" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Aadhar Front</label>
                <input type="file" name="fimage" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>Aadhar Back</label>
                <input type="file" name="bimage" class="form-control">
            </div>

        </div>

        <button class="formbtn">Save Labour</button>

    </form>

@endsection

@push('scripts')
    <script>
        console.log('Labour page loaded');
    </script>
@endpush
