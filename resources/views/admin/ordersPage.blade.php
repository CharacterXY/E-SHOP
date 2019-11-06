@extends('layouts.admin')

@section('body')

<h1>Orders History</h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#order_id</th>
                <th>Date</th>
                <th>Deliviry Date</th>
                <th>Price</th>
                <th>user_id</th>
                <th>Status</th>
                <th>Remove</th>
                
            </tr>
        </thead>
        <tbody>
        
        
          @foreach($orders as $order)

            <tr>
                <td>{{$order->order_id}}</td>
                <td>{{$order->date}}</td>
                <td>{{$order->deliviry_date}}</td>
                <td>{{$order->price}}</td>
                <td>{{$order->user_id}}</td>
                <td>{{$order->status == 'paid'? 'Korisnik je platio': 'Ceka se transakcija'}}</td>
                <td><a class="btn btn-danger" href="{{route('deleteOrder', ['id' => $order->order_id])}}" onclick="return confirm('Do you wanna delete order ?')">Remove</a></td>
            </tr>

          @endforeach
        </tbody>
    </table>
    {{$orders->links()}}
</div>

@endsection
            
           

    