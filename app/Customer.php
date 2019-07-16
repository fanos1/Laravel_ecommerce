<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    
    protected $guarded = ['id'];

    // this CUSTOMER can has 5 many orders if he/she likes
    public function orders() {
    	return $this->hasMany('App\Order');
    }

}
