
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Checkout | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">

    <link href="{{asset ('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- scripts -->
    <script src="{{ asset ('js/jquery.min.js') }}"></script>

    <!-- Custom styles for this template -->
    <link href="{{asset ('css/dashboard.css') }}" rel="stylesheet">


    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/responsive.css')}}" rel="stylesheet">

<style>

#fix-it {
    margin-bottom: 100px !important;
}


            
</style>

@extends('layouts.index')

@section('center')

<section id="cart_items">
	<div class="container">
		<div class="breadcrumps">
			<ol class="breadcrump">
				<li><a href="{{route('allProducts')}}">Home</a></li>
				<li><a href="{{route('cartproducts')}}">Shopping Cart</a></li>
			</ol>
		</div>

		@if(Auth::check())




		<div id="shopper-informations">
			<div class="row">
				<div class="col-sm-12 clearfix">
					<div class="bill-to">
						<p>Shipping Product to [ ]</p>
						<div class="form-one">
							<form action="{{route('createNextOrder')}}" method="post" id="form-position">

								{{ csrf_field() }}
								
								<input type="text" class="form-control" name="email" placeholder="Email">
								<input type="text" class="form-control" name="firstname" placeholder="First Name">
								<input type="text" class="form-control" name="lastname" placeholder="Last Name">
								<input type="text" class="form-control" name="address" placeholder="Shipping Address">
								<input type="text" class="form-control" name="phone" placeholder=" Enter a phone number">
								<input type="text" class="form-control" name="postalcode" placeholder="Postal Code">
								<select class="form-control">
									<option>Country</option>
									<option>UK</optiion>
									<option>USA</option>
									<option>Europe</option>
									<option>Russia</option>
									<option>China</option>
									<option>India</option>
									<option>South America</option>
									<option>Canada</option>
									<option>Africa</option>
									<option>Australia</option>
									<option>New Zeland</option>
								</select>
								<button class="btn btn-primary" id="fix-it">Procceed to Payment</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		@else
		   <div class="alert alert-danger" role="alert">
			   <strong>Please! </strong><a href="{{route('login')}}"><u> Login </u> </a> in order to create an order
		   </div>
	</div>
	    @endif
						

	</div>
</section>
<style>

#fix-it {
	margin-bottom: 15px;
}

#shopper-informations{

	position: relative;
}
</style>
@endsection


