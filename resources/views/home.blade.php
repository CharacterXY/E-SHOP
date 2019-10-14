@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                   
                    <h4 class="text-center">Hi {!! Auth::user()->name !!}, Welcome back to our community</h4>
                    <div class="user_info">
                        <div class="text-center">
                            <p>You 're member since</p><span>
                            <p>{!! Auth::user()->created_at !!}</p></span>
                        </div>
                        <a class="btn btn-danger" href="{{route('allProducts')}}">Main Website</a>

                    
                        <a class="btn btn-danger" href="{{route('adminDisplayProducts')}}">Admin Dashboard</a>
                    
                    </div>
                                  
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
