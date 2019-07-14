<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\ProductFormRequest;
use App\Http\Requests\ProductEditFormRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products  =   Product::all();
        return  view('backend.products.index', compact('products'));      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // instead of just returning the view where user can create new Product, we First fetch Categories
        $categories = Category::all();

        return  view('backend.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        if($request->hasFile('img')) { 
            /*
             Only validate If file is being uploaded (if detected)
            */
            $this->validate($request, [
                'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('img');
            $newName = $request->get('title'). '-' .time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $newName);

        } else {
            $newName = NULL;            
        }

        // $user_id = Auth::user()->id;

        $product =  new Product(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'img' => $newName,
            //'h2' => $request->get('h2'),
            'slug' => Str::slug($request->get('title'),   '-'),
            //'user_id' => $user_id
            'size_id' => $request->get('size_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'glut_free' => $request->get('glut_free'),
            
        ));

        $product->save();

        // After saving the product, use syn() to attach the associated Category
        $product->categories()->sync($request->get('categories'));
        
        return  redirect('/admin/products/create')->with('status', 'The Prodtct has been created!');

        // return  redirect(action('Admin\ArticlesController@create', $product->id))->with('status', 'updat!'); 
    
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
        $product = Product::whereId($id)->firstOrFail();
        $categories =   Category::all(); // Fetch Category as well

        // The pluck method retrieves all of the values for a given key:
        // $collection = collect([ ['name' => 'Desk'], ['name' => 'Chair'], ]);
        // $plucked = $collection->pluck('name');
        // $plucked->all(); // OUT:: ['Desk', 'Chair']
        $selectedCategories = $product->categories->pluck('id')->toArray(); // Gets all categ_id which this product is associated with. 

        return view('backend.products.edit', compact('product', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductEditFormRequest $request, $id)
    {
        $product = Product::whereId($id)->firstOrFail();

        $product->title = $request->get('title');
        $product->content = $request->get('content');
        $product->slug = Str::slug($request->get('title'), '-');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->glut_free = $request->get('glut_free');

        $product->save(); // save product

        // after saving product, we could run another Savecategor() to save category for this product
        // but easier is to use sync() for PIVOT tables
        $product->categories()->sync($request->get('categories')); // save categ_id for this product

        // return  redirect(action('Admin\ProductsController@edit', $product->id))->with('status','The produc has been updated');
        return redirect(action('Admin\ProductsController@edit', $product))
            ->with('status','The produc has been updated');
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
