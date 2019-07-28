@extends('master')
@section('title',	'All orders')

@section('content')

<div class="container">
   <div class="col-12">
         <div class="panel-heading">
            <h2> All orders </h2>
         </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($orders->isEmpty())
                <p> There is no order.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>customer_id</th>
                            <th>total</th>     
                            <th>shipping</th>
                            <th>card_numb</th> 
                            <th>created_at</th>             
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{!! action('Admin\OrdersController@show', $order->id) !!}">{!! $order->id !!} </a>
                            </td>
                            <td>{!! $order->customer_id !!} </td>
                            <td>{!! $order->total !!}</td>
                            <td>{!! $order->shipping !!}</td>
                            <td>{!! $order->card_numb !!}</td>  
                            <td>{!! $order->created_at !!}</td>                
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
      </div>
</div>
@endsection

