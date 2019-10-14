<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    //
    public function index(){

      $products = Product::paginate(3);

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




   public function menProducts(){

      $filterProducts = DB::table('products')->where('type', 'Men')->get();

      return view("menProducts", compact("filterProducts"));
   }




   public function womenProducts(){

      $filterProducts = DB::table('products')->where('type', 'Women')->get();

      return view('womenProducts', compact('filterProducts'));
   }




   public function searchInputText(Request $request){

      $data = $request->get('searchInputText');

      $products = Product::where('name', "Like", $data."%")->paginate(2);

      return view('allproducts', compact('products'));
   
   }




   public function increaseProduct(Request $request, $id){

      $prevCart = $request->session()->get('cart');
      $cart = new Cart($prevCart);

      $product = Product::findOrFail($id);
      $cart->addItem($id, $product);
      $request->session()->put('cart', $cart);

      return redirect()->route('cartproducts');
   }




   public function decreaseProduct(Request $request, $id){

      $prevCart = $request->session()->get('cart');
      $cart = new Cart($prevCart);

      if($cart->items[$id]['quantity'] > 1){

         $product = Product::findOrFail($id);
         $cart->items[$id]['quantity'] = $cart->items[$id]['quantity'] - 1;
         $cart->items[$id]['totalSinglePrice'] = $cart->items[$id]['quantity'] * $product['price'];
         $cart->updatePriceAndQuantity();

         $request->session()->put('cart', $cart);

      }

      return redirect()->route("cartproducts");

   }



        

      
}
