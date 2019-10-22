@extends('layouts.admin')

@section('body')

<div class="table-responsive" class="col-sm-3">

    <form action="/admin/updateUser/{{$user->id}}" method="post">

        {{csrf_field()}}
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" placeholder="User name" value="{{$user->name}}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" placeholder="Email" id="description" value="{{$user->email}}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="password" vlaue="{{ $user->password }}">
        </div>
        <div class="form-group">
            <label for="is_active">Status :</label>
            <select name="is_active" id="is_active">
                <option value="0">Not Active</option>
                <option value="1">Active</option>
                <option value="2">Blocked</option>
            </select>
        </div>
        <div class="form-group">
                <label for="role">Role :</label>
                <select name="role_id" id="role_id">
                    <option value="1">Administrator</option>
                    <option value="2">Regular User</option>
                </select>
            </div>
        <hr />


        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

@endsection