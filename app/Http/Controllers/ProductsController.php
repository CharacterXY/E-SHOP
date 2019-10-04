<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    //
    public function index(){

      $products = Product::all();

      return view('allproducts', compact('products'));
   }


     public function addProductToCart(Request $request, $id){

      $prevCart = $request->session()->get('cart');
      $cart = new Cart($prevCart);

      $product = Product::findOrFail($id);
      $cart->addItem($id, $product);
      $request->session()->put('cart', $cart);
      

      return redirect()->route('allProducts');

    
   }

   public function showCart(){
             
      $cart = Session::get('cart');

         if($cart){
             //($cart);
            return view('cartproducts', ['cartItems' => $cart]);
        
         } else {
        
           //echo "kartica je prazna";
   
           return redirect()->route('allProducts');
           
         }
        
   }

   public function deleteCartItem(Request $request, $id){

      $cart = $request->session()->get('cart');

      if(array_key_exists($id, $cart->items)){
         
         unset($cart->items[$id]);
         //echo "<b>Vas produkt je izbrisan</b>";

      }

      $prevCart = $request->session()->get('cart');
      $updatedCart = new Cart($prevCart);
      $updatedCart->updatePriceAndQuantity();

      $request->session()->put('cart', $updatedCart);

      return redirect()->back()->with('success', ['Item has been successfully deleted !']);


   }



        

      
}
