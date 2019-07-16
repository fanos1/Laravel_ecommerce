<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    protected $guarded = ['id'];


    public function	categories()
	{
		return	$this->belongsToMany('App\Category')->withTimestamps();
	}

	// $this product HAS MANY comments :: Binding FK is product_id
	public function comments() 
	{
		return	$this->hasMany('App\Comment', 'product_id'); // FK in APP/COMMENT table :: hasMANY
	}
	
	
	
	// this product belongs to Cart
	public function	cart()
	{
		// return $this->hasMany('App\Cart', 'product_id'); // ok
		return $this->hasMany('App\Cart'); // ok :: Laravel automatically associates with 'product_id' FK:
	}

	// this product IS ASSOCIATED ONLY WITH 1 SIZE : belongsTo()
	public function size()
	{		
		// walnuts can have size 100g, or 750g
		return $this->belongsTo('App\Size');// FK: is inside the APP\PRODUCT table (size_id)

		// But, we don't have size_id INSIDE app\SIZE ??? 
		// this is belongsTo()
	}

	// a Product belongs to mANY in many ORDERcONET
	public function ordercontents()
    {
        return $this->belongsToMany('App\OrderContent');
    }

	
}
