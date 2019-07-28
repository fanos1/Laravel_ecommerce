<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];


	// this Cart has Many products
	public function product() 
	{		
		return	$this->belongsTo('App\Product', 'product_id'); // Cart.incindeki product_id FK	
	}

}
