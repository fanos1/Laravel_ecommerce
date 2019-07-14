@extends('master')
@section('title',	'All product')

@section('content')

<div class="container">
   <div class="col-12">
         <div class="panel-heading">
            <h2> All Products </h2>
         </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($products->isEmpty())
                <p> There is no page.</p>
            @else
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Slug</th>     
                        <th>Created At</th>
                        <th>Updated At</th> 
                        <th>Stock</th> 
                        <th>Price</th>                  
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $prod)
                        <tr>
                            <td>{!! $prod->id !!}</td>
                            <td>
                                <a href="{!! action('Admin\ProductsController@edit', $prod->id) !!}">{!! $prod->title !!} </a>
                            </td>
                            <td>{!! $prod->slug !!}</td>
                            <td>{!! $prod->created_at !!}</td>
                            <td>{!! $prod->updated_at !!}</td>  
                            <td>{!! $prod->stock !!}</td>
                            <td>{!! $prod->price !!}</td>                   
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
      </div>
</div>
@endsection

