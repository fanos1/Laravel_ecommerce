@extends('master')
@section('title', 'View a post')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">
                
            </div>
            <div class="clearfix"></div>
        </div>

        @foreach($productsForThisCateg as $product)
            <div class="well well bs-component">
                <div class="content">
                    {!! $product->title !!}                    
                    <div>
                        <a href="{!! action('FrontController@show', $product->slug) !!}">
                                {!! $product->title !!}</a>
                    </div>
                </div>
            </div>
        @endforeach

        
    </div>

@endsection
