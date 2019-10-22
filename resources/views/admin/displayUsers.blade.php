@extends('layouts.admin')

@section('body')

  @if($users)

  <div class="container">
      <div class="card-content">
          <div class="card-body">
              @include('flash-message')
          </div>
      </div>
  </div>
  
 
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
            <th>Picture</th>
            <th>Name</th>
            <th>Email</th>
            <th>Active Status</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Edit User Image</th>
            <th>Edit User Data</th>
            <th>Delete User</th>
         
        </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
        <tr>
             <td>{{$user->id}}</td>
        <td><img class="slika" src="{{asset('storage')}}/users_image/{{$user->image}}" width="100" height="100" style="max-height:200px" alt="{{asset('storage')}}/users_image/{{$user->image}}"></img></td>              
             <td>{{$user->name}}</td>
             <td>{{$user->email}}</td>
             <td>{{$user->is_active == 1 ? 'Active' : 'Not Active'}}</td>
             <td>{{$user->role_id == 1 ? 'Administrator' : 'Regular User'}}</td>
             <td>{{$user->created_at}}</td>
             <td>{{$user->updated_at}}</td>

           <td><a class="btn btn-primary" href="{{route('adminEditUserImage', [$user->id])}}">Edit Image</a></td>
           <td><a class="btn btn-success" href="{{route('adminEditUser', [$user->id])}}">Edit</a></td>
           <td><a class="btn btn-danger" href="{{route('deleteUser', [$user->id])}}">Remove</a></td>


        </tr>

        @endforeach
        @endif





        </tbody>
    </table>
    
   <div class="container" class="col-md-6">
      <div class="text-center">{{ $users->links() }}</div>
    </div> 
 

</div>
@endsection