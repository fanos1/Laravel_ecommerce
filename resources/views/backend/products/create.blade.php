@extends('master')
@section('title', 'Create A New Post')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">

            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <fieldset>
                    <legend>Create a new post</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">Content</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="categories" class="col-lg-2 control-label">Categories</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="category" name="categories[]" multiple>
                                
                                @foreach($categories as $category)
                                    <option value="{!! $category->id !!}">
                                        {!! $category->title !!}
                                    </option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="Size" class="col-lg-2 control-label">Size</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="size_id" name="size_id" multiple>    
                                <option value="1">
                                       XL
                                </option>
                                <option value="2">
                                       100g
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-lg-2 control-label">Price</label>
                        <div class="col-lg-10">
                             <input type="text" class="form-control" id="price" placeholder="Price" 
                             name="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stock" class="col-lg-2 control-label">Stock</label>
                        <div class="col-lg-10">
                             <input type="text" class="form-control" id="stock" placeholder="Stock" 
                             name="stock">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gluten free" class="col-lg-2 control-label">Gluten Free?</label>
                        <div class="col-lg-10">
                            <input type="radio" name="glut_free"  checked="true" value="0"> No<br>
                            <input type="radio" name="glut_free" value="1"> Yes<br>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="featured" class="col-lg-2 control-label">featured ?</label>
                        <div class="col-lg-10">
                            <input type="radio" name="featured"  checked="true" value="0"> No<br>
                            <input type="radio" name="featured" value="1"> Yes<br>
                        </div>
                    </div>

                    <div class="form-group">
                       <!-- <input type="hidden" name="img" class="form-control" value="no-image.png">  -->
                       <input type="file" name="img" />
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection
