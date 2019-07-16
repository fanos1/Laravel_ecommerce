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
        return view('fontend.billing'); // show FORM
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StripeFormRequest $request)
    {

        // add_order()
        // Before chargin, we need to add ORDER

        //1. add_order($_SESSION['customer_id'], $uid, $shipping,  $cc_last_four)
        //1. Select all() from Cart WHERE c.user_session_id = :uid
        //3, Loop through each() cartRow, and INSERT each cartRow info into order_conten TABLE
        //4. SELECT SUM(quantity*price_per) AS subtotal FROM order_contents WHERE order_id=$lastOrderId

        //1- Select Cart Items
        // $uid = $_COOKIE['SESSION'];        
        $cartRows = Cart::where([
            ['user_session_id', '=', $_COOKIE['SESSION']],
        ])->get();

        exit('StripeBillingController icinde 62');

        //2- AddOrder() :: save the order
        $order = new Order(array(
            'customer_id' => $_SESSION['customer_id'],
            // 'total' => $request->get(''),
            'shipping' => 1,
            // 'credit_card_number' => 123, //nullable(), stripe payment. no need to store card            

        ));
        $order->save();

        
        // 3- Save each() Cart row into order_content()
        // I dont want to Loop() and keep calling Many times UPDATE query

        /* ALTERNATIVE IS CREATE ARRAY, AND pass this Arr to OrderContent()
         $orderProducts = [];
            foreach ($cart->items as $productId => $item) {
                $orderProducts[] = [
                    'order_id' => $order->id,
                    'product_id' => $productId
                    'quantity' => $item['qty']
                ];
            }
            OrderProduct::insert($orderProducts);
       
        $data = array(
            array('user_id'=>'Coder 1', 'subject_id'=> 4096),
            array('user_id'=>'Coder 2', 'subject_id'=> 2048),
            //...
        );
        Model::insert($data); // Eloquent approach
        DB::table('table')->insert($data); // Query Builder approach    
        */

        // no validation ????
        // credit card info never comes to our server, STRIPE sends token instead
        // We can validate the stripeToken


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
