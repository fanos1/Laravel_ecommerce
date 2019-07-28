<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderContent extends Model
{
    //
    protected $guarded = ['id'];

    // this ORDER hasOne/belongsTo 1 product
    // the ORDER_content Row with ID 1, contains only 1 PRODUCT
    // EACH orderContent Row will have unique 1 PRODUCT
    public function products()
	{
		// return $this->hasOne('App\Customer','id');
	    // return $this->belongsTo('App\Product', 'product_id');
        return $this->hasMany('App\Product', 'product_id');
	}

    // this ORDER_CONTENT
    public function order() {
        return $this->belongsTo('App\Order');
    }

}
