@extends('master')
@section('title', 'All products')
@section('content')

    <div class="container col-md-8 col-md-offset-2">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

       
        @foreach ($categories as $category)
            <div class="panel panel-default">
                <div class="panel-heading">
					<a href="{!! action('FrontController@productsForThisCateg', $category->slug) !!}">
                        {!! $category->title !!}</a>
				</div>
                
                <?php
                /*  
                <div class="panel-body">
                    {!! mb_substr($category->content,0,500) !!}
                </div>
                */ 
                ?>

            </div>
        @endforeach
        
    </div>

@endsection