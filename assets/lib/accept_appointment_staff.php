<?php
include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_payments.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_adminprofile.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_balance_logs.php');
include(dirname(dirname(dirname(__FILE__)))."/header.php");
include_once(dirname(__DIR__).'/env.php');
require_once STRIPE_LIB_PATH;
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
$con = new cleanto_db();
$conn = $con->connect();
$booking= new cleanto_booking();
$admin= new cleanto_adminprofile();
$payment= new cleanto_payments();
$balancelogs= new cleanto_balance_logs();
$balancelogs->conn=$conn;
$booking->conn=$conn;
$admin->conn=$conn;
$payment->conn=$conn;
$stripe = new \Stripe\StripeClient(
	STRIPE_SECRET_KEY
  );
if(isset($_GET['id'])){
	$booking->id=$_GET['id'];
	$booking->status=$_GET['status'];
	if($_GET['status'] == "A"){
	$result=$booking->update_staff_status();
	if($result){
			?>
			<script>window.close();</script>
			<?php
		}
	}
	if($_GET['status'] == "D"){
		$result1=$booking->update_staff_status();
		$result=$booking->readone_bookings_sid_staff();
		$s_idd=$result['staff_id'];
		$booking->order_id=$result['order_id'];
		$result=$booking->readone_bookings_details_by_order_id();	
	  $data=$result['staff_ids'];
		$array_val=explode(',',$data);
		$x=array();
		foreach($array_val as $kk)
		{
			if($kk != $s_idd){
				array_push($x,$kk);
			}
		}
		$ord_id=$result['order_id'];
	    $s_id=implode(',',$x);
		$booking->booking_id=$result['order_id'];
		$booking->staff_id=$s_id;
		$result=$booking->update_staff_id_bookings_details_by_order_id();
		if($result){
			?>
			<script>window.close();</script>
			<?php
		}
	 }
 }
 
if(isset($_POST['action']) && $_POST['action']=='accept_appointment_staff'){
	$booking->id=$_POST['idd'];
	$booking->status=$_POST['staff_status'];
	$result=$booking->update_staff_status();

	$orderId = $_POST['order_id'];
	$bookingResult = $booking->getdatabyorder_id($orderId);

	$bookingData=mysqli_fetch_array($bookingResult);
	try {
		$resp = $stripe->paymentIntents->capture(
			$bookingData["payment_intent_id"]			
		  );
		if ($resp) {
			$paymentCaptureStatus = $resp["status"];
			if ($resp["status"]=="succeeded") {
				$paymentStatus = 1;
				$payment->update_payment_status($orderId,"Completed");
			}			
		}
		$id = $bookingData["id"];
		$booking->updateCaptureStatus($paymentStatus,$paymentCaptureStatus,$id);
	  } catch (\Throwable $th) {
		 // throw $th;
	  }
}
if(isset($_POST['action']) && $_POST['action']=='complete_appointment_staff'){
	$booking->id=$_POST['idd'];
	$booking->status=$_POST['staff_status'];
	$result=$booking->update_staff_status();
	$orderId = $_POST['order_id'];
	$bookingResult = $booking->getdatabyorder_id($orderId);
	$bookingData=mysqli_fetch_array($bookingResult);


	if (!empty($bookingData["staff_ids"])) {
		$admin->id = $bookingData["staff_ids"];
		$adminDetails = $admin->readone();
		if (!empty($adminDetails["stripe_account_id"]) && $adminDetails["stripe_account_status"]==1) {
			try {
				$resp = $stripe->paymentIntents->retrieve(
					$bookingData["payment_intent_id"]
				);
				$balancelogs->pro_id = $admin->id;
				$balance = $balancelogs->getProBalances();
				
				$proCommision = round($resp["amount"]* 0.8);

				if (!empty($balance)) {
					$proCommision = $proCommision-$balance;
				}

				if ($resp) {
					$charge = $resp->charges->data[0];
					try {
						$transfer = \Stripe\Transfer::create([
							"amount" => $proCommision,
							"currency" => "usd",
							"source_transaction" => $charge->id,
							"destination" => $adminDetails["stripe_account_id"],
							['metadata' => [
								'order_id' => $orderId ,
								'merchant_name' => $adminDetails["pro_user_id"]						
							]]
						]);
						if ($transfer) {					
							$balancelogs->updatestatus();
						}
					} catch (\Throwable $th) {
						throw $th;
					}
					
				}
			} catch (\Throwable $th) {
				throw $th;
			}			
		}
	}





}
if(isset($_POST['action']) && $_POST['action']=='decline_appointmentt_staff'){
	$booking->id=$_POST['idd'];
	$booking->status=$_POST['staff_status'];
	$result1=$booking->update_staff_status();
	$result=$booking->readone_bookings_sid_staff();
	$s_idd=$result['staff_id'];
	$booking->order_id=$result['order_id'];
	$result=$booking->readone_bookings_details_by_order_id();	
    $data=$result['staff_ids'];
	$array_val=explode(',',$data);
	$x=array();
	foreach($array_val as $kk)
	{
		if($kk != $s_idd){
			array_push($x,$kk);
		}
	}	
	$ord_id=$result['order_id'];
	$s_id=implode(',',$x);
	
	$booking->booking_id=$result['order_id'];
	$booking->staff_id=$s_id;
	$result1=$booking->update_staff_id_bookings_details_by_order_id();

	$booking->booking_status="CS";
	$booking->id=$result['id'];
	$result=$booking->update_booking_status();


	$bookingResult = $booking->getdatabyorder_id($ord_id);
	$bookingData = mysqli_fetch_array($bookingResult);

	if ($bookingData["payment_status"]=="1") {
		$intent = $stripe->paymentIntents->retrieve(
			$bookingData["payment_intent_id"]	
		);
	
		
		$charge = $intent->charges->data[0];
		try {
			$refund = \Stripe\Refund::create([
				'charge' => $charge->id,
			]);
	
			if ($refund) {				
				$balanceTxnObj = $stripe->balanceTransactions->retrieve($charge->balance_transaction);	
				$balancelogs->booking_id = $_POST['idd'];
				$balancelogs->pro_id = $s_idd;
				$balancelogs->amount = $balanceTxnObj->fee;
				$balancelogs->insert();
			}
		} catch (\Throwable $th) {
			//throw $th;
		}
		

	}else{
		try {
			$resp = $stripe->paymentIntents->cancel(
				$bookingData["payment_intent_id"]			
			  );						
		  } catch (\Throwable $th) {
			  throw $th;
		  }
	}


	  
	

}
?>