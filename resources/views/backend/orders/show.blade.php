@extends('master-admin')
@section('title', 'View a single order')
@section('content')

    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <div class="content">

                <?php 
                    //dd($order);
                ?>
                <h2 class="header">oRDER ID: {!! $order->id !!}</h2>
                <p> customer ID:  {!! $order->customer_id !!} </p>
            </div>
            <div class="clearfix"></div>
        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Order Id</th>
                <th>Prod Id</th>
                <th>quant</th>
                <th>item price</th>
                <th>created</th>
            </tr>    
        
            @foreach($contents as $content)
                <tr>                    
                    <td>{!! $content->id !!} </td>
                    <td>{!! $content->order_id !!} </td>
                    <td>{!! $content->product_id !!} </td>
                    <td>{!! $content->quantity !!} </td>
                    <td>${!! number_format($content->item_price / 100, 2)  !!} </td>
                    <td>{!! $content->created_at !!} </td>
                </tr>  
            @endforeach
        </table>    
    
        <table class="table">
            <tr>
                <th>id</th>
                <th>product</th>
                <th>price</th>
                <th>stock</th>
                <th>size id</th>
                <th>s_name</th>
                <th>product id</th>
                <th>quantity</th>
            </tr>
        
            @foreach ($contents as $value) 
                <tr>
                    <td>{!! $value->id !!}</td>
                    <td>{!! $value->title !!}</td>
                    <td> {!!  number_format( $value->price /100, 2) !!}</td>
                    <td> {!! $value->stock !!}</td>
                    <td> {!! $value->size_id  !!}</td>
                    <td> {!! $value->s_name  !!}</td>
                    <td> {!!  $value->product_id !!}</td>
                    <td> {!! $value->quantity !!}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <?php  
        //print_r($customer[0]['email']);
        echo '<p> CUSTOMER DETAILS: <br/>'
             .$customer[0]['email'] .'<br/>'
             .$customer[0]['f_name'] .'<br/>'
             .$customer[0]['l_name'] .'<br/>'
             .$customer[0]['address1'] .'<br/>'
             
             .$customer[0]['city'] .'<br/>'
             .$customer[0]['post_code'] .'<br/>'
             .$customer[0]['phone'] .'<br/>'
             .$customer[0]['created_at'] .'<br/>
        </p>';

        // contents :: {"id":1,"title":"walnut test","content":"walnut description","img":null,"h2":null,"slug":"walnut-test","price":300,"stock":15,"featured":0,"glut_free":1,"size_id":2,"created_at":null,"updated_at":null,"order_id":1,"product_id":2,"quantity":1,"item_price":300,"ship_date":null}
        
    ?>

@endsection
