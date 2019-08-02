@extends('master')
@section('title', 'All products')
@section('content')

    <div class="container col-md-8 col-md-offset-2">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($products->isEmpty())
            <p> There is no post.</p>
        @else
            @foreach ($products as $product)
                <div class="panel panel-default">
                    <div class="panel-heading">
						<a href="{!! action('FrontController@show', $product->slug) !!}">
                            {!! $product->title !!}</a>
					</div>
                    <!-- <img class="img-responsive"  src="/images/{{ $product->img }}"  alt=""  /> -->
                    <?php
                    /*  
                    <div class="panel-body">
                        {!! mb_substr($product->content,0,500) !!}
                    </div>
                    */ 
                    ?>

                </div>
            @endforeach
        @endif
    </div>

@endsection