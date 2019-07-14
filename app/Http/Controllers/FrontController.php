<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class FrontController extends Controller
{
	public function home() {
		return view('frontend.home');
	}

	public function index() 
	{
		$products = Product::all();
        return view('frontend.index', compact('products'));
	}



    public function show($slug)
	{
		$product = Product::whereSlug($slug)->firstOrFail();

		$comments =	$product->comments()->get();

		return	view('frontend.show',	compact('product',	'comments'));
	}

}
