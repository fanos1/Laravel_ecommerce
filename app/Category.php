<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = ['id'];

	public	function products()
	{
		return	$this->belongsToMany('App\products')->withTimestamps();
	}
}