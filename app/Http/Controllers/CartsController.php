<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

use App\Http\Requests\CartFormRequest;
use App\Cart;
use App\Product;
use App\Size;

use Illuminate\Support\Facades\Cookie;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $uid = Cookie::get('SESSION');
                  
        if( $uid !== null ) // if isset()
        {
            // $cart = Cart::with(['product', 'size'])->where('user_session_id', $uid)->get();           
            $cart = DB::table('carts')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->join('sizes', 'sizes.id', '=', 'products.size_id')
                ->where('carts.user_session_id', '=', $uid)
                ->select('carts.id AS cID', 'carts.*', 'products.*', 'sizes.*')
                ->get();
                                        
        } else {
            $cart = null; //empty cart if user requests /cart Page before adding item
        }
        
        // return view('frontend.cart.index', compact('cart') )->withCookie($_COOKIE['SESSION'] );
        return view('frontend.cart.index', compact('cart') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if( Cookie::get('SESSION') !== null ) { //
            $uid = Cookie::get('SESSION');
        } else {
            $uid = openssl_random_pseudo_bytes(16);
            $uid = bin2hex($uid);
        }
        $cookieVal = Cookie::queue('SESSION', $uid, 86400);
         

        // Get Cart contents
        $rows = Cart::where([
            ['user_session_id', '=', $uid],
            ['product_id', '=', $request->get('product_id')],
        ])->get();
       
        /*
         $rows ::there will be only 1 recored WHERE both produc_id AND user_session SAME.
        [{
            "id":1,
            "user_session_id":"d5c720a05884347194f5666f25770978",
            "product_id":1,
            "quantity":1,"created_at":"2019-07-02 16:46:19","updated_at":"2019-07-02 16:46:19"
        }]
        */
       
        if (count($rows) > 0) { // this user already has tis item in Cart, UPDATE
            
            $cID = $rows[0]->id; //CART id
            
            $cart = Cart::find($cID);
            $cart->quantity = $cart->quantity + 1; // Add 1 more
            $cart->save();
            
        } else { // INSERT new Row Record
            
            $cart =  new Cart(array(
                'user_session_id' => $uid,
                'product_id' => $request->get('product_id'),
                'quantity' => 1,
            ));
            $cart->save();
        }

        //return redirect(action('CartsController@index') )->with('status', 'Item added to basket')->withCookie($c );

       return redirect(action('CartsController@index') )->with('status', 'Item added to basket');

        // return  redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The ticket  '.$slug.'   has been    updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_session_id)
    {
        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Cart::whereId($id)->firstOrFail();        
        $ticket->delete();

        return redirect('/cart')->with('status', 'The item has been deleted!');
    }

}
