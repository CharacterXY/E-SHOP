<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'images', 'price', 'type'
    ];

     public function getPriceAttribute($value){
            
        $price = '€'. $value;

        return $price;
    }
 

   
}
