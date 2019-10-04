<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/products', ["uses" => "ProductsController@index", "as" => "allProducts"]); 

Route::get('/product/addToCart/{id}', ['uses' => 'ProductsController@addProductToCart', 'as' => 'AddToCartProduct']);


//show cart item
Route::get('cart', ["uses" => "ProductsController@showCart" , "as" => "cartproducts"]);


// delete item from cart
Route::get('product/deleteCartItem/{id}', ['uses' => 'ProductsController@deleteCartItem', 'as' => 'DeleteCartItem']);

// user auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
