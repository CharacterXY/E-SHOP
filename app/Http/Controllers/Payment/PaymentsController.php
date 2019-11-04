<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Product;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class PaymentsController extends Controller
{
    

    public function index(){

      $products = Product::paginate(3);

      return view('allproducts', compact('products'));
    }





    public function showPaymentPage(){

         $payment_info = Session::get('payment_info');

         if($payment_info['status'] == 'waiting'){
            return view('payment.paymentpage', ['payment_info' => $payment_info]);
         } else {
            return redirect()->route('allProducts');
         }
        /*  // delete cart
         Session::forget('cart');
         Session::flush(); */
      }




      public function storePaymentInfo($paypalPaymentID, $paypalPayerID){

         $payment_info = Session::get('payment_info');
         $order_id = $payment_info['order_id'];
         $status = $payment_info['status'];
         $paypal_payment_id = $paypalPaymentID;
         $paypal_payer_id = $paypalPayerID;


         if($status == 'waiting'){
            // create a new payment row in payments table
            $date = date('Y-m-d H:i:s');
            $newPayment = array(
               'order_id' => $order_id, 
               'date' => $date, 
               'amount' => $payment_info['price'],
               'paypal_payment_id' => $paypal_payment_id,
               'paypal_payer_id' => $paypal_payer_id
            );

            $created_order = DB::table('payments')->insert($newPayment);
            
            //update payment status in orders table to paid
            $updatedOrder = DB::table('orders')->where('order_id', $order_id)->update(['status' => 'paid']);

         }
      }



      public function showPaymentReceipt($paypalPaymentID, $paypalPayerID){
             
         if(!empty($paypalPaymentID)  && !empty($paypalPayerID)){
            // will return JSON -> contains transaction status
            $this->validate_payment($paypalPaymentID, $paypalPayerID);
            $this->storePaymentInfo($paypalPaymentID, $paypalPayerID);
            $payment_receipt = Session::get('payment_info');

            $payment_receipt['paypal_payment_id'] = $paypalPaymentID;
            $payment_receipt['paypal_payer_id'] = $paypalPayerID;

            Session::forget('payment_info');
            Session::flush(); 

            return view('payment.paymentreceipt', ['payment_receipt' => $payment_receipt]);

         } else {


            return redirect()->route('allProducts');
         }
      }







      private function validate_payment($paypalPaymentID, $paypalPayerID){

         $paypalEnv       = 'sandbox'; // Or 'production'
         $paypalURL       = 'https://api.sandbox.paypal.com/v1/'; //change this to paypal live url when you go live
         $paypalClientID  = 'AQSkPcngPK0GOmU6uPuesZAmuHQkjv1UyOw02hwa5FhYYBZNz2V04YdKout_pA4yica4jsk1G_qVI7Ml';
         $paypalSecret   =  'EP16kPw3EJPnWqsud2kxkwG6t6f3g7_gsLCmU8dq-DACE8Of1iru5cJ-m5F9sOWE_ORD0sVjKL2nM4pj';
        
    
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $paypalURL.'oauth2/token');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID.":".$paypalSecret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            $response = curl_exec($ch);
            curl_close($ch);
            
            if(empty($response)){
                return false;
            }else{
                $jsonData = json_decode($response);
                $curl = curl_init($paypalURL.'payments/payment/'.$paypalPaymentID);
                curl_setopt($curl, CURLOPT_POST, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer ' . $jsonData->access_token,
                    'Accept: application/json',
                    'Content-Type: application/xml'
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                
                // Transaction data
                $result = json_decode($response);
                
                return $result;
            }
        
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
