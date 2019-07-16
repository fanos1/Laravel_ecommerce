<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests\CustomerFormRequest;
use App\Customer;

class CustomersController extends Controller
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
        return view('frontend.checkout');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerFormRequest $request)
    {
       
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

        // return view('frontend.billing', compact('customer') );        
        return redirect(action('StripeBillingController@create', compact('customer')) );
        
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
