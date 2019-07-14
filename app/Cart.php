<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id'];


	// this Cart has Many products
	public function product() 
	{		
		/* With belongsTo(), the FK 'product_id' is not expected inside PRODUCT table
		 * With this belogn() relation, FK is expected in CART table. 
		 * Reverse of hasMany()
		 */
		return	$this->belongsTo('App\Product', 'product_id'); // Cart.incindeki product_id FK

		/*
		ANY TIME YOU SEE :FK: IN A TABLE, IT'S belongsto(.
		-----------------------------------------
		artcile
		-------------------------------
		id | name | categor_Id | user_id
		---------------------------------
		ARTICLE 	belongsTo categor_id
		CATEGORY 	hasMany ARTICLe
		------------------------------
		
		// Article MODEL
		class Article extends Eloquent
		{
		    public function category()
		    {
		        return $this->belongsTo('App\Models\Category');
		    }
		    
		    public function user()
		    {
		        return $this->belongsTo('App\Models\User');
		    }

		}
		*/
	}


	

}
