<?php
/**
 * 
 */
class Subscription
{
	
	public function createSubscription($token, $email){
				
		// Set API key
		\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

		// Add customer to stripe
		$customer = \Stripe\Customer::create(array(
			'email' => $email,
			'source'  => $token
		));
		// Unique order ID
		$orderID = strtoupper(str_replace('.','',uniqid('', true)));
				
		// Charge a credit or a debit card
		$charge = \Stripe\Subscription::create(array(
			'customer' => $customer->id,
			'items' => [['plan' => PLAN_ID]],
			'metadata' => array(
				'order_id' => $orderID
			)
		));
		// $chargeJson = $charge->jsonSerialize();
		if($charge){			
			return $charge;
		}
		else {
			return $mysqli->error;
		}
	}

	public function saveUserSubscription(){
		global $mysqli;
		$statement = $mysqli->prepare("INSERT INTO orders(userId, customerId, subscriptionId, name, email, card_number, card_exp_month, card_exp_year, paid_amount, paid_amount_currency, current_period_end, payment_status, orderId, createdAt, updatedAt)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$statement->bind_param('issssiiissdssdd', $this->userId, $this->customerId, $this->subscriptionId, $this->name, $this->email, $this->card_number, $this->card_exp_month, $this->card_exp_year, $this->itemPrice, $this->currency, $this->current_period_end, $this->payment_status, $this->orderId, $this->createdAt, $this->updatedAt);
		$r = $statement->execute();
		$statement->close();
		if($r){
			return $mysqli->insert_id;
		}
		else{
			return $mysqli->error;
		}  
	}	
}
?>