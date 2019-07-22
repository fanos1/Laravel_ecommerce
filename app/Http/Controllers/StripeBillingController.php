<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StripeFormRequest;

use Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

use App\Cart;
use App\Order;
use App\OrderContent;
use Illuminate\Support\Facades\Cookie;

use Illuminate\Support\Facades\DB;

class StripeBillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uid = Cookie::get('SESSION');
        //dd($customer);

        if (isset($uid) && (strlen($uid) === 32)) {
            // only users who come from Cart page can proceed
            //return view('frontend.billing'); // show FORM            
            return view('frontend.billing', compact('customer') );  
        } else {
            exit('COOKie not set');
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StripeFormRequest $request)
    {
        // $uid = $_COOKIE['SESSION'];
         $uid = Cookie::get('SESSION');
         $custId = session('customer_id');
        //dd($uid);
     
       
        // 1:: AddOrder() :: save the order
        $order = new Order(array(
            'customer_id' => $custId,
            'total' => 0, //Total is 0, will update with following Query
            'shipping' => env('SHIPPING_FEE'),
            // 'credit_card_number' => 123, //nullable(), stripe payment. no need to store card 
        ));
        $order->save();

        // 2:: get shopping 
        $cartRows = DB::table('carts')
        ->join('products', 'products.id', '=', 'carts.product_id')
        ->where('carts.user_session_id', '=', $uid)
        ->select('carts.id AS cID', 'carts.*', 'products.price')
        ->get();
        
        $data = []; 
        // Create arrays for each row, for the order_content table
        foreach ($cartRows as $key => $value) 
        { 
            $aR = [
                'order_id' => $order->id,
                'product_id' => $value->product_id,
                'quantity' => $value->quantity,
                'item_price' => $value->price,
            ];
            array_push($data, $aR); // Add to $data Array, the new array
            // print_r($value);
            // echo "<h3>". $value->cID."</h3>";   
        }

        // 3:: Add to content tabel
        OrderContent::insert($data);

        // SELECT SUM(quantity*price_per) AS subtotal 
        //      FROM order_contents WHERE order_id=$lastOrderId

        
        
        // no validation ????
        // credit card info never comes to our server, STRIPE sends token instead
        // We can validate the stripeToken only


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        /*     
        $customer = Customer::create([
          'email' => request('stripeEmail'),
          'source' => request('stripeToken')
        ]); 
        

        Charge::create([
          'customer' => $customer->id,
          'amount'  => 2500,
          'currency'    => 'gbp'

        ]);
        */

        $charge = Stripe\Charge::create ([
            "amount" => 100 * 100,
            "currency" => "gbp",
            //"source" => $request->stripeToken,
            'source' => $request->get('stripeToken'),
            "description" => "Test payment from Alpina ." 
        ]);
  

        // Did it work? if Succes
        if ($charge->paid == 1) {

            exit('it worked, stripe charge ok, CIK');
            /* 
            $full_response = addslashes(serialize($charge));            
            $r = Order::add_charge($dbc, $charge->id, $order_id, 'auth_only', $order_total, $full_response);                    
            $_SESSION['response_code'] = $charge->paid;

            // Redirect to the next page:
            $location = 'https://' . BASE_URL . 'final.php';
            header("Location: $location");
            exit();
            */
            
        } else { // Charge was not paid!
            $message = $charge->response_reason_text;
            echo "<h3>268</h3>";            
            exit($message);
        }
        

        Session::flash('success', 'Payment successful!');
          
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
