<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $guarded = ['id'];

	// Each PRODUCT ROW can be associated only with 1 size

    // Each SIZE ROW can be associated with MANY products
    public function products()
    {
    	return $this->hasMany('App\Product', 'size_id'); // 'size_id' in the PRODUCT TABLE
    }

	/*
	SIZE TABLE
	--------------------
	ID | NAME
	--------------------
	3  | 100g
	--------------------


	PRODUCT TABLE
	---------------------
	id | name 		| size_id
	---------------------
	1  | walnut 	| 3
	2  | walnut		| 3  // NO POINT IN HAVING 2 ROWS SAME
	3  | walnut     | 2  // ok
	4  | pistachio	| 3
	---------------------
	// Each PRODUCT ROW can be associated only with 1 size

	*/

}
