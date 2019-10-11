@extends('layouts.admin')

@section('body')

<div class="table-responsive">

    <form action="/admin/updateProduct/{{$product->id}}" method="post">

        {{csrf_field()}}
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Product name" value="{{$product->name}}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="description" id="description" value="{{$product->description}}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" name="type" id="type" placeholder="type" vlaue="{{ $product->type }}" required>
        </div>
        <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control" name="price" id="price" placeholder="price"{{ $product->price }}" required>
        </div>
        <button type="submit" name="submit" class="btn btn-default">Submit</button>
    </form>
</div>
@endsection