<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

use App\Http\Requests\CartFormRequest;
use App\Cart;
use App\Product;
use App\Size;

class CartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      

        if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) 
        {
            $uid = $_COOKIE['SESSION'];
            // $ticket =   Ticket::whereSlug($slug)->firstOrFail();
            // $comments   =   $ticket->comments()->get();
            
             
            // $products = Product::all(); // Fetch prod as well
            // $x = $cart->products->pluck('product_id')->toArray();
            // $post->categories()->sync($request->get('categories'));

            /* 
            $cart = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->join('sizes', 'sizes.id', '=', 'products.size_id')
                ->where('carts.user_session_id', '=', $uid)
                ->get();

            // $cart = Cart::with('product')->where('user_session_id', $uid)->get(); // OK
            */
            // $cart = Cart::with(['product', 'size'])->where('user_session_id', $uid)->get(); // OK

           
            $cart = DB::table('carts')
                ->join('products', 'products.id', '=', 'carts.product_id')
                ->join('sizes', 'sizes.id', '=', 'products.size_id')
                ->where('carts.user_session_id', '=', $uid)
                ->select('carts.id AS cID', 'carts.*', 'products.*', 'sizes.*')
                ->get();
                
                        
        } else {
            $cart = null; //empty cart if user requests /cart Page before adding item
        }
        
        return view('frontend.cart.index', compact('cart'));
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
        // Check for, or create, a user session:
        if (isset($_COOKIE['SESSION']) && (strlen($_COOKIE['SESSION']) === 32)) {
            $uid = $_COOKIE['SESSION'];
        } else {
            $uid = openssl_random_pseudo_bytes(16);
            $uid = bin2hex($uid);
        }
        setcookie('SESSION', $uid, time()+(60*60*24*1) ); // keep cookie 1 day

        /* 
        $rows = DB::table('carts')->where([
            ['user_session_id', '=', $uid],
            ['product_id', '=', $pID],
        ])->orderBy('name', 'desc')->get();
        */
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

        // return view('frontend.cart.show');
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
        $cart = Cart::whereId($user_session_id)->firstOrFail();
        
        $products = Product::all(); // Fetch prod as well
        $x = $cart->products->pluck('id')->toArray(); // Gets all prod_id which this cart is associated

        return view('frontend.cart.show', compact('cart', 'x'));
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
        /* 
        $rows = Cart::where([
            ['user_session_id', '=', $_COOKIE['SESSION'] ],
            ['id', '=', $id],
        ])->firstOrFail(); 
        */
       
        $ticket->delete();

        return redirect('/cart')->with('status', 'The item has been deleted!');
    }

}
