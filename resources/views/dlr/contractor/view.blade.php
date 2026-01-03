@extends('dlr.layouts.app')

@section('title', 'View Contractor')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')

<div class="sidebodydiv mb-3">

    {{-- Back Header --}}
    <div class="sidebodyback my-3 d-flex justify-content-between align-items-center">
        <div class="backhead d-flex align-items-center" onclick="window.history.back()" style="cursor:pointer;">
            <h5 class="m-0"><i class="fas fa-arrow-left"></i></h5>
            <h6 class="m-0 ms-2">Contractor Details</h6>
        </div>

        <a href="{{ route('contractor.edit') }}">
            <button class="headbtn">Edit Details</button>
        </a>
    </div>

    <div class="mainbdy">
        <div class="leftcntnt">

            {{-- Contractor Details --}}
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Contractor Details</h4>
            </div>

            <div class="container-fluid leftct">
                <div class="row">

                    @php
                        function showVal($val) {
                            return $val ?: '—';
                        }
                    @endphp

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contact Person Name</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->name ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contact Business Name</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->bus_name ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Email ID</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->mail ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contact Number</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->con_num ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Tax ID / SSN</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->tax ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contract Type</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">
                            {{ optional($contractor->contractType ?? 'name')->title ?? '—' }}
                        </h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contract Duration</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->duration ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Bank Name</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->b_name ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Branch</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->b_branch ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">A/c Name</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->ac_name ?? 'name' ?? 'name' ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">A/c No</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->ac_no ?? 'name' ?? 'name' ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">IFSC</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->ifsc ?? 'name' ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">GST</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->gst ?? 'name' ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Pan Card</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->pan ?? 'name' ?? 'name') }}</h6>
                    </div>

                    {{-- File --}}
                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Upload License / Certification</h6>
                        <h6 class="txtblack">:</h6>

                        @if(!empty($contractor->file) && $contractor->file !== 'No file')
                            <a href="{{ asset('docs/'.$contractor->file) }}" download>
                                <img src="{{ asset('docs/'.$contractor->file) }}" height="150">
                            </a>
                        @else
                            <h6 class="txtblack">No file</h6>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Professional Reference --}}
            <div class="sidebodyhead my-3">
                <h4 class="m-0">Professional Reference</h4>
            </div>

            <div class="container-fluid leftct">
                <div class="row">
                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Name</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->pro_name ?? 'name') }}</h6>
                    </div>

                    <div class="col-12 mb-2">
                        <h6 class="txtgray">Contact Info</h6>
                        <h6 class="txtblack">:</h6>
                        <h6 class="txtblack">{{ showVal($contractor->pro_contact ?? 'name') }}</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
