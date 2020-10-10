<?php
/**
 * 
 */
class Order
{
	public function getSubscriberData($userId){
		global $mysqli;
		$statement = $mysqli->prepare("SELECT id, userId, customerId, subscriptionId, current_period_end, payment_status, orderId FROM orders WHERE userId = ? AND isdeleted = 0");
		$statement->bind_param('i', $userId);
		if($statement){
			$statement->execute();
			$statement->bind_result($id, $userId, $customerId, $subscriptionId, $current_period_end, $payment_status, $orderId);
			if ($statement->fetch()) {
				$o = new Order();
				$o->id = $id;
				$o->customerId = $customerId;
				$o->subscriptionId = $subscriptionId;
				$o->current_period_end = $current_period_end;
				$o->payment_status = $payment_status;
				$o->orderId = $orderId;
				$statement->close();
				return $o;
			}
			else{
				return NULL;
			}
		}
		else{
			return array();
		}		
	}

	public function getOrderData($userId, $subscriptionId){
		global $mysqli;
		global $itemName, $itemPrice, $currency;
		$statement = $mysqli->prepare("SELECT id, customerId, subscriptionId, payment_status, orderId FROM orders WHERE userId = ? AND subscriptionId = ?");
		$statement->bind_param('is', $userId, $subscriptionId);
		if($statement){
			$statement->execute();
			$statement->bind_result($id, $customerId, $subscriptionId, $payment_status, $orderId);
			if ($statement->fetch()) {
				$o = new Order();
				$o->id = $id;
				$o->customerId = $customerId;
				$o->subscriptionId = $subscriptionId;
				$o->orderId = $orderId;
				$o->payment_status = $payment_status;
				$o->itemName = $itemName;
				$o->itemPrice = $itemPrice;
				$o->currency = $currency;
				return $o;
				$statement->close();
			}
			else{
				return NULL;
			}
		}
		else{
			return new StdClass();
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

	public function updateOrderCurrentPeriodTime($userId, $customerId, $subscriptionId, $current_period_end, $orderId, $updatedAt){
		global $mysqli;
		
		$statement = $mysqli->prepare("UPDATE orders SET current_period_end = ?, updatedAt = ? WHERE customerId = ? AND subscriptionId = ? AND orderId = ? AND isdeleted = 0 AND userId = ?");
		$statement->bind_param('ddsssi', $current_period_end, $updatedAt, $customerId, $subscriptionId, $orderId, $userId);
		$r = $statement->execute();
		$statement->close();
		if($r){
			return true;
		}
		else{
			return false;
		}
	}
	public function cancelOrder($userId, $subscriptionId, $orderId, $status, $updatedAt){
		global $mysqli;
		$statement = $mysqli->prepare("UPDATE orders SET payment_status = ?, updatedAt = ?, isdeleted = 1 WHERE subscriptionId = ? AND payment_status = 'active' AND orderId = ? AND userId = ?");
		$statement->bind_param('sdssi', $status, $updatedAt, $subscriptionId, $orderId, $userId);
		$r = $statement->execute();
		$statement->close();
		if($r){
			return true;
		}
		else{
			return false;
		}
	}
}
?>

