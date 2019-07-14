<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Comment extends Model
{
    protected $guarded = ['id'];

    // $this Comment belongsto product
    // To complete the relationship, insert same in the Product model
    public function	product()
	{
		return	$this->belongsTo('App\Product');
	}
}
