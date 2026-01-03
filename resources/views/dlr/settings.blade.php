@extends('dlr.layouts.app')

@section('title','Category Settings')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/list.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
@endpush

@section('content')

<div class="sidebodyback my-3" onclick="history.back()">
    <h6><i class="fas fa-arrow-left"></i> Add Category Form</h6>
</div>

<h4>Category Details</h4>

<form method="POST" action="{{ route('settings.store') }}">
@csrf
<div class="row">
    <div class="col-md-4 mb-3">
        <label>Category Type</label>
        <select name="cat_type" class="form-select" required>
            <option disabled selected>Select Options</option>
            <option>Designation</option>
            <option>Employee Type</option>
            <option>Building Type</option>
            <option>Labour Designation</option>
            <option>Contractor Type</option>
            <option>Trade</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label>Title</label>
        <input name="title" class="form-control" required>
    </div>
</div>

<button class="formbtn">Submit</button>
</form>

<hr>

<h4>Category List</h4>

<table class="table example">
<thead>
<tr>
    <th>#</th>
    <th>Category</th>
    <th>Title</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($categories as $i=>$cat)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $cat->cat }}</td>
    <td>{{ $cat->title }}</td>
    <td>
        <a class="e_cat" data-id="{{ $cat->id }}" data-bs-toggle="modal" data-bs-target="#edit_popup">
            <i class="fa fa-edit"></i>
        </a>

        <form method="POST" action="{{ route('settings.delete',$cat->id) }}" style="display:inline">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Delete?')" style="border:none;background:none">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>

{{-- Modal --}}
<div class="modal fade" id="edit_popup">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="{{ route('settings.update') }}">
@csrf
<div class="modal-body">

<select name="edit_cat_type" id="edit_cat_option" class="form-select mb-3"></select>
<input name="edit_cat_title" id="edit_cat_title" class="form-control mb-3">
<input type="hidden" name="cat_id" id="cat_id">

</div>
<div class="modal-footer">
<button class="modalbtn">Update</button>
</div>
</form>
</div>
</div>
</div>

@endsection

@push('scripts')
<script>
$('.e_cat').on('click',function(){
    $.post("{{ route('settings.get') }}",
    {_token:"{{ csrf_token() }}", edit_cat:$(this).data('id')},
    function(data){
        $('#edit_cat_option').val(data.cat);
        $('#edit_cat_title').val(data.title);
        $('#cat_id').val(data.id);
    });
});
</script>
@endpush
