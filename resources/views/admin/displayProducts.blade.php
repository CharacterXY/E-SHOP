@extends('layouts.admin')

@section('body')

  @if($products)
 
<style>

.slika {
  border-radius: 50%;
  
}
</style>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#id</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Price</th>
            <th>Edit Image</th>
            <th>Edit</th>
            <th>Remove</th>
        </tr>
        </thead>
        <tbody>

        @foreach($products as $product)
        <tr>
             <td>{{$product->id}}</td>
             <td><img class="slika" src="{{asset('storage')}}/product_images/{{$product->image}}" alt="{{asset ('storage')}}/product_images/{{$product['image']}}" width="100" height="100" style="max-height:220px" ></td> 
             <td>{{$product->name}}</td>
             <td>{{$product->description}}</td>
             <td>{{$product->type}}</td>
             <td>{{$product->price}}</td>

           <td><a class="btn btn-primary" href="{{route('adminEditProductImage', [$product->id])}}">Edit Image</a></td>
           <td><a class="btn btn-success" href="{{route('adminEditProduct', [$product->id])}}">Edit</a></td>
           <td><a class="btn btn-danger" href="{{route('deleteProduct', [$product->id])}}">Remove</a></td>


        </tr>

        @endforeach
        @endif





        </tbody>
    </table>
    
    <div class="container" class="col-md-6">
      <div class="text-center">{{ $products->links() }}</div>
    </div>


</div>
@endsection