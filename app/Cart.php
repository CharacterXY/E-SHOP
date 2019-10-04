<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    public $items;
    public $totalQuantity;
    public $totalPrice;
    public $discount;

    public function __construct($prevCart){

        if($prevCart != null){

            $this->items = $prevCart->items;
            $this->totalQuantity = $prevCart->totalQuantity;
            $this->totalPrice = $prevCart->totalPrice;
            $this->discount = $prevCart->discount;

        } else {
            $this->items = [];
            $this->totalQuantity = 0;
            $this->totalPrice = 0;
            $this->discount = 0;
        }
    }


        public function addItem($id, $product){
              
            $price = (int) str_replace("€", "", $product->price);
            // provjerava ima li stvari
            if(array_key_exists($id, $this->items)){

                $productToAdd = $this->items[$id];
                $productToAdd['quantity']++;
                $productToAdd['totalSinglePrice'] = $productToAdd['quantity'] * $price;
                 // dodavam prvi proizvod u kosaricu
            } else {
                 
                $productToAdd = ['quantity'=> 1, 'totalSinglePrice' => $price, 'data' => $product];
            }

            $this->items[$id] = $productToAdd;
            $this->totalQuantity++;
            $this->totalPrice = $this->totalPrice + $price;
            $this->discount = 0;

        }

    
        public function updatePriceAndQuantity(){

            $totalPrice = 0;
            $totalQuantity = 0;

            foreach($this->items as $item){

                $totalQuantity = $totalQuantity + $item['quantity'];
                $totalPrice = $totalPrice + $item['totalSinglePrice'];

        }

        $this->totalPrice = $totalPrice;
        $this->totalQuantity = $totalQuantity;
    }

       
    
}
