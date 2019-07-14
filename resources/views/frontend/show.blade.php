@extends('master')
@section('title', 'View a post')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">
                <h2 class="header">{!! $product->title !!}</h2>
                <p> {!! $product->content !!} </p>
                <div>
                    <!-- 
                    <a href="{!! action('CartsController@store', $product->id) !!}" 
                        class="btn btn-success">   Add To Cart </a> 
                    -->
                        
                        <form action="/cart/create" method="get" class="itemDetails">
                            <input type="hidden" name="action" value="add">     
                            <input type="hidden" name="product_id" value="{!! $product->id !!}">   
                            <br>
                            <input class="btn btn-success btn-small" type="submit" value="Add to Cart →"> 
                        </form>
                       
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        @foreach($comments as $comment)
            <div class="well well bs-component">
                <div class="content">
                    {!! $comment->content !!}
                </div>
            </div>
        @endforeach

        <div class="well well bs-component">
            <form class="form-horizontal" method="post" action="/comment">

                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <input type="hidden" name="product_id" value="{!! $product->id !!}">
                <!-- <input type="hidden" name="post_type" value="App\Post"> -->

                <fieldset>
                    <legend>Comment</legend>
                    <div class="form-group">
                        <div class="col-lg-12">
                            <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@endsection
