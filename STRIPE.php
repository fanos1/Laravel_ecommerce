<?php
// Start the session:
session_start();

// The session ID is the user's cart ID:
$uid = session_id();

// Check that this is valid:
if (!isset($_SESSION['customer_id'])) { // Redirect the user.
	$location = 'https://' . BASE_URL . 'checkout.php';
	header("Location: $location");
	exit();
}

// Require the database connection:
require(MYSQL);

// Validate the billing form...

// For storing errors:
$billing_errors = array();



// Check for a form submission:
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

	if (get_magic_quotes_gpc()) {
		$_POST['cc_first_name'] = stripslashes($_POST['cc_first_name']);
		// Repeat for other variables that could be affected.
	}

	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $_POST['cc_first_name'])) {
		$cc_first_name = $_POST['cc_first_name'];
	} else {
		$billing_errors['cc_first_name'] = 'Please enter your first name!';
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $_POST['cc_last_name'])) {
		$cc_last_name  = $_POST['cc_last_name'];
	} else {
		$billing_errors['cc_last_name'] = 'Please enter your last name!';
	}
	
	// Check for a Stripe token:
	if (isset($_POST['token'])) {
		$token = $_POST['token'];		
	} else {
		$message = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
		$billing_errors['token'] = true;
	}

	
	// Check for a street address:
	if (preg_match ('/^[A-Z0-9 \',.#-]{2,160}$/i', $_POST['cc_address'])) {
		$cc_address  = $_POST['cc_address'];
	} else {
		$billing_errors['cc_address'] = 'Please enter your street address!';
	}
		
	// Check for a city:
	if (preg_match ('/^[A-Z \'.-]{2,60}$/i', $_POST['cc_city'])) {
		$cc_city = $_POST['cc_city'];
	} else {
		$billing_errors['cc_city'] = 'Please enter your city!';
	}

	// Check for a state:
	if (preg_match ('/^[A-Z]{2}$/', $_POST['cc_state'])) {
		$cc_state = $_POST['cc_state'];
	} else {
		$billing_errors['cc_state'] = 'Please enter your state!';
	}

	// Check for a zip code:
	if (preg_match ('/^(\d{5}$)|(^\d{5}-\d{4})$/', $_POST['cc_zip'])) {
		$cc_zip = $_POST['cc_zip'];
	} else {
		$billing_errors['cc_zip'] = 'Please enter your zip code!';
	}
	
	if (empty($billing_errors))  // If everything's OK...
	{

		// Check for an existing order ID:
		if (isset($_SESSION['order_id'])) { // Use existing order info:
			$order_id = $_SESSION['order_id'];
			$order_total = $_SESSION['order_total'];
		} else { // Create a new order record:


			// Get the last four digits of the credit card number:
			// Temporary solution for Stripe:
			$cc_last_four = 1234;
			//$cc_last_four = substr($cc_number, -4);

			// Call the stored procedure:
			$shipping = $_SESSION['shipping'] * 100;
			$r = mysqli_query($dbc, "CALL add_order({$_SESSION['customer_id']}, '$uid', $shipping, $cc_last_four, @total, @oid)");

			// Confirm that it worked:
			if ($r) {

				// Retrieve the order ID and total:
				$r = mysqli_query($dbc, 'SELECT @total, @oid');
				if (mysqli_num_rows($r) == 1) {
					list($order_total, $order_id) = mysqli_fetch_array($r);
					
					// Store the information in the session:
					$_SESSION['order_total'] = $order_total;
					$_SESSION['order_id'] = $order_id;
					
				} else { // Could not retrieve the order ID and total.
					unset($cc_number, $cc_cvv, $_POST['cc_number'], $_POST['cc_cvv']);
					trigger_error('Your order could not be processed due to a system error. We apologize for the inconvenience.');
				}
			} else { // The add_order() procedure failed.
				trigger_error('Your order could not be processed due to a system error. We apologize for the inconvenience.');
			}
			
		} // End of isset($_SESSION['order_id']) IF-ELSE.
		
		
		//------------------------
		// Process the payment!
		//---------------------
		if (isset($order_id, $order_total)) {

			try {

				// Include the Stripe library:
				require_once('includes/Stripe.php');

				// set your secret key: remember to change this to your live secret key in production
				// see your keys here https://manage.stripe.com/account
				Stripe::setApiKey('sk_test_cyFiWIBiAhaZiW2WiURm4MNw');

				// Charge the order:
				$charge = Stripe_Charge::create(array(
					'amount' => $order_total,
					'currency' => 'usd',
					'card' => $token,
					'description' => $_SESSION['email'],
					'capture' => false
					)
				);

				//echo '<pre>' . print_r($charge, 1) . '</pre>';exit;

				// Did it work?
				if ($charge->paid == 1) {

					// Add slashes to two text values:
					$full_response = addslashes(serialize($charge));

					// Record the transaction:
					$r = mysqli_query($dbc, "CALL add_charge('{$charge->id}', $order_id, 'auth_only', $order_total, '$full_response')");				
					
					// Add the transaction info to the session:
					$_SESSION['response_code'] = $charge->paid;
					
					// Redirect to the next page:
					$location = 'https://' . BASE_URL . 'final.php';
					header("Location: $location");
					exit();

				} else { // Charge was not paid!	
					$message = $charge->response_reason_text;
				}

			} catch (Stripe_CardError $e) { // Stripe declined the charge.
				$e_json = $e->getJsonBody();
				$err = $e_json['error'];
				$message = $err['message'];
			} catch (Exception $e) { // Try block failed somewhere else.
				trigger_error(print_r($e, 1));

			}

		} // End of isset($order_id, $order_total) IF.
		// Above code added as part of payment processing.
		// ------------------------

	} // Errors occurred IF

} // End of REQUEST_METHOD IF
?>



<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
</head>

    
<body>
<form action="/billing_stripe.php" method="POST" id="billing_form">
    <div>
        <input type="text" id="cc_number" autocomplete="off" value="6011111111111117" />    
    </div>
    
    <input type="text" id="cc_exp_month" autocomplete="off" value="12" />/
    <input type="text" id="cc_exp_year" autocomplete="off" value="2014"/>
    <input type="text" id="cc_cvv" autocomplete="off" value="123" />
    
    <div class="">	<input type="text" name="cc_first_name"/> </div>
    <div class=""> <input type="text" name="cc_last_name"/> </div>
    <div class=""> <input type="text" name="cc_address"/> </div>
    <div class=""> <input type="text" name="cc_city"/> </div>
    <div class=""> <input type="text" name="cc_state"/> </div>
    <div class=""> <input type="text" name="cc_zip"/> </div>
    
    <input type="submit" value="Place Order" class="button" />
    
</form>
    
    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    
<script type="text/javascript">
    Stripe.setPublishableKey('pk_test_he3kQISvjYDUghNujZnPuCRT');
</script>

<script type="text/javascript">
    // Watch for the document to be ready:
    $(function(){

      $('#billing_form').submit(function() {
            var error = false;

            // disable the submit button to prevent repeated clicks:
            $('input[type=submit]', this).attr('disabled', 'disabled');

            // Get the values:
            var cc_number = $('#cc_number').val(), cc_cvv = $('#cc_cvv').val(), cc_exp_month = $('#cc_exp_month').val(), cc_exp_year = $('#cc_exp_year').val();

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

    } // End of stripeResponseHandler() function.

    function reportError(msg) {
        // Show the error in the form:
        $('#error_span').text(msg);
        // re-enable the submit button:
        $('input[type=submit]', this).attr('disabled', false);
        return false;
    }
    
</script>
    
</body>
</html> 

