<?php

namespace App\Http\Controllers;
//use Illuminate\Support\Facades\DB;
use App\Cart;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

      $menProducts = DB::table('products')->where('type', 'Men')->get();

      return view("menProducts", compact("menProducts"));
   }

  


   public function womenProducts(){

      $womenProducts = DB::table('products')->where('type', 'Women')->get();

      return view('womenProducts', compact('womenProducts'));
   }


   public function kidsProducts(){

      $kidsProducts = DB::table('products')->where('type', 'Kids')->get();

      return view('kidsProducts', compact('kidsProducts'));
   }



   public function rearShifters(){

      $rearShifters = DB::table('products')->where('type', 'Shifters')->get();

      return view('rearShifters', compact('rearShifters'));
   }




   public function searchInputText(Request $request){

      $data = $request->get('searchInputText');

      $products = Product::where('name', "Like", $data."%")->paginate(2);

      return view('allproductssearch', compact('products'));
   
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



   public function createOrder(){

      $cart = Session::get('cart');

      if($cart) {
         
         //dd($cart);
         //$date = Carbon::now()->toDateTimeString();
         $date = date('Y:m:d H:i:s');
         $newOrder = array('status' => 'waiting', 'date' => $date, 'deliviry_date' => $date, 'price' => $cart->totalPrice);
         $createdOrder = DB::table('orders')->insert($newOrder);
         //var_dump($cart);

         $order_id = DB::getPdo()->lastInsertId();

         foreach($cart->items as $cart_item){
            $item_id = $cart_item['data']['id'];
            $item_name = $cart_item['data']['name'];
            $item_price = $cart->totalPrice; // $cart_items['totalSinglePrice'];
            $newItemsinOrder = array('item_id' => $item_id, 'order_id' => $order_id, 'item_name' => $item_name, 'item_price' => $item_price, 'created_at' => $date, 'updated_at' => $date);

            $createdOrderDetails = DB::table('order_details')->insert($newItemsinOrder);

         }
            /* if($createdOrderDetails){

               echo "Narucili ste proizvod !";
            } else {

               return "NO SUCCESS";
            } */

            // delete cart

            Session::forget('cart');
            Session::flush();
            return redirect()->route('allProducts')->withsuccess('Thanks for purchasing our product');

         
      } else {

         return redirect()->route('allProducts');
      }
   }


   public function createNextOrder(Request $request){

      $cart = Session::get('cart');

      //dd($cart);

      $firstName = $request->input('firstname');
      $lastName = $request->input('lastname');
      $address = $request->input('address');
      $email = $request->input('email');
      $postalCode = $request->input('postalcode');
      $phone = $request->input('phone');

      if($cart){
    
        // var_dump($cart);
         $date = date('Y-m-d H:i:s'); // spremam trenutno vrijeme i spremit cu za sad u stupac deliviry_time varijablu $date
         $newOrder = array(
            'status' => 'waiting',
            'date' => $date,
            'name' => $firstName, 
            'lastname' => $lastName, 
            'deliviry_date' => $date, 
            'email' => $email, 
            'postal_code' => $postalCode, 
            'address' => $address,
            'price' =>  $cart->totalPrice,
            'phone' => $phone

         );
         
           $createdNewOrder = DB::table('orders')->insert($newOrder);
           //var_dump($newOrder); Konacno je sve namisteno
           // dohvacanje zadnjeg ID-a
            $orderId = DB::getPdo()->lastInsertId();

            foreach($cart->items as $cart_product){
            $productId = $cart_product['data']['id'];
            $productName = $cart_product['data']['name'];
            $productPrice = $cart->totalPrice; // ulazim u classu cart i dohvacam globalnu varijablu totalPrice iz kartice
            $prepareNewProductInOrderDetails = array('item_id' => $productId, 'item_name' => $productName, 'item_price' => $productPrice, 'order_id' => $orderId);
            // var_dump($prepareNewProductInOrderDetails); radi sve.
            $createdProductInOrderDetails = DB::table('order_details')->insert($prepareNewProductInOrderDetails);

            // izbrisi session zahtjeva login ponovo da se moze uci u kosaricu
            //print_r($newOrder);
            Session::forget('cart');
            Session::flush();

            return redirect()->route('allProducts')->withsuccess('Thanks for buying product from our store !');

            
         }  
      } else {
         
         print_r('error');
      }



   }



   public function checkoutProducts(){

      return view('checkoutproducts');

   }


      
      
}