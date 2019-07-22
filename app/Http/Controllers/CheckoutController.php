<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Http\Requests\CheckoutFormRequest;
use App\Customer;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
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

        if (isset($uid) && (strlen($uid) === 32) ) 
        {
            return view('frontend.checkout');        
        }
       
        exit('SOMEthing wrong with reading COOKIE');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutFormRequest $request)
    {
        //
        // $POSTCODE = strtoupper("Hello WORLD!"); // convert postcode to uppercase
        $customer =  new Customer(array(
            'email' => $request->get('email'),
            'f_name' => $request->get('f_name'),
            'l_name' => $request->get('l_name'),

            'address1' => $request->get('address1'),
            'city' => $request->get('city'),
            'post_code' => $request->get('post_code'),
            'phone' => $request->get('phone'),
                        
        ));


        // PostCode validated syntactically, but use API to check if really exist
        // TO DO: https://postcodes.io/

        $customer->save();

        session(['customer_id' => $customer->id]); 
        // return redirect(action('StripeBillingController@create', compact('customer')) );
        return redirect(action('StripeBillingController@create') );
        
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
