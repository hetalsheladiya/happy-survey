<?php
    $BASE_URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/hpysrvy.com/";
    define( 'API_ACCESS_KEY', 'AAAAszMnlxM:APA91bGocutgpnUqLMmbFI6-DEowX-GXaZhOBdgjqI1mbgrfGR9HuHtig6sFrNx8RQW5JCmqISeWogSAetcrGYVltAhkqgnW7dLQ7CrT7aYrNVMUSd5J6XgEgfKG6CSWPWmsQl4JI7Ov');

    $itemName = "TESTSURVEY"; 
	$itemNumber = "TESTHPSRVY"; 
	$itemPrice = 10; 
	$currency = "USD";	
	define('PLAN_ID', 'plan_GjV022n6BkjjNT'); 
	
	// Stripe API configuration
	define('STRIPE_API_KEY', 'sk_test_10JUfvR1PKjcDJa01K8RUEzH00hOEVEQdd');
	define('STRIPE_PUBLISHABLE_KEY', 'pk_test_bqLlCZkHCylUAk1YzWuVNnzD00Q4vqqtvl');
?>
