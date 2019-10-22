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

Route::get('/',  ["uses" => "ProductsController@index", "as" => "allProducts"]);

// present all products with pagination
Route::get('/products', ["uses" => "ProductsController@index", "as" => "allProducts"]); 

// this route will shown one category man

Route::get('/products/men', ["uses" => "ProductsController@menProducts", "as" => "menProducts"]);

// this route will shown one category women

Route::get('/products/women', ["uses" => 'ProductsController@womenProducts', "as" => 'womenProducts']);

// kids bikes
Route::get('/products/kids', ["uses" => 'ProductsController@kidsProducts', "as" => 'kidsProducts']);

// rear shifters

Route::get('/products/shifters', ["uses" => 'ProductsController@rearShifters', "as" => 'rearShifters']);

// search input text to get data back to user

Route::get('search', ["uses" => "ProductsController@searchInputText", "as" => "allproductssearch"]); 


// add a product to cart
Route::get('/product/addToCart/{id}', ['uses' => 'ProductsController@addProductToCart', 'as' => 'AddToCartProduct']);


//show cart item
Route::get('cart', ["uses" => "ProductsController@showCart" , "as" => "cartproducts"]);


// delete item from cart
Route::get('product/deleteCartItem/{id}', ['uses' => 'ProductsController@deleteCartItem', 'as' => 'DeleteCartItem']);


// create order

Route::get('product/createOrder/', ["uses" => "ProductsController@createOrder", "as" => "createOrder"]);

// process check out page

Route::post('product/createNextOrder/', ["uses" => "ProductsController@createNextOrder", "as" => "createNextOrder"]);

//chekout products

Route::get('/product/checkoutProducts/', ["uses" => "ProductsController@checkoutProducts", "as" => "checkoutProducts"]);






// user auth
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Administrator Dashboard

Route::get('admin/products', ["uses" => "Admin\AdminProductsController@index", "as" => "adminDisplayProducts"])->middleware('admin');

Route::get('admin/users', ["uses" => "Admin\AdminUsersController@index", "as" => "adminDisplayUsers"])->middleware('admin');

Route::get('admin/editUser/{id}', ["uses" => "Admin\AdminUsersController@editUser", "as" => "adminEditUser"]);

Route::get('admin/editImage/{id}', ["uses" => "Admin\AdminUsersController@editImage", "as" => "adminEditUserImage"]);

Route::get('admin/users/{id}', ["uses" => "Admin\AdminUsersController@destroy", "as" => "adminDestroyUser"]);

Route::post('admin/updateUser/{id}', ["uses" => "Admin\AdminUsersController@update", "as" => "adminUpdateUser"]);

Route::get('admin/users/{id}', ["uses" => "Admin\AdminUsersController@destroy", "as" => "deleteUser"]);

Route::get('admin/editUserImage/{id}', ["uses" => "Admin\AdminUsersController@editImage", "as" => "adminEditUserImage"]);

Route::post('admin/updateUserImage/{id}', ["uses" => "Admin\AdminUsersController@updateUserImage", "as" => "adminUpdateUserImage"]);

Route::post('admin/updateUser/{id}', ["uses" => "Admin\AdminUsersController@updateUser", "as" => "adminUpdateUsers"]);





// delete product
Route::get('admin/products/{id}', ["uses" => "Admin\AdminProductsController@destroy", "as" => "deleteProduct"]);






// increase product

Route::get('product/increaseProduct/{id}', ["uses" => 'ProductsController@increaseProduct', 'as' => 'increaseProduct']);

Route::get('product/decreaseProduct/{id}', ["uses" => 'ProductsController@decreaseProduct', 'as' => 'decreaseProduct']);




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