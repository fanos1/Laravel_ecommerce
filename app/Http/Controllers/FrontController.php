<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;

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

	public function categories() 
	{
		$categories = Category::all();
		return view('frontend.categories', compact('categories') );

	}

	public function productsForThisCateg($slug) 
	{
		$categories = Category::whereSlug($slug)->firstOrFail();
		$productsForThisCateg = $categories->products()->get();

		//$page = Page::whereSlug($slug)->firstOrFail();
        //$articlesForThisPage = $page->articles()->get();
		return view('frontend.productspercateg', compact('productsForThisCateg') );
	}

}
