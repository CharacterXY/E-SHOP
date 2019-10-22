@extends('layouts.admin')

@section('body')

{{-- @if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
 --}}
<div class="table-responsive">

    <form action="/admin/sendCreateProductForm" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

        <h2 class="text-center">Create a new product</h2>
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Product name"  required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="description" id="description"  required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" id="type" placeholder="type" required>
        </div>
        <div class="form-group">
                <label for="description">Image</label>
                <input type="file" class="" name="image" id="image" placeholder="image" required>
            </div>
        <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="price" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection