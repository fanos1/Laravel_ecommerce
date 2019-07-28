@extends('master')
@section('title', 'View a cart')
@section('content')

    <div class="container">
    	<div class="row">
    		
        <div class="col-md-12">
            <h2>Shoppint cart content</h2>
            <?php // dd($cart); ?>

				@if($cart === null || $cart->isEmpty() )
					<h2>empty cart</h2>
				@else
					<table class="table">
		        		<tr>
		        			<th>id</th>
		        			<th>user session</th>
		        			<th>Item</th>
		        			<th>produc id</th>
		        			<th>quantity</th>	
		        			<th>price</th>	   
		        			<th>Subtotal</th>     					        			
		        			<th>size name</th>
		        			<th>Action</th>
		        		</tr>

						<?php
							// print_r($cart);								
							// exit();
							$total = 0;
						?>
						@foreach($cart as $cartRow)	       	
			        		<tr>
			        			<td>{{ $cartRow->cID }}</td>
			        			<td>{{ $cartRow->user_session_id }} </td>
			        			<?php // <td> {!! $cartRow->product->title !!} </td>  ?>
			        			<td> {{ $cartRow->title }}
			        			<td>{{ $cartRow->product_id }}</td>
			        			<td>{{ $cartRow->quantity }}</td>		
			        			<td>£{{ number_format($cartRow->price /100, 2) }}</td>
			        			<td>£{{ number_format(($cartRow->price/100) * $cartRow->quantity, 2) }}</td>	        			
			        			<?php  // <td> {!! $cartRow->product->size_id !!} </td> ?>
			        			<td> {{ $cartRow->s_name }} </td>
			        			<td> 
			        				<form method="get" 
			        					action="{!! action('CartsController@destroy', $cartRow->cID) !!}" 
			        					class="pull-left">
						                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
						                <div>
						                    <button type="submit" class="btn btn-warning">Delete</button>
						                </div>
						            </form>						            
			        			</td>
			        		</tr>	
			        		<?php 
			        			$total += $cartRow->price/100 * $cartRow->quantity; 
			        		?>        	
						@endforeach							
							<tr>
								<?php 
									$shipping = env('SHIPPING_FEE') / 100;
									$Grand= $total+$shipping;
								?>
								<td><h4>Shipping:  £{!! number_format($shipping, 2)  !!} </h4> </td>
								<td><h4>Grand Total: £{!! number_format($Grand, 2) !!} </h4></td>
								<td><a href="/checkout" class="btn btn-success">Checkout</a></td>
							</tr>
					</table>
				@endif	




			@if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif


        </div>

    	</div>
    </div>

@endsection
