<?php
	
	require_once("../stripe_2/init.php");



	
\Stripe\Stripe::setApiKey("sk_test_K4DaK0QVmFZ7uqL91EETf6mE");




// Token is created using Checkout or Elements!
// Get the payment token ID submitted by the form:
$token = $_POST['stripeToken'];




// Charge the user's card:
$charge = \Stripe\Charge::create(array(
  "amount" => 999,
  "currency" => "usd",
  "description" => "Example charge Jose",
  "source" => $token,
));







?>


