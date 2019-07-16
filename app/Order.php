<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    // this ORDER hasOne/belongsTo 1 customer
    public function customer()
	{
		// return $this->hasOne('App\Customer','id');
	    return $this->belongsTo('App\Customer', 'customer_id');
	    //With this Relation, we should be able to use $order->customer
	}

	// this ORDER has Many
	public function orderContents() {
		return $this->hasMany('App\orderContents');
	}

}
