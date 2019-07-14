<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\CategoryEditFormRequest;

use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return  view('backend.categories.index',  compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryFormRequest $request)
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

        $category = new Category(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $request->get('slug'),
            'img' => $newName
            //'img' => $request->get('img'),
        ));

        $category->save();
    
        
        return  redirect(action('Admin\CategoriesController@create', $category->id))
            ->with('status', 'The category has  been updated!');

        //return  redirect('/admin/categories/create')->with('status','A new category has been created!');

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
        // show the Form to edit signle Category
        $category = Category::whereId($id)->firstOrFail();

        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryEditFormRequest $request, $id)
    {
        $category = Category::whereId($id)->firstOrFail();

        $category->title = $request->get('title');
        $category->content = $request->get('content');
        $category->slug = Str::slug($request->get('title'), '-');

        $category->save(); // save product

        return redirect(action('Admin\CategoriesController@edit', $category))
            ->with('status','The category has been updated');
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
