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


// Administrator Dashboard

Route::get('admin/products', ["uses" => "Admin\AdminProductsController@index", "as" => "adminDisplayProducts"])->middleware('admin');

Route::get('admin/products/{id}', ["uses" => "Admin\AdminProductsController@destroy", "as" => "deleteProduct"]);


Route::get('admin/editProduct/{id}', ["uses" => "Admin\AdminProductsController@editProduct", "as" => "adminEditProduct"]);

Route::get('admin/editProductImage/{id}', ["uses" => "Admin\AdminProductsController@editProductImage", "as" => "adminEditProductImage"]);


Route::post('admin/updateProductImage/{id}', ["uses" => "Admin\AdminProductsController@updateProductImage", "as" => "adminUpdateProductImage"]);

Route::post('admin/updateProduct/{id}', ["uses" => "Admin\AdminProductsController@updateProduct", "as" => "adminUpdateProduct"]);

// 
Route::get('admin/createProductForm', ["uses" => "Admin\AdminProductsController@createProductForm", "as" => "adminCreateProductForm"]);

// send product data to database

Route::post('admin/sendCreateProductForm/', ["uses" => "Admin\AdminProductsController@sendCreateProductForm", "as" => "adminSendCreateProductForm"]);

Route::get('/storagedisk', function(){

    print_r(Storage::disk('local')->exists("public/product_images/senzacijajeto.jpg"));
});