<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StripeFormRequest;

use Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

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
        // no validation ????

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