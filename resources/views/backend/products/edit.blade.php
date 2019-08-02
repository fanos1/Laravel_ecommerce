@extends('master-admin')
@section('title',	'Single product edit')

@section('content')

<div class="container">
     <div class="col-12">

            <form class="form-horizontal" method="post" enctype="multipart/form-data">

                @foreach ($errors->all() as $error)
                    <h3 class="alert alert-danger">{{ $error }}</h3>
                @endforeach

                @if (session('status'))
                    <h3 class="alert alert-success">
                        {{ session('status') }}
                    </h3>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                <fieldset>
                    <legend>Edit product</legend>
                    <div class="form-group">
                        <label for="title" class="col-lg-2 control-label">Title</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="title" name="title" value="{!! $product->title !!}">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="slug" class="col-lg-2 control-label">Slug</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="slug" name="slug" value="{!! $product->slug !!}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-lg-2 control-label">Content</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="content" 
                            name="content">{!! $product->content !!}</textarea>
                        </div>
                    </div>
					

                    <div class="form-group">
                        <label for="select" class="col-lg-2 control-label">categories</label>
                        <div class="col-lg-10">
                            <select class="form-control" id="categories" name="categories[]"  multiple>   
								@foreach($categories as $page)
								<option value="{!! $page->id !!}"
								    @if(in_array($page->id, $selectedCategories)) 
                                        selected="selected" 
                                    @endif >
									{!! $page->title !!}
								</option>
								@endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="h2" class="col-lg-2 control-label">h2</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="h2" name="h2" value="{!! $product->h2 !!}">
                        </div>
                    </div>

                     <div class="form-group">
                        <label for="price" class="col-lg-2 control-label">price</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="price" 
                                value="{!! $product->price !!}">
                        </div>
                    </div>


                     <div class="form-group">
                        <label for="h2" class="col-lg-2 control-label">stock</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="stock" 
                                value="{!! $product->stock !!}">
                        </div>
                    </div>

                    <!-- Featured ? -->
                     <div class="form-group">
                        <label for="featured" class="col-lg-2 control-label">featured ?</label>
                        <div class="col-lg-10">
                            @if($product->featured === 0)
                                <input type="radio" name="featured" checked="true" value="0">No<br>
                                <input type="radio" name="featured" value="1"> Yes<br>
                            @else if($product->featured === 1)
                                <input type="radio" name="featured" checked="true" value="1"> Yes<br>
                                <input type="radio" name="featured" value="0"> Yes<br>
                            @endif 
                            <!-- <input type="radio" name="featured"  value="0"> No<br> -->
                        </div>
                    </div>

                    <!-- gluten free -->
                    <div class="form-group">
                        <label for="gluten free" class="col-lg-2 control-label">Gluten Free?</label>
                        <div class="col-lg-10">
                            @if($product->glut_free === 0)
                                <input type="radio" name="glut_free"  checked="true" value="0"> No<br>
                                <input type="radio" name="glut_free" value="1"> Yes<br>
                            @else
                                <input type="radio" name="glut_free"  value="0"> No<br>
                                <input type="radio" name="glut_free"  checked="true" value="1"> Yes<br>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <!-- <input type="hidden" name="img" class="form-control" value="no-image.png">  -->
                        <input type="file" name="img" />
                    </div> 

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
</div>
@endsection

