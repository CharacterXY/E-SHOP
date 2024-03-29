<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'role_id', 'photo_id', 'photo_id'
    ];

    protected $dates = [
        'created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function role(){

        return $this->belongsTo('App\Role');
    }





    public function isAdmin(){

        if($this->role->name == 'administrator' && $this->is_active == 1)
        {
            return true;
        }
        
        return false;
    }


    
    public function getActiveStatusAttribute(){

        $status = $this->attributes['is_active'];

        if($status === 1){

            return 'Active';
       
        } else {

            return 'Not Active';
        }
    }

       


    
    
    public function photo(){

        return $this->belongsTo('App\Photo');
    }

}
