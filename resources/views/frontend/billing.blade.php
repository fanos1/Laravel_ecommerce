@extends('master')
@section('title', 'Billn view')
@section('content')

<div class="container">
    <style type="text/css">
        .panel-title {
        display: inline;
        font-weight: bold;
        }
        .display-table {
            display: table;
        }
        .display-tr {
            display: table-row;
        }
        .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 61%;
        }
    </style>


    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Payment Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
  
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
  
                    <form role="form" action="{{ route('stripe.post') }}" method="post" 
                        class="require-validation" data-cc-on-file="false"
                         id="billing_form">

                          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                          
                        <!--   
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> 
                                <input class='form-control' size='4' type='text'>
                            </div>
                        </div> 
                        -->                    

                        <!-- 
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-6 form-group'>
                                <label class='control-label'>First name</label>  
                                <input type="text" name="cc_first_name" class="form-control" /> 
                            </div>
                            <div class='col-xs-12 col-md-6 form-group'>
                                <label class='control-label'>last nameh</label> 
                                <input type="text" name="cc_last_name" class="form-control"  /> 
                            </div>
                        </div> 
                        -->
                                                        

                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label>
                                <input type="text" id="cc_number" autocomplete="off" 
                                value="6011111111111117" class='form-control' />    
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> 
                                <input type="text" id="cc_cvv" class="form-control" 
                                autocomplete="off" placeholder='ex. 311' size='4' value="123" />
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label>                         
                                <input type="text" id="cc_exp_month" class="form-control" 
                                autocomplete="off" placeholder='MM' size='2' >
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label>
                                <input type="text" id="cc_exp_year" class="form-control" 
                                autocomplete="off" placeholder='YYYY' size='4' />
                            </div>
                        </div>
  
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">
                                    Pay Now ($100)
                                </button>
                            </div>
                        </div>
                          
                    </form>
                </div>
            </div>        
        </div>

        <div class="col-md-6">
           
        </div>
    </div>
      
</div>



<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
     
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_3EVgSTvMrg5iuXal0he65oEi');
</script>
 
<script type="text/javascript">
        // Watch for the document to be ready:
    $(function() {

        var $form = $("#billing_form");

      $('#billing_form').submit(function() {

            var error = false;

            // disable the submit button to prevent repeated clicks:
            $('input[type=submit]', this).attr('disabled', 'disabled');

            // Get the values:
            var cc_number = $('#cc_number').val();
            var cc_cvv = $('#cc_cvv').val();
            var cc_exp_month = $('#cc_exp_month').val(), cc_exp_year = $('#cc_exp_year').val();

            // Validate the number:
            if (!Stripe.validateCardNumber(cc_number)) {
                error = true;
                reportError('The credit card number appears to be invalid.');
            }

            // Validate the CVC:

            // Validate the expiration:
            if (!Stripe.validateExpiry(cc_exp_month, cc_exp_year)) {
                error = true;
                reportError('The expiration date appears to be invalid.');
            }

            if (!error) {
                
                // Stripe.setPublishableKey($form.data('stripe-publishable-key'));                

                // Get the Stripe token:
                Stripe.createToken({
                    number: cc_number,
                    cvc: cc_cvv,
                    exp_month: cc_exp_month,
                    exp_year: cc_exp_year
                }, stripeResponseHandler);
            }

            // prevent the form from submitting with the default action
            return false;

        }); // form submission

    }); // document ready.


    // Function handles the Stripe response:
    function stripeResponseHandler(status, response) {

        // Check for an error:
        if (response.error) {
            reportError(response.error.message);
        } else { // No errors, submit the form.
          var billing_form = $('#billing_form');
          // token contains id, last4, and card type
          var token = response.id;
          // insert the token into the form so it gets submitted to the server
          billing_form.append("<input type='hidden' name='token' value='" + token + "' />");
          // and submit
          billing_form.get(0).submit();
        }

    }

    function reportError(msg) {
        // Show the error in the form:
        $('#error_span').text(msg);
        // re-enable the submit button:
        $('input[type=submit]', this).attr('disabled', false);
        return false;
    }

</script>

@endsection
