<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\SizeFormRequest;
use App\Http\Requests\SizeEditFormRequest;
use App\Http\Controllers\Controller;
use App\Size;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes  =   Size::all();
        return  view('backend.sizes.index', compact('sizes')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // instead of just returning the view where user can create new Product, we First fetch Categories
        // $categories = Category::all();
        // return  view('backend.products.create', compact('categories'));
		
		return  view('backend.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size =  new Size(array(
            's_name' => $request->get('s_name'),
        ));
        $size->save();

        // After saving the product, use syn() to attach the associated Category
        // $product->categories()->sync($request->get('categories'));
        
        return  redirect('/admin/sizes/create')->with('status', 'The Size has been created!');
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        // show a Form for single product which is to be edited
        // only show the form, when this form is submited, the update() action takes over
        $size = Size::whereId($id)->firstOrFail();
		
        //$categories =   Category::all(); // Fetch Category as well
	
		/* 
         * The pluck method retrieves all of the values for a given key:
         * $collection = collect([ ['name' => 'Desk'], ['name' => 'Chair'], ]);
         * $plucked = $collection->pluck('name');
         * $plucked->all(); // OUT:: ['Desk', 'Chair']
		*/
        // $selectedCategories = $product->categories->pluck('id')->toArray(); // Gets all categ_id which this product is associated with. 

        return view('backend.sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
