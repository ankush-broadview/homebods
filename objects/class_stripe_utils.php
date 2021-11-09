<?php
include_once(dirname(__DIR__).'/header.php');
include_once(dirname(__DIR__).'/env.php');
require_once STRIPE_LIB_PATH;
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

class cleanto_stripe_utils {

    public $conn;
	public $offset;
	public $limit;
	public $table_name="ct_payments";
	public $tablename="ct_order_client_info";
	public $tablename_request="ct_transfer_request";

	public function getStripeAccountDetails ($accountId) {		
		$account = \Stripe\Account::retrieve($accountId);
		return $account;
	}

    public function createStripeAccount ($email = "") {
		$accountParams = [
		  'country' => 'US',
		  'type' => 'express',
		  'email' => $email
		];
		$account = \Stripe\Account::create($accountParams);
		return $account->id;
	}

	public function getStripeOnboardingLink ($account_id){
		$linkParams = [
			'account' => $account_id,
			'refresh_url' => SITE_URL.'stripe_reauth.php',
			'return_url' => SITE_URL.'stripe_reauth.php',
			'type' => 'account_onboarding',
		];
		//var_dump($linkParams);
		$account_links = \Stripe\AccountLink::create($linkParams);
		return $account_links->url;
	}

	

	public function generateResponse($intent)
	{
		switch ($intent->status) {
			case "requires_action":
 
			case "requires_confirmation":
			 return [
				 'requiresAction' => true,
				 'paymentIntentId' => $intent->id,
				 'clientSecret' => $intent->client_secret
			 ];
 
			case "requires_source_action":
				// Card requires authentication
				return [
					'requiresAction' => true,
					'paymentIntentId' => $intent->id,
					'clientSecret' => $intent->client_secret
				];
 
			case "requires_payment_method":
 
			case "requires_source":
				// Card was not properly authenticated, suggest a new payment method
				return [
					"error" => "Your card was denied, please provide a new payment method"
				];
			case "succeeded":
				// Payment is complete, authentication not required
				// To cancel the payment after capture you will need to issue a Refund (https://stripe.com/docs/api/refunds)
				return ['clientSecret' => $intent->client_secret];
		}
	}
 
	public function getClientSecret()
	{  
		try {
		 $requestArray = [
			 'amount' => 'required',          
			 'email' => 'required|email',
			 'paymentMethodId' => 'nullable',
			 'holder_name' => 'nullable'   , 
			 'user_id' => 'required', 
		 ];

		$payload = file_get_contents('php://input');
		$data = json_decode($payload,true);
		
		$input = $data;
		
		$amount =  $input["amount"];              
		     
		$email = $input["email"];
		$paymentMethodId = $data["paymentMethodId"];
		
 
		$intentParams = [
			 "amount" => $amount*100,
			 "currency" => "USD",
			 "receipt_email" => $email,
			 "payment_method" =>$paymentMethodId,            
			 "confirmation_method" => "automatic",
			 'capture_method' => 'manual'
			// "confirm" => true                
		 ];        
		
	
		 try {
			$intent = \Stripe\PaymentIntent::create($intentParams);                			
			$output = $this->generateResponse($intent);			 
			$this->jsonResponse(["status" =>true, "message" => "", "data" => $output]);
		 } catch (\Stripe\Exception\CardException $e) {           			 
			 $this->jsonResponse(["status" =>false, "message" =>$e->getMessage(), "data" =>[]]);
		 }
		} catch (\Throwable $th) {
			$this->jsonResponse(["status" =>false, "message" =>$th->getMessage(), "data" =>[]]);			
		}     
	 
	}
 
	public function confirmPaymentIntent()
	{       
		$input = $_REQUEST;
		$paymentIntentId = isset($input["paymentIntentId"]) ? $input["paymentIntentId"] : null;
		try {          
			$intent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
			$intent->confirm();
			$output = $this->generateResponse($intent);
			$this->jsonResponse(["status" =>true, "message" => "", "data" => $output]);
		} catch (\Stripe\Exception\CardException $e) {
			$this->jsonResponse(["status" =>false, "message" =>$e->getMessage(), "data" =>[]]);
		}
	}

	public function jsonResponse($data)
	{
		echo json_encode($data);
	}

}

$actions = [	
	"getClientSecret"
];
$payload = file_get_contents('php://input');
$data = json_decode($payload,true);
if (!empty($data)) {
	$route = $data["route"];
	$obj = new cleanto_stripe_utils();
	if (in_array($route,$actions)) {
		$obj->{$route}();
	}
}

// else{	
// 	$obj->jsonResponse(["status" =>false, "message" =>"Route not found", "data" =>[]]);
// }

?>