<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
   
    
    protected $fillable = ['file'];

    
    
    public function getfileAttribute($photo){
         
        return $this->uploads . $photo;

    }


    
}
