<?php
include(dirname(dirname(dirname(__FILE__))).'/objects/class_connection.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_booking.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_dashboard.php");
include(dirname(dirname(dirname(__FILE__))).'/objects/class_payments.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_adminprofile.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_balance_logs.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_front_first_step.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_general.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class.phpmailer.php');
include(dirname(dirname(dirname(__FILE__))).'/objects/class_email_template.php');
include(dirname(dirname(dirname(__FILE__)))."/objects/class_setting.php");
include(dirname(dirname(dirname(__FILE__)))."/header.php");
include_once(dirname(__DIR__).'/env.php');
require_once STRIPE_LIB_PATH;
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
$con = new cleanto_db();
$conn = $con->connect();
$objdashboard = new cleanto_dashboard();
$objdashboard->conn = $conn;
$booking= new cleanto_booking();
$admin= new cleanto_adminprofile();
$payment= new cleanto_payments();
$first_step=new cleanto_first_step();
$first_step->conn=$conn;
$objadminprofile = new cleanto_adminprofile();
$objadminprofile->conn = $conn;
$balancelogs= new cleanto_balance_logs();
$balancelogs->conn=$conn;
$booking->conn=$conn;
$admin->conn=$conn;
$payment->conn=$conn;
$setting = new cleanto_setting();
$setting->conn = $conn;
//for mail
if($setting->get_option('ct_smtp_authetication') == 'true'){
	$mail_SMTPAuth = '1';
	if($setting->get_option('ct_smtp_hostname') == "smtp.gmail.com"){
		$mail_SMTPAuth = 'Yes';
	}
}else{
	$mail_SMTPAuth = '0';
	if($setting->get_option('ct_smtp_hostname') == "smtp.gmail.com"){
		$mail_SMTPAuth = 'No';
	}
}
$mail = new cleanto_phpmailer();
$mail->Host = $setting->get_option('ct_smtp_hostname');
$mail->Username = $setting->get_option('ct_smtp_username');
$mail->Password = $setting->get_option('ct_smtp_password');
$mail->Port = $setting->get_option('ct_smtp_port');
$mail->SMTPSecure = $setting->get_option('ct_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail->CharSet = "UTF-8";
$mail_a = new cleanto_phpmailer();
$mail_a->Host = $setting->get_option('ct_smtp_hostname');
$mail_a->Username = $setting->get_option('ct_smtp_username');
$mail_a->Password = $setting->get_option('ct_smtp_password');
$mail_a->Port = $setting->get_option('ct_smtp_port');
$mail_a->SMTPSecure = $setting->get_option('ct_smtp_encryption');
$mail_a->SMTPAuth = $mail_SMTPAuth;
$mail_a->CharSet = "UTF-8";
$mail_s = new cleanto_phpmailer();
$mail_s->Host = $setting->get_option('ct_smtp_hostname');
$mail_s->Username = $setting->get_option('ct_smtp_username');
$mail_s->Password = $setting->get_option('ct_smtp_password');
$mail_s->Port = $setting->get_option('ct_smtp_port');
$mail_s->SMTPSecure = $setting->get_option('ct_smtp_encryption');
$mail_s->SMTPAuth = $mail_SMTPAuth;
$mail_s->CharSet = "UTF-8";


/*NEXMO SMS GATEWAY VARIABLES*/
$nexmo_admin->ct_nexmo_api_key = $setting->get_option('ct_nexmo_api_key');
$nexmo_admin->ct_nexmo_api_secret = $setting->get_option('ct_nexmo_api_secret');
$nexmo_admin->ct_nexmo_from = $setting->get_option('ct_nexmo_from');
$nexmo_client->ct_nexmo_api_key = $setting->get_option('ct_nexmo_api_key');
$nexmo_client->ct_nexmo_api_secret = $setting->get_option('ct_nexmo_api_secret');
$nexmo_client->ct_nexmo_from = $setting->get_option('ct_nexmo_from');
$general=new cleanto_general();
$general->conn=$conn;
$symbol_position=$setting->get_option('ct_currency_symbol_position');
$decimal=$setting->get_option('ct_price_format_decimal_places');
$emailtemplate=new cleanto_email_template();
$emailtemplate->conn=$conn;
$getcurrency_symbol_position=$setting->get_option('ct_currency_symbol_position');
$getdateformate = $setting->get_option('ct_date_picker_date_format');
$time_format = $setting->get_option('ct_time_format');
$booking = new cleanto_booking();
$booking->conn = $conn;
$lang = $setting->get_option("ct_language");
$label_language_values = array();
$language_label_arr = $setting->get_all_labelsbyid($lang);
/*SMS GATEWAY VARIABLES*/
$plivo_sender_number = $setting->get_option('ct_sms_plivo_sender_number');
$twilio_sender_number = $setting->get_option('ct_sms_twilio_sender_number');
/* textlocal gateway variables */
$textlocal_username =$setting->get_option('ct_sms_textlocal_account_username');
$textlocal_hash_id = $setting->get_option('ct_sms_textlocal_account_hash_id');
/*NEED VARIABLE FOR EMAIL*/
$company_city = $setting->get_option('ct_company_city'); $company_state = $setting->get_option('ct_company_state'); $company_zip = $setting->get_option('ct_company_zip_code'); $company_country = $setting->get_option('ct_company_country'); 
$company_phone = strlen($setting->get_option('ct_company_phone')) < 6 ? "" : $setting->get_option('ct_company_phone');
$company_email = $setting->get_option('ct_company_email');$company_address = $setting->get_option('ct_company_address'); 
/*CHECK FOR VC AND PARKING STATUS*/
$global_vc_status = $setting->get_option('ct_vc_status');
$global_p_status = $setting->get_option('ct_p_status');
$admin_phone_twilio = $setting->get_option('ct_sms_twilio_admin_phone_number');
$admin_phone_plivo = $setting->get_option('ct_sms_plivo_admin_phone_number');
/*CHECK FOR VC AND PARKING STATUS END*/
/*  set admin name */
$get_admin_name_result = $objadminprofile->readone_adminname();
$get_admin_name = $get_admin_name_result[3];
if($get_admin_name == ""){
	$get_admin_name = "Admin";
}
$admin_email = $setting->get_option('ct_admin_optional_email');
/* set admin name */
//for mail
if($setting->get_option('ct_company_logo') != null && $setting->get_option('ct_company_logo') != ""){
	$business_logo= SITE_URL.'assets/images/services/'.$setting->get_option('ct_company_logo');
	$business_logo_alt= $setting->get_option('ct_company_name');
}else{
	$business_logo= '';
	$business_logo_alt= $setting->get_option('ct_company_name');
}
/* set business logo and logo alt */
if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != ""){
	$default_language_arr = $setting->get_all_labelsbyid("en");
	if($language_label_arr[1] != ''){
		$label_decode_front = base64_decode($language_label_arr[1]);
	}else{
		$label_decode_front = base64_decode($default_language_arr[1]);
	}
	if($language_label_arr[3] != ''){
		$label_decode_admin = base64_decode($language_label_arr[3]);
	}else{
		$label_decode_admin = base64_decode($default_language_arr[3]);
	}
	if($language_label_arr[4] != ''){
		$label_decode_error = base64_decode($language_label_arr[4]);
	}else{
		$label_decode_error = base64_decode($default_language_arr[4]);
	}
	if($language_label_arr[5] != ''){
		$label_decode_extra = base64_decode($language_label_arr[5]);
	}else{
		$label_decode_extra = base64_decode($default_language_arr[5]);
	}
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
} else {
  $default_language_arr = $setting->get_all_labelsbyid("en");
	$label_decode_front = base64_decode($default_language_arr[1]);
	$label_decode_admin = base64_decode($default_language_arr[3]);
	$label_decode_error = base64_decode($default_language_arr[4]);
	$label_decode_extra = base64_decode($default_language_arr[5]);
	$label_decode_front_unserial = unserialize($label_decode_front);
	$label_decode_admin_unserial = unserialize($label_decode_admin);
	$label_decode_error_unserial = unserialize($label_decode_error);
	$label_decode_extra_unserial = unserialize($label_decode_extra);
	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);
	foreach($label_language_arr as $key => $value){
		$label_language_values[$key] = urldecode($value);
	}
}

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

	  //for mail
	  $id = $orderId;
	$orderdetail = $objdashboard->getclientorder($id);
	$client_ids = $orderdetail[3];
	$client_id = $objdashboard->getgriderid($client_ids);
	$grinders_id = $client_id[21];
	$lastmodify = date('Y-m-d H:i:s');
	$clientdetail = $objdashboard->clientemailsender($id);
	$admin_company_name = $setting->get_option('ct_company_name');
	$setting_date_format = $setting->get_option('ct_date_picker_date_format');
	$setting_time_format = $setting->get_option('ct_time_format');
	$booking_date = str_replace($english_date_array,$selected_lang_label,date($setting_date_format,strtotime($clientdetail['booking_date_time'])));
	if($setting_time_format == 12){
		$booking_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($clientdetail['booking_date_time'])));
	} else {
		$booking_time = date("H:i", strtotime($clientdetail['booking_date_time']));
	}
	$company_name = $setting->get_option('ct_email_sender_name');
	$company_email = $setting->get_option('ct_email_sender_address');
	$service_name = $clientdetail['title'];
	if($admin_email == ""){
		$admin_email = $clientdetail['email'];	
	}
  $price=$general->ct_price_format($orderdetail[2],$symbol_position,$decimal);
	/* methods */
	$units =  $label_language_values['none'];
	$methodname=$label_language_values['none'];
	$hh = $booking->get_methods_ofbookings($orderdetail[4]);
	$count_methods = mysqli_num_rows($hh);
	$hh1 = $booking->get_methods_ofbookings($orderdetail[4]);
	if($count_methods > 0){
		while($jj = mysqli_fetch_array($hh1)){
			if($units == $label_language_values['none']){
				$units = $jj['units_title']."-".$jj['qtys'];
			} else {
				$units = $units.",".$jj['units_title']."-".$jj['qtys'];
			}
			$methodname = $jj['method_title'];
		}
	}
	/* Add ons */
	$addons = $label_language_values['none'];
	$hh = $booking->get_addons_ofbookings($orderdetail[4]);
	while($jj = mysqli_fetch_array($hh)){
		if($addons == $label_language_values['none']){
			$addons = $jj['addon_service_name']."-".$jj['addons_service_qty'];
		} else {
			$addons = $addons.",".$jj['addon_service_name']."-".$jj['addons_service_qty'];
		}
	}
	/*if this is guest user than */
	if($orderdetail[4]==0){
		$gc  = $objdashboard->getguestclient($orderdetail[4]);
		$temppp= unserialize(base64_decode($gc[5]));
		$temp = str_replace('\\','',$temppp);
		$vc_status = $temp['vc_status'];
		if($vc_status == 'N'){
			$final_vc_status = $label_language_values['no'];
		} elseif($vc_status == 'Y'){
			$final_vc_status = $label_language_values['yes'];
		}else{
			$final_vc_status = "N/A";
		}
		$p_status = $temp['p_status'];
		if($p_status == 'N'){
			$final_p_status = $label_language_values['no'];
		} elseif($p_status == 'Y'){
			$final_p_status = $label_language_values['yes'];
		}else{
			$final_p_status = "N/A";
		}
		
		$client_name=$gc[2];
		$client_email=$gc[3];
		$phone_length = strlen($gc[4]);
		if($phone_length > 6){
			$client_phone = $gc[4];
		}else{
			$client_phone = "N/A";
		}
		$firstname=$client_name;
		$lastname='';
		$booking_status=$orderdetail[6];
		$final_vc_status;
		$final_p_status;
		$payment_status=$orderdetail[5];
		$client_address=$temp['address'];
		$client_notes=$temp['notes'];
		$client_status=$temp['contact_status'];		$client_city = $temp['city'];		$client_state = $temp['state'];		$client_zip	= $temp['zip'];
	} else {
		/*Registered user */
		$c  = $objdashboard->getguestclient($orderdetail[4]);
		$temppp= unserialize(base64_decode($c[5]));
		$temp = str_replace('\\','',$temppp);
		$vc_status = $temp['vc_status'];
		if($vc_status == 'N'){
				$final_vc_status = $label_language_values['no'];
		}
		elseif($vc_status == 'Y'){
				$final_vc_status = $label_language_values['yes'];
		}else{
				$final_vc_status = "N/A";
		}
		$p_status = $temp['p_status'];
		if($p_status == 'N'){
				$final_p_status = $label_language_values['no'];
		}
		elseif($p_status == 'Y'){
				$final_p_status = $label_language_values['yes'];
		}else{
				$final_p_status = "N/A";
		}
		$client_name=$c[2];
		$client_email=$c[3];
		$phone_length = strlen($c[4]);
		if($phone_length > 6){
			$client_phone = $c[4];
		}else{
			$client_phone = "N/A";
		}
		$client_name_value="";
		$client_first_name="";
		$client_last_name="";
		$client_name_value= explode(" ",$client_name);
		$client_first_name = $client_name_value[0];
		$client_last_name =	$client_name_value[1];
		if($client_first_name=="" && $client_last_name==""){
			$firstname = "User";
			$lastname = "";
			$client_name = $firstname.' '.$lastname;
		}elseif($client_first_name!="" && $client_last_name!=""){
			$firstname = $client_first_name;
			$lastname = $client_last_name;
			$client_name = $firstname.' '.$lastname;
		}elseif($client_first_name!=""){
			$firstname = $client_first_name;
			$lastname = "";
			$client_name = $firstname.' '.$lastname;
		}elseif($client_last_name!=""){
			$firstname = "";
			$lastname = $client_last_name;
			$client_name = $firstname.' '.$lastname;
		}
		$client_notes = $temp['notes'];	
		if($client_notes==""){
			$client_notes = "N/A";
		}
		$client_status = $temp['contact_status'];	
		if($client_status==""){
			$client_status = "N/A";
		}
		$payment_status=$orderdetail[5];
		$final_vc_status;
		$final_p_status;
		$client_address=$temp['address'];
		$client_city = $temp['city'];		
		$client_state = $temp['state'];		
		$client_zip	= $temp['zip'];
	}
	$payment_status = strtolower($payment_status);
	if($payment_status == "pay at venue"){
		$payment_status = ucwords($label_language_values['pay_locally']);
	}else{
		$payment_status = ucwords($payment_status);
	}
	$staff_ids = $booking->get_staff_ids_from_bookings($id);
	if($staff_ids != ''){
		$staff_idss = explode(',',$staff_ids);
		if(sizeof((array)$staff_idss) > 0){
			foreach($staff_idss as $sid){
				$staffdetails = $booking->get_staff_detail_for_email($sid);
				$pro_user_id = $staffdetails['pro_user_id'];
				$staff_name = $staffdetails['fullname'];
				$staff_email = $staffdetails['email'];		
				$staff_phone = $staffdetails['phone'];		
				$searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{methodname}}','{{units}}','{{addons}}','{{client_email}}','{{phone}}','{{payment_method}}','{{vaccum_cleaner_status}}','{{parking_status}}','{{notes}}','{{contact_status}}','{{address}}','{{price}}','{{admin_name}}','{{firstname}}','{{lastname}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_user_id}}');
				$replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, $client_name,$methodname, $units, $addons,$client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status,$client_address,$price,$get_admin_name,$firstname,$lastname,'','',$admin_company_name,$booking_time,$client_city,$client_state,$client_zip,$company_city,$company_state,$company_zip,$company_country,$company_phone,$company_email,$company_address,$get_admin_name,$pro_user_id);
				$emailtemplate->email_subject="Appointment Approved";
				$emailtemplate->user_type="C";
				$clientemailtemplate=$emailtemplate->readone_client_email_template_body();
				if($clientemailtemplate[2] != ''){
					$clienttemplate = base64_decode($clientemailtemplate[2]);
				}else{
					$clienttemplate = base64_decode($clientemailtemplate[3]);
				}
				$subject=$label_language_values[strtolower(str_replace(" ","_",$clientemailtemplate[1]))];
				if($setting->get_option('ct_client_email_notification_status') == 'Y' && $clientemailtemplate[4]=='E' ){
						$client_email_body = str_replace($searcharray,$replacearray,$clienttemplate);
						if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
							$mail->IsSMTP();
						}else{
							$mail->IsMail();
						}
						$mail->SMTPDebug  = 0;
						$mail->IsHTML(true);
						$mail->From = $company_email;
						$mail->FromName = $company_name;
						$mail->Sender = $company_email;
						$mail->AddAddress($client_email, $client_name);
						$mail->Subject = $subject;
						$mail->Body = $client_email_body;
						$mail->send();
						$mail->ClearAllRecipients();
				}
				$emailtemplate->email_subject="Appointment Approved";
				$emailtemplate->user_type="A";
				$adminemailtemplate=$emailtemplate->readone_client_email_template_body();
				if($adminemailtemplate[2] != ''){
					$admintemplate = base64_decode($adminemailtemplate[2]);
				}else{
					$admintemplate = base64_decode($adminemailtemplate[3]);
				}
				$adminsubject=$label_language_values[strtolower(str_replace(" ","_",$adminemailtemplate[1]))];
				if($setting->get_option('ct_admin_email_notification_status')=='Y' && $adminemailtemplate[4]=='E'){
					$admin_email_body = str_replace($searcharray,$replacearray,$admintemplate);
					if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
						$mail_a->IsSMTP();
					}else{
						$mail_a->IsMail();
					}
					$mail_a->SMTPDebug  = 0;
					$mail_a->IsHTML(true);
					$mail_a->From = $company_email;
					$mail_a->FromName = $company_name;
					$mail_a->Sender = $company_email;
					$mail_a->AddAddress($admin_email, $get_admin_name);
					$mail_a->Subject = $adminsubject;
					$mail_a->Body = $admin_email_body;
					$mail_a->send();
					$mail_a->ClearAllRecipients();
				}
					
				$staff_searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{methodname}}','{{units}}','{{addons}}','{{client_email}}','{{phone}}','{{payment_method}}','{{vaccum_cleaner_status}}','{{parking_status}}','{{notes}}','{{contact_status}}','{{address}}','{{price}}','{{admin_name}}','{{firstname}}','{{lastname}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_name}}','{{staff_email}}','{{client_user_id}}');
				$staff_replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, $client_name,$methodname, $units, $addons,$client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status,$client_address,$price,$get_admin_name,$firstname,$lastname,'','',$admin_company_name,$booking_time,$client_city,$client_state,$client_zip,$company_city,$company_state,$company_zip,$company_country,$company_phone,$company_email,$company_address,$get_admin_name,$staff_name,$staff_email,$grinders_id);
				$emailtemplate->email_subject="Appointment Approved";
				$emailtemplate->user_type="S";
				$staffemailtemplate=$emailtemplate->readone_client_email_template_body();
				if($staffemailtemplate[2] != ''){
					$stafftemplate = base64_decode($staffemailtemplate[2]);
				}else{
					$stafftemplate = base64_decode($staffemailtemplate[3]);
				}
				$subject=$label_language_values[strtolower(str_replace(" ","_",$staffemailtemplate[1]))];
				if($setting->get_option('ct_staff_email_notification_status') == 'Y' && $staffemailtemplate[4]=='E' ){
					$client_email_body = str_replace($staff_searcharray,$staff_replacearray,$stafftemplate);
					if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
						$mail_s->IsSMTP();
					}else{
						$mail_s->IsMail();
					}
					$mail_s->SMTPDebug  = 0;
					$mail_s->IsHTML(true);
					$mail_s->From = $company_email;
					$mail_s->FromName = $company_name;
					$mail_s->Sender = $company_email;
					$mail_s->AddAddress($staff_email, $staff_name);
					$mail_s->Subject = $subject;
					$mail_s->Body = $client_email_body;
					$mail_s->send();
					$mail_s->ClearAllRecipients();
				}
				/* TEXTLOCAL CODE */
				if($setting->get_option('ct_sms_textlocal_status') == "Y"){
					if($setting->get_option('ct_sms_textlocal_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){
							$template = $objdashboard->gettemplate_sms("C",'S');
							$phone = $staff_phone;				
							if($template[4] == "E") {
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								}
								else{
									$message = base64_decode($template[2]);
								}
							}
							$message = str_replace($staff_searcharray,$staff_replacearray,$message);
							$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
							
							$ch = curl_init('https://api.textlocal.in/send/?');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$result = curl_exec($ch);
							curl_close($ch);
						}
					}
				}
				/*PLIVO CODE*/
				if($setting->get_option('ct_sms_plivo_status')=="Y"){
					if($setting->get_option('ct_sms_plivo_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){	
							$auth_id = $setting->get_option('ct_sms_plivo_account_SID');
							$auth_token = $setting->get_option('ct_sms_plivo_auth_token');
							$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');
							$template = $objdashboard->gettemplate_sms("C",'S');
							$phone = $staff_phone;
							if($template[4] == "E"){
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								} else {
									$message = base64_decode($template[2]);
								}
								$client_sms_body = str_replace($staff_searcharray,$staff_replacearray,$message);
								/* MESSAGE SENDING CODE THROUGH PLIVO */
								$params = array(
									'src' => $plivo_sender_number,
									'dst' => $phone,
									'text' => $client_sms_body,
									'method' => 'POST'
								);
								$response = $p_client->send_message($params);
								/* MESSAGE SENDING CODE ENDED HERE*/
							}
						}
					}
				}
				if($setting->get_option('ct_sms_twilio_status') == "Y"){
					if($setting->get_option('ct_sms_twilio_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){
							$AccountSid = $setting->get_option('ct_sms_twilio_account_SID');
							$AuthToken =  $setting->get_option('ct_sms_twilio_auth_token'); 
							$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);
							$template = $objdashboard->gettemplate_sms("C",'S');
							$phone = $staff_phone;
							if($template[4] == "E") {
									if($template[2] == ""){
										$message = base64_decode($template[3]);
									} else{
										$message = base64_decode($template[2]);
									}
									$client_sms_body = str_replace($staff_searcharray,$staff_replacearray,$message);
									/*TWILIO CODE*/
									$message = $twilliosms_client->account->messages->create(array(
										"From" => $twilio_sender_number,
										"To" => $phone,
										"Body" => $client_sms_body));
							}
						}
					}
				}
				if($setting->get_option('ct_nexmo_status') == "Y"){
					if($setting->get_option('ct_sms_nexmo_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){	
							$template = $objdashboard->gettemplate_sms("C",'S');
							$phone = $staff_phone;				
							if($template[4] == "E") {
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								} else {
									$message = base64_decode($template[2]);
								}
								$ct_nexmo_text = str_replace($staff_searcharray,$staff_replacearray,$message);
								$res=$nexmo_client->send_nexmo_sms($phone,$ct_nexmo_text);
							}
						}
					}
				}
				/*SMS SENDING CODE END*/
			}
		}
	}
  /*** Email Code End ***/
	/*SMS SENDING CODE*/
	/*GET APPROVED SMS TEMPLATE*/
	/* TEXTLOCAL CODE */
	if($setting->get_option('ct_sms_textlocal_status') == "Y"){
		if($setting->get_option('ct_sms_textlocal_send_sms_to_client_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("C",'C');
			$phone = $client_phone;				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray,$replacearray,$message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init('https://api.textlocal.in/send/?');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		if($setting->get_option('ct_sms_textlocal_send_sms_to_admin_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("C",'A');
			$phone = $setting->get_option('ct_sms_textlocal_admin_phone');				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray,$replacearray,$message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init('https://api.textlocal.in/send/?');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
	}
  /*PLIVO CODE*/
  if($setting->get_option('ct_sms_plivo_status')=="Y"){
    if($setting->get_option('ct_sms_plivo_send_sms_to_client_status') == "Y"){
      $auth_id = $setting->get_option('ct_sms_plivo_account_SID');
			$auth_token = $setting->get_option('ct_sms_plivo_auth_token');
			$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');
			$template = $objdashboard->gettemplate_sms("C",'C');
      $phone = $client_phone;
			if($template[4] == "E"){
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/* MESSAGE SENDING CODE THROUGH PLIVO */
				$params = array(
						'src' => $plivo_sender_number,
						'dst' => $phone,
						'text' => $client_sms_body,
						'method' => 'POST'
				);
				print_r($params);
				$response = $p_client->send_message($params);
				/* MESSAGE SENDING CODE ENDED HERE*/
			}
		}
    if($setting->get_option('ct_sms_plivo_send_sms_to_admin_status') == "Y"){
      $auth_id = $setting->get_option('ct_sms_plivo_account_SID');
			$auth_token = $setting->get_option('ct_sms_plivo_auth_token');
			$p_admin = new Plivo\RestAPI($auth_id, $auth_token, '', '');
			$template = $objdashboard->gettemplate_sms("C",'A');
      $phone = $admin_phone_plivo;
      if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				$params = array(
					'src' => $plivo_sender_number,
					'dst' => $phone,
					'text' => $client_sms_body,
					'method' => 'POST'
				);
				$response = $p_admin->send_message($params);
				/* MESSAGE SENDING CODE ENDED HERE*/
			}
    }
  }
  if($setting->get_option('ct_sms_twilio_status') == "Y"){
    if($setting->get_option('ct_sms_twilio_send_sms_to_client_status') == "Y"){
			$AccountSid = $setting->get_option('ct_sms_twilio_account_SID');
			$AuthToken =  $setting->get_option('ct_sms_twilio_auth_token'); 
			$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);
			$template = $objdashboard->gettemplate_sms("C",'C');
      $phone = $client_phone;
      if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/*TWILIO CODE*/
				$message = $twilliosms_client->account->messages->create(array(
					"From" => $twilio_sender_number,
					"To" => $phone,
					"Body" => $client_sms_body));
      }
    }
    if($setting->get_option('ct_sms_twilio_send_sms_to_admin_status') == "Y"){
			$AccountSid = $setting->get_option('ct_sms_twilio_account_SID');
			$AuthToken =  $setting->get_option('ct_sms_twilio_auth_token'); 
			$twilliosms_admin = new Services_Twilio($AccountSid, $AuthToken);
			$template = $objdashboard->gettemplate_sms("C",'A');
      $phone = $admin_phone_twilio;
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray,$replacearray,$message);
				/*TWILIO CODE*/
				$message = $twilliosms_admin->account->messages->create(array(
					"From" => $twilio_sender_number,
					"To" => $phone,
					"Body" => $client_sms_body));
			}
    }
  }
	if($setting->get_option('ct_nexmo_status') == "Y"){
		if($setting->get_option('ct_sms_nexmo_send_sms_to_client_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("C",'C');
			$phone = $client_phone;				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$ct_nexmo_text = str_replace($searcharray,$replacearray,$message);
				$res=$nexmo_client->send_nexmo_sms($phone,$ct_nexmo_text);
			}
			
		}
		if($setting->get_option('ct_sms_nexmo_send_sms_to_admin_status') == "Y"){
			$template = $objdashboard->gettemplate_sms("C",'A');
			$phone = $setting->get_option('ct_sms_nexmo_admin_phone_number');				
			if($template[4] == "E") {
				if($template[2] == ""){
					$message = base64_decode($template[3]);
				}
				else{
					$message = base64_decode($template[2]);
				}
				$ct_nexmo_text = str_replace($searcharray,$replacearray,$message);
				$res=$nexmo_admin->send_nexmo_sms($phone,$ct_nexmo_text);
			}
			
		}
	}
  /*SMS SENDING CODE END*/

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
			
			
	$t_zone_value = $setting->get_option('ct_timezone');
	$server_timezone = date_default_timezone_get();
	if(isset($t_zone_value) && $t_zone_value!=''){
		$offset= $first_step->get_timezone_offset($server_timezone,$t_zone_value);
		$timezonediff = $offset/3600;  
	}else{
		$timezonediff =0;
	}
	if(is_numeric(strpos($timezonediff,'-'))){
		$timediffmis = str_replace('-','',$timezonediff)*60;
		$currDateTime_withTZ= strtotime("-".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
	}else{
		$timediffmis = str_replace('+','',$timezonediff)*60;
		$currDateTime_withTZ = strtotime("+".$timediffmis." minutes",strtotime(date('Y-m-d H:i:s')));
	}
	$lastmodify = date('Y-m-d H:i:s',$currDateTime_withTZ);
	$id = $order_id = $_POST['order_id'];
	$orderdetail = $objdashboard->getclientorder_api($id);
	$clientdetail = $objdashboard->clientemailsender($id);
	$admin_company_name = $setting->get_option("ct_company_name");
	$setting_date_format = $setting->get_option("ct_date_picker_date_format");
	$setting_time_format = $setting->get_option("ct_choose_time_format");
	$booking_date = str_replace($english_date_array,$selected_lang_label,date($setting_date_format, strtotime($clientdetail["booking_date_time"])));
	if ($setting_time_format == 12) {
		$booking_time = str_replace($english_date_array,$selected_lang_label,date("h:i A", strtotime($clientdetail["booking_date_time"])));
	} else {
		$booking_time = date("H:i", strtotime($clientdetail["booking_date_time"]));
	}
	$company_name = $setting->get_option("ct_email_sender_name");
	$company_email = $setting->get_option("ct_email_sender_address");
	$service_name = $clientdetail["title"];
	if ($admin_email == "") {
		$admin_email = $clientdetail["email"];
	}
	$price = $general->ct_price_format($orderdetail[2], $symbol_position, $decimal); /* methods */
	$units = $label_language_values["none"];
	$methodname = $label_language_values["none"];
	$hh = $booking->get_methods_ofbookings($orderdetail[4]);
	$count_methods = mysqli_num_rows($hh);
	$hh1 = $booking->get_methods_ofbookings($orderdetail[4]);
	if ($count_methods > 0) {
		while ($jj = mysqli_fetch_array($hh1)) {
			if ($units == $label_language_values["none"]) {
				$units = $jj["units_title"]."-".$jj["qtys"];
			} else {
				$units = $units.",".$jj["units_title"]."-".$jj["qtys"];
			}
			$methodname = $jj["method_title"];
		}
	}
	$addons = $label_language_values["none"];
	$hh = $booking->get_addons_ofbookings($orderdetail[4]);
	while ($jj = mysqli_fetch_array($hh)) {
		if ($addons == $label_language_values["none"]) {
			$addons = $jj["addon_service_name"]."-".$jj["addons_service_qty"];
		} else {
			$addons = $addons.",".$jj["addon_service_name"]."-".$jj["addons_service_qty"];
		}
	}
	if ($orderdetail[4] == 0) {
		$gc = $objdashboard->getguestclient($orderdetail[4]);
		$temppp = unserialize(base64_decode($gc[5]));
		$temp = str_replace("\\", "", $temppp);
		$vc_status = $temp["vc_status"];
		if ($vc_status == "N") {
			$final_vc_status = $label_language_values["no"];
		}
		elseif($vc_status == "Y") {
			$final_vc_status = $label_language_values["yes"];
		} else {
			$final_vc_status = "N/A";
		}
		$p_status = $temp["p_status"];
		if ($p_status == "N") {
			$final_p_status = $label_language_values["no"];
		}
		elseif($p_status == "Y") {
			$final_p_status = $label_language_values["yes"];
		} else {
			$final_p_status = "N/A";
		}
		$client_name = $gc[2];
		$client_email = $gc[3];
		$client_phone = $gc[4];
		$firstname = $client_name;
		$lastname = "";
		$booking_status = $orderdetail[6];
		$final_vc_status;
		$final_p_status;
		$payment_status = $orderdetail[5];
		$client_address = $temp["address"];
		$client_notes = $temp["notes"];
		$client_status = $temp["contact_status"];
		$client_city = $temp["city"];
		$client_state = $temp["state"];
		$client_zip = $temp["zip"];
	} else {
		$c = $objdashboard->getguestclient($orderdetail[4]);
		$temppp = unserialize(base64_decode($c[5]));
		$temp = str_replace("\\", "", $temppp);
		$vc_status = $temp["vc_status"];
		if ($vc_status == "N") {
			$final_vc_status = $label_language_values["no"];
		}
		elseif($vc_status == "Y") {
			$final_vc_status = $label_language_values["yes"];
		} else {
			$final_vc_status = "N/A";
		}
		$p_status = $temp["p_status"];
		if ($p_status == "N") {
			$final_p_status = $label_language_values["no"];
		}
		elseif($p_status == "Y") {
			$final_p_status = $label_language_values["yes"];
		} else {
			$final_p_status = "N/A";
		}
		$client_phone_no = $c[4];
		$client_phone_length = strlen($client_phone_no);
		if ($client_phone_length > 6) {
			$client_phone = $client_phone_no;
		} else {
			$client_phone = "N/A";
		}
		$client_namess = explode(" ", $c[2]);
		$cnamess = array_filter($client_namess);
		$ccnames = array_values($cnamess);
		if (sizeof((array)$ccnames) > 0) {
			$client_first_name = $ccnames[0];
			if (isset($ccnames[1])) {
					$client_last_name = $ccnames[1];
			} else {
					$client_last_name = "";
			}
		} else {
			$client_first_name = "";
			$client_last_name = "";
		}
		if ($client_first_name == "" && $client_last_name == "") {
			$firstname = "User";
			$lastname = "";
			$client_name = $firstname." ".$lastname;
		}
		elseif($client_first_name != "" && $client_last_name != "") {
			$firstname = $client_first_name;
			$lastname = $client_last_name;
			$client_name = $firstname." ".$lastname;
		}
		elseif($client_first_name != "") {
			$firstname = $client_first_name;
			$lastname = "";
			$client_name = $firstname." ".$lastname;
		}
		elseif($client_last_name != "") {
			$firstname = "";
			$lastname = $client_last_name;
			$client_name = $firstname." ".$lastname;
		}
		$client_notes = $temp["notes"];
		if ($client_notes == "") {
			$client_notes = "N/A";
		}
		$client_status = $temp["contact_status"];
		if ($client_status == "") {
			$client_status = "N/A";
		}
		$client_email = $c[3];
		$payment_status = $orderdetail[5];
		$final_vc_status;
		$final_p_status;
		$client_address = $temp["address"];
		$client_city = $temp["city"];
		$client_state = $temp["state"];
		$client_zip = $temp["zip"];
	}
				$staff_ids = $booking->get_staff_ids_from_bookings($id);
				$staffdetails = $booking->get_staff_detail_for_email($staff_ids);
				$staff_name = $staffdetails['fullname'];
	$searcharray = array("{{service_name}}", "{{booking_date}}", "{{business_logo}}", "{{business_logo_alt}}", "{{client_name}}", "{{methodname}}", "{{units}}", "{{addons}}", "{{client_email}}", "{{phone}}", "{{payment_method}}", "{{vaccum_cleaner_status}}", "{{parking_status}}", "{{notes}}", "{{contact_status}}", "{{address}}", "{{price}}", "{{admin_name}}", "{{firstname}}", "{{lastname}}", "{{app_remain_time}}", "{{reject_status}}", "{{company_name}}", "{{booking_time}}", "{{client_city}}", "{{client_state}}", "{{client_zip}}", "{{company_city}}", "{{company_state}}", "{{company_zip}}", "{{company_country}}", "{{company_phone}}", "{{company_email}}", "{{company_address}}", "{{admin_name}}", "{{staff_name}}", "{{staff_user_id}}");
	$replacearray = array($service_name, $booking_date, $business_logo, $business_logo_alt, $client_name, $methodname, $units, $addons, $client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status, $client_address, $price, $get_admin_name, $firstname, $lastname, "", "", $admin_company_name, $booking_time, $client_city, $client_state, $client_zip, $company_city, $company_state, $company_zip, $company_country, $company_phone, $company_email, $company_address, $get_admin_name, $staff_name, $staff_name);
	$emailtemplate->email_subject = "Appointment Completed";
	$emailtemplate->user_type = "C";
	$clientemailtemplate = $emailtemplate->readone_client_email_template_body();
	if ($clientemailtemplate[2] != "") {
		$clienttemplate = base64_decode($clientemailtemplate[2]);
	} else {
		$clienttemplate = base64_decode($clientemailtemplate[3]);
	}
	$subject = $clientemailtemplate[1];
	if ($setting->get_option("ct_client_email_notification_status") == "Y" && $clientemailtemplate[4] == "E") {
		$client_email_body = str_replace($searcharray, $replacearray, $clienttemplate);
		if ($setting->get_option("ct_smtp_hostname") != "" && $setting->get_option("ct_email_sender_name") != "" && $setting->get_option("ct_email_sender_address") != "" && $setting->get_option("ct_smtp_username") != "" && $setting->get_option("ct_smtp_password") != "" && $setting->get_option("ct_smtp_port") != "") {
			$mail->IsSMTP();
		} else {
			$mail->IsMail();
		}
		$mail->SMTPDebug = 0;
		$mail->IsHTML(true);
		$mail->From = $company_email;
		$mail->FromName = $company_name;
		$mail->Sender = $company_email;
		$mail->AddAddress($client_email, $client_name);
		$mail->Subject = $subject;
		$mail->Body = $client_email_body;
		$mail->send();
		$mail->ClearAllRecipients();
	}
	$emailtemplate->email_subject = "Appointment Completed";
	$emailtemplate->user_type = "A";
	$adminemailtemplate = $emailtemplate->readone_client_email_template_body();
	if ($adminemailtemplate[2] != "") {
		$admintemplate = base64_decode($adminemailtemplate[2]);
	} else {
		$admintemplate = base64_decode($adminemailtemplate[3]);
	}
	$adminsubject = $adminemailtemplate[1];
	if ($setting->get_option("ct_admin_email_notification_status") == "Y" && $adminemailtemplate[4] == "E") {
		$admin_email_body = str_replace($searcharray, $replacearray, $admintemplate);
		if ($setting->get_option("ct_smtp_hostname") != "" && $setting->get_option("ct_email_sender_name") != "" && $setting->get_option("ct_email_sender_address") != "" && $setting->get_option("ct_smtp_username") != "" && $setting->get_option("ct_smtp_password") != "" && $setting->get_option("ct_smtp_port") != "") {
			$mail_a->IsSMTP();
		} else {
			$mail_a->IsMail();
		}
		$mail_a->SMTPDebug = 0;
		$mail_a->IsHTML(true);
		$mail_a->From = $company_email;
		$mail_a->FromName = $company_name;
		$mail_a->Sender = $company_email;
		$mail_a->AddAddress($admin_email, $get_admin_name);
		$mail_a->Subject = $adminsubject;
		$mail_a->Body = $admin_email_body;
		$mail_a->send();
		$mail->ClearAllRecipients();
	}
	$staff_ids = $booking->get_staff_ids_from_bookings($id);
	if($staff_ids != ''){
		$staff_idss = explode(',',$staff_ids);
		if(sizeof((array)$staff_idss) > 0){
			foreach($staff_idss as $sid){
				$staffdetails = $booking->get_staff_detail_for_email($sid);
				$staff_name = $staffdetails['fullname'];
				$staff_email = $staffdetails['email'];		
				$staff_phone = $staffdetails['phone'];
				$staff_searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{methodname}}','{{units}}','{{addons}}','{{client_email}}','{{phone}}','{{payment_method}}','{{vaccum_cleaner_status}}','{{parking_status}}','{{notes}}','{{contact_status}}','{{address}}','{{price}}','{{admin_name}}','{{firstname}}','{{lastname}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_name}}','{{staff_email}}','{{client_user_id}}');
				$staff_replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, $client_name,$methodname, $units, $addons,$client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status,$client_address,$price,$get_admin_name,$firstname,$lastname,'','',$admin_company_name,$booking_time,$client_city,$client_state,$client_zip,$company_city,$company_state,$company_zip,$company_country,$company_phone,$company_email,$company_address,$get_admin_name,$staff_name,$staff_email,$client_name);
				$emailtemplate->email_subject="Appointment Completed";
				$emailtemplate->user_type="S";
				$staffemailtemplate=$emailtemplate->readone_client_email_template_body();
				if($staffemailtemplate[2] != ''){
					$stafftemplate = base64_decode($staffemailtemplate[2]);
				}else{
					$stafftemplate = base64_decode($staffemailtemplate[3]);
				}
				$subject=$label_language_values[strtolower(str_replace(" ","_",$staffemailtemplate[1]))];
				if($setting->get_option('ct_staff_email_notification_status') == 'Y' && $staffemailtemplate[4]=='E' ){
					$client_email_body = str_replace($staff_searcharray,$staff_replacearray,$stafftemplate);
					if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
						$mail_s->IsSMTP();
					}else{
						$mail_s->IsMail();
					}
					$mail_s->SMTPDebug  = 0;
					$mail_s->IsHTML(true);
					$mail_s->From = $company_email;
					$mail_s->FromName = $company_name;
					$mail_s->Sender = $company_email;
					$mail_s->AddAddress($staff_email, $staff_name);
					$mail_s->Subject = $subject;
					$mail_s->Body = $client_email_body;
					$mail_s->send();
					$mail_s->ClearAllRecipients();
				}
				/* TEXTLOCAL CODE */
				if($setting->get_option('ct_sms_textlocal_status') == "Y"){
					if($setting->get_option('ct_sms_textlocal_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){
							$template = $objdashboard->gettemplate_sms("CO",'S');
							$phone = $staff_phone;				
							if($template[4] == "E") {
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								}
								else{
									$message = base64_decode($template[2]);
								}
							}
							$message = str_replace($staff_searcharray,$staff_replacearray,$message);
							$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
							
							$ch = curl_init('https://api.textlocal.in/send/?');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$result = curl_exec($ch);
							curl_close($ch);
						}
					}
				}
				/*PLIVO CODE*/
				if($setting->get_option('ct_sms_plivo_status')=="Y"){
					if($setting->get_option('ct_sms_plivo_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){	
							$auth_id = $setting->get_option('ct_sms_plivo_account_SID');
							$auth_token = $setting->get_option('ct_sms_plivo_auth_token');
							$p_client = new Plivo\RestAPI($auth_id, $auth_token, '', '');
							$template = $objdashboard->gettemplate_sms("CO",'S');
							$phone = $staff_phone;
							if($template[4] == "E"){
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								}
								else{
									$message = base64_decode($template[2]);
								}
								$client_sms_body = str_replace($staff_searcharray,$staff_replacearray,$message);
								/* MESSAGE SENDING CODE THROUGH PLIVO */
								$params = array(
									'src' => $plivo_sender_number,
									'dst' => $phone,
									'text' => $client_sms_body,
									'method' => 'POST'
								);
								print_r($params);
								$response = $p_client->send_message($params);
								/* MESSAGE SENDING CODE ENDED HERE*/
							}
						}
					}
				}
				if($setting->get_option('ct_sms_twilio_status') == "Y"){
					if($setting->get_option('ct_sms_twilio_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){
							$AccountSid = $setting->get_option('ct_sms_twilio_account_SID');
							$AuthToken =  $setting->get_option('ct_sms_twilio_auth_token'); 
							$twilliosms_client = new Services_Twilio($AccountSid, $AuthToken);
							$template = $objdashboard->gettemplate_sms("CO",'S');
							$phone = $staff_phone;
							if($template[4] == "E") {
									if($template[2] == ""){
										$message = base64_decode($template[3]);
									} else {
										$message = base64_decode($template[2]);
									}
									$client_sms_body = str_replace($staff_searcharray,$staff_replacearray,$message);
									/*TWILIO CODE*/
									$message = $twilliosms_client->account->messages->create(array(
										"From" => $twilio_sender_number,
										"To" => $phone,
										"Body" => $client_sms_body));
							}
						}
					}
				}
				if($setting->get_option('ct_nexmo_status') == "Y"){
					if($setting->get_option('ct_sms_nexmo_send_sms_to_staff_status') == "Y"){
						if(isset($staff_phone) && !empty($staff_phone)){	
							$template = $objdashboard->gettemplate_sms("CO",'S');
							$phone = $staff_phone;				
							if($template[4] == "E") {
								if($template[2] == ""){
									$message = base64_decode($template[3]);
								} else {
									$message = base64_decode($template[2]);
								}
								$ct_nexmo_text = str_replace($staff_searcharray,$staff_replacearray,$message);
								$res=$nexmo_client->send_nexmo_sms($phone,$ct_nexmo_text);
							}
						}
					}
				}
			}
		}
	}
	if ($setting->get_option("ct_sms_textlocal_status") == "Y") {
		if ($setting->get_option("ct_sms_textlocal_send_sms_to_client_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "C");
			$phone = $client_phone;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray, $replacearray, $message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init("https://api.textlocal.in/send/?");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		if ($setting->get_option("ct_sms_textlocal_send_sms_to_admin_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "A");
			$phone = $setting->get_option("ct_sms_textlocal_admin_phone");
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
			}
			$message = str_replace($searcharray, $replacearray, $message);
			$data = "username=".$textlocal_username."&hash=".$textlocal_hash_id."&message=".$message."&numbers=".$phone."&test=0";
			$ch = curl_init("https://api.textlocal.in/send/?");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
	}
	if ($setting->get_option("ct_sms_plivo_status") == "Y") {
		$auth_id = $setting->get_option("ct_sms_plivo_account_SID");
		$auth_token = $setting->get_option("ct_sms_plivo_auth_token");
		$p = new Plivo\ RestAPI($auth_id, $auth_token, "", "");
		$plivo_sender_number = $setting->get_option("ct_sms_plivo_sender_number");
		$twilio_sender_number = $setting->get_option("ct_sms_twilio_sender_number");
		if ($setting->get_option("ct_sms_plivo_send_sms_to_client_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "C");
			$phone = $client_phone;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray, $replacearray, $message);
				$params = array("src" => $plivo_sender_number, "dst" => $phone, "text" => $client_sms_body, "method" => "POST");
				$response = $p->send_message($params);
			}
		}
		if ($setting->get_option("ct_sms_plivo_send_sms_to_admin_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "A");
			$phone = $admin_phone_plivo;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray, $replacearray, $message);
				$params = array("src" => $plivo_sender_number, "dst" => $phone, "text" => $client_sms_body, "method" => "POST");
				$response = $p->send_message($params);
			}
		}
	}
	if ($setting->get_option("ct_sms_twilio_status") == "Y") {
		if ($setting->get_option("ct_sms_twilio_send_sms_to_client_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "C");
			$phone = $client_phone;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray, $replacearray, $message);
				$message = $twilliosms->account->messages->create(array("From" => $twilio_sender_number, "To" => $phone, "Body" => $client_sms_body));
			}
		}
		if ($setting->get_option("ct_sms_twilio_send_sms_to_admin_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "A");
			$phone = $admin_phone_twilio;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$client_sms_body = str_replace($searcharray, $replacearray, $message);
				$message = $twilliosms->account->messages->create(array("From" => $twilio_sender_number, "To" => $phone, "Body" => $client_sms_body));
			}
		}
	}
	if ($setting->get_option("ct_nexmo_status") == "Y") {
		if ($setting->get_option("ct_sms_nexmo_send_sms_to_client_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "C");
			$phone = $client_phone;
			$phone = $client_phone;
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$ct_nexmo_text = str_replace($searcharray, $replacearray, $message);
				$res = $nexmo_client->send_nexmo_sms($phone, $ct_nexmo_text);
			}
		}
		if ($setting->get_option("ct_sms_nexmo_send_sms_to_admin_status") == "Y") {
			$template = $objdashboard->gettemplate_sms("CO", "A");
			$phone = $setting->get_option("ct_sms_nexmo_admin_phone_number");
			if ($template[4] == "E") {
				if ($template[2] == "") {
					$message = base64_decode($template[3]);
				} else {
					$message = base64_decode($template[2]);
				}
				$ct_nexmo_text = str_replace($searcharray, $replacearray, $message);
				$res = $nexmo_admin->send_nexmo_sms($phone, $ct_nexmo_text);
			}
		}
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

	$id = $booking->order_id;
	$client_name = "";
	$orderdetail = $objdashboard->getclientorder($id);
	$client_ids = $orderdetail[3];
	$client_id = $objdashboard->getgriderid($client_ids);
	$grinders_id = $client_id[21];
  $clientdetail = $objdashboard->clientemailsender($id);
	$pid = $_POST['pid'];
	
	$admin_company_name = $setting->get_option('ct_company_name');
	$setting_date_format = $setting->get_option('ct_date_picker_date_format');
	$setting_time_format = $setting->get_option('ct_time_format');
	$booking_date = str_replace($english_date_array,$selected_lang_label,date($setting_date_format,strtotime($clientdetail['booking_date_time'])));
	if($setting_time_format == 12){
		$booking_time = str_replace($english_date_array,$selected_lang_label,date("h:i A",strtotime($clientdetail['booking_date_time'])));
	} else{
		$booking_time = date("H:i", strtotime($clientdetail['booking_date_time']));
	}
	$company_name = $setting->get_option('ct_email_sender_name');
    $company_email = $setting->get_option('ct_email_sender_address');
	$service_name = $clientdetail['title'];
	if($admin_email == ""){
		$admin_email = $clientdetail['email'];	
	}
	$price=$general->ct_price_format($orderdetail[2],$symbol_position,$decimal);
	$units = $label_language_values['none'];
	$methodname=$label_language_values['none'];
	$hh = $booking->get_methods_ofbookings($orderdetail[4]);
	$count_methods = mysqli_num_rows($hh);
	$hh1 = $booking->get_methods_ofbookings($orderdetail[4]);
	if($count_methods > 0){
		while($jj = mysqli_fetch_array($hh1)){
			if($units == $label_language_values['none']){
				$units = $jj['units_title']."-".$jj['qtys'];
			} else {
				$units = $units.",".$jj['units_title']."-".$jj['qtys'];
			}
			$methodname = $jj['method_title'];
		}
	}
	/* Add ons */
	$addons = $label_language_values['none'];
	$hh = $booking->get_addons_ofbookings($orderdetail[4]);
	while($jj = mysqli_fetch_array($hh)){
		if($addons == $label_language_values['none']){
			$addons = $jj['addon_service_name']."-".$jj['addons_service_qty'];
		} else {
			$addons = $addons.",".$jj['addon_service_name']."-".$jj['addons_service_qty'];
		}
	}
	/*if this is guest user than */									
	if($orderdetail[4]==0){
		$gc  = $objdashboard->getguestclient($orderdetail[4]);
		$temppp= unserialize(base64_decode($gc[5]));
		$temp = str_replace('\\','',$temppp);
		$vc_status = $temp['vc_status'];
		if($vc_status == 'N'){
			$final_vc_status = $label_language_values['no'];
		}
		elseif($vc_status == 'Y'){
			$final_vc_status = $label_language_values['yes'];
		}else{
			$final_vc_status = "N/A";
		}
		$p_status = $temp['p_status'];
		if($p_status == 'N'){
			$final_p_status = $label_language_values['no'];
		}
		elseif($p_status == 'Y'){
			$final_p_status = $label_language_values['yes'];
		}else{
			$final_p_status = "N/A";
		}
		$client_name=$gc[2];
		$client_email=$gc[3];
		$client_phone=$gc[4];
		$firstname=$client_name;
		$lastname='';
		$booking_status=$orderdetail[6];
		$final_vc_status;
		$final_p_status;
		$payment_status=$orderdetail[5];
		$client_address=$temp['address'];
		$client_notes=$temp['notes'];
		$client_status=$temp['contact_status'];
		$client_city = $temp['city'];				$client_state = $temp['state'];				$client_zip	= $temp['zip'];
	} else {
		$c  = $objdashboard->getguestclient($orderdetail[4]);
		$temppp= unserialize(base64_decode($c[5]));
		$temp = str_replace('\\','',$temppp);
		$vc_status = $temp['vc_status'];
		if($vc_status == 'N'){
			$final_vc_status = $label_language_values['no'];
		}
		elseif($vc_status == 'Y'){
			$final_vc_status = $label_language_values['yes'];
		}else{
			$final_vc_status = "N/A";
		}
		$p_status = $temp['p_status'];
		if($p_status == 'N'){
			$final_p_status = $label_language_values['no'];
		}
		elseif($p_status == 'Y'){
			$final_p_status = $label_language_values['yes'];
		}else{
			$final_p_status = "N/A";
		}
		$client_name=$c[2];
		$client_email=$c[3];
		$phone_length = strlen($c[4]);
		if($phone_length > 6){
			$client_phone = $c[4];
		}else{
			$client_phone = "N/A";
		}
		$client_name_value="";
		$client_first_name="";
		$client_last_name="";
		$client_namess= explode(" ",$client_name);
		$cnamess = array_filter($client_namess);
		$ccnames = array_values($cnamess);
		if(sizeof((array)$ccnames)>0){
			$client_first_name =  $ccnames[0]; 
			if(isset($ccnames[1])){
				$client_last_name =  $ccnames[1]; 
			}else{
				$client_last_name =  ''; 
			}
		}else{
			$client_first_name =  ''; 
			$client_last_name =  ''; 
		}
		if($client_first_name=="" && $client_last_name==""){
			$firstname = "User";
			$lastname = "";
			$client_name = $firstname.' '.$lastname;
		}elseif($client_first_name!="" && $client_last_name!=""){
			$firstname = $client_first_name;
			$lastname = $client_last_name;
			$client_name = $firstname.' '.$lastname;
		}elseif($client_first_name!=""){
			$firstname = $client_first_name;
			$lastname = "";
			$client_name = $firstname.' '.$lastname;
		}elseif($client_last_name!=""){
			$firstname = "";
			$lastname = $client_last_name;
			$client_name = $firstname.' '.$lastname;
		}
		$client_notes = $temp['notes'];	
		if($client_notes==""){
			$client_notes = "N/A";
		}
		$client_status = $temp['contact_status'];	
		if($client_status==""){
			$client_status = "N/A";
		}	
		$payment_status=$orderdetail[5];
		$final_vc_status;
		$final_p_status;
		$client_address=$temp['address'];
		$client_city = $temp['city'];
		$client_state = $temp['state'];		
		$client_zip	= $temp['zip'];
	}
	$payment_status = strtolower($payment_status);
	if($payment_status == "pay at venue"){
		$payment_status = ucwords($label_language_values['pay_locally']);
	}else{
		$payment_status = ucwords($payment_status);
	}
		$staff_ids = $data;
	if($staff_ids != ''){
		$staff_idss = explode(',',$staff_ids);
		if(sizeof((array)$staff_idss) > 0){
			foreach($staff_idss as $sid){
				$staffdetails = $booking->get_staff_detail_for_email($sid);
				$pro_user_id = $staffdetails['pro_user_id'];
				$staff_name = $staffdetails['fullname'];
				$staff_email = $staffdetails['email'];		
				$staff_phone = $staffdetails['phone'];
				$searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{methodname}}','{{units}}','{{addons}}','{{client_email}}','{{phone}}','{{payment_method}}','{{vaccum_cleaner_status}}','{{parking_status}}','{{notes}}','{{contact_status}}','{{address}}','{{price}}','{{admin_name}}','{{firstname}}','{{lastname}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_user_id}}'); 
				$replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, $client_name,$methodname, $units, $addons,$client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status,$client_address,$price,$get_admin_name,$firstname,$lastname,'',$reason,$admin_company_name,$booking_time,$client_city,$client_state,$client_zip,$company_city,$company_state,$company_zip,$company_country,$company_phone,$company_email,$company_address,$get_admin_name,$pro_user_id);
	/* Client Email Template */
	/* $emailtemplate->email_subject=$label_language_values[strtolower(str_replace(" ","_","Appointment Rejected"))]; */
	$emailtemplate->email_subject="Appointment Rejected";
	$emailtemplate->user_type="C";
	$clientemailtemplate=$emailtemplate->readone_client_email_template_body();
	if($clientemailtemplate[2] != ''){
		$clienttemplate = base64_decode($clientemailtemplate[2]);
	}else{
		$clienttemplate = base64_decode($clientemailtemplate[3]);
	}
	$subject=$label_language_values[strtolower(str_replace(" ","_",$clientemailtemplate[1]))];
	if($setting->get_option('ct_client_email_notification_status') == 'Y' && $clientemailtemplate[4]=='E' ){
		$client_email_body = str_replace($searcharray,$replacearray,$clienttemplate);
		if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
			$mail->IsSMTP();
		}else{
			$mail->IsMail();
		}
		$mail->SMTPDebug  = 0;
		$mail->IsHTML(true);
		$mail->From = $company_email;
		$mail->FromName = $company_name;
		$mail->Sender = $company_email;
		$mail->AddAddress($client_email, $client_name);
		$mail->Subject = $subject;
		$mail->Body = $client_email_body;
		$mail->send();
		$mail->ClearAllRecipients();
  }
  /* Admin Email template */
	$emailtemplate->email_subject="Appointment Rejected";
	$emailtemplate->user_type="A";
	$adminemailtemplate=$emailtemplate->readone_client_email_template_body();
	
	if($adminemailtemplate[2] != ''){
		$admintemplate = base64_decode($adminemailtemplate[2]);
	}else{
		$admintemplate = base64_decode($adminemailtemplate[3]);
	}
	$adminsubject=$label_language_values[strtolower(str_replace(" ","_",$adminemailtemplate[1]))];
	if($setting->get_option('ct_admin_email_notification_status')=='Y' && $adminemailtemplate[4]=='E'){
		$admin_email_body = str_replace($searcharray,$replacearray,$admintemplate);
		if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
			$mail_a->IsSMTP();
		}else{
			$mail_a->IsMail();
		}
		$mail_a->SMTPDebug  = 0;
		$mail_a->IsHTML(true);
		$mail_a->From = $company_email;
		$mail_a->FromName = $company_name;
		$mail_a->Sender = $company_email;
		$mail_a->AddAddress($admin_email, $get_admin_name);
		$mail_a->Subject = $adminsubject;
		$mail_a->Body = $admin_email_body;
		$mail_a->send();
		$mail_a->ClearAllRecipients();
	}

				$staff_searcharray = array('{{service_name}}','{{booking_date}}','{{business_logo}}','{{business_logo_alt}}','{{client_name}}','{{methodname}}','{{units}}','{{addons}}','{{client_email}}','{{phone}}','{{payment_method}}','{{vaccum_cleaner_status}}','{{parking_status}}','{{notes}}','{{contact_status}}','{{address}}','{{price}}','{{admin_name}}','{{firstname}}','{{lastname}}','{{app_remain_time}}','{{reject_status}}','{{company_name}}','{{booking_time}}','{{client_city}}','{{client_state}}','{{client_zip}}','{{company_city}}','{{company_state}}','{{company_zip}}','{{company_country}}','{{company_phone}}','{{company_email}}','{{company_address}}','{{admin_name}}','{{staff_name}}','{{staff_email}}','{{client_user_id}}');
				$staff_replacearray = array($service_name, $booking_date , $business_logo, $business_logo_alt, $client_name,$methodname, $units, $addons,$client_email, $client_phone, $payment_status, $final_vc_status, $final_p_status, $client_notes, $client_status,$client_address,$price,$get_admin_name,$firstname,$lastname,'','',$admin_company_name,$booking_time,$client_city,$client_state,$client_zip,$company_city,$company_state,$company_zip,$company_country,$company_phone,$company_email,$company_address,$get_admin_name,$staff_name,$staff_email,$grinders_id);
				$emailtemplate->email_subject="Appointment Rejected";
				$emailtemplate->user_type="S";
				$staffemailtemplate=$emailtemplate->readone_client_email_template_body();
				if($staffemailtemplate[2] != ''){
					$stafftemplate = base64_decode($staffemailtemplate[2]);
				}else{
					$stafftemplate = base64_decode($staffemailtemplate[3]);
				}
				$subject=$label_language_values[strtolower(str_replace(" ","_",$staffemailtemplate[1]))];
				if($setting->get_option('ct_staff_email_notification_status') == 'Y' && $staffemailtemplate[4]=='E' ){
					$client_email_body = str_replace($staff_searcharray,$staff_replacearray,$stafftemplate);
					if($setting->get_option('ct_smtp_hostname') != '' && $setting->get_option('ct_email_sender_name') != '' && $setting->get_option('ct_email_sender_address') != '' && $setting->get_option('ct_smtp_username') != '' && $setting->get_option('ct_smtp_password') != '' && $setting->get_option('ct_smtp_port') != ''){
						$mail_s->IsSMTP();
					}else{
						$mail_s->IsMail();
					}
					$mail_s->SMTPDebug  = 0;
					$mail_s->IsHTML(true);
					$mail_s->From = $company_email;
					$mail_s->FromName = $company_name;
					$mail_s->Sender = $company_email;
					$mail_s->AddAddress($staff_email, $staff_name);
					$mail_s->Subject = $subject;
					$mail_s->Body = $client_email_body;
					$mail_s->send();
					$mail_s->ClearAllRecipients();
				}
			}
		}
	}
	/*** Email Code End ***/
	/*SMS SENDING CODE*/
	/*GET APPROVED SMS TEMPLATE*/

	

}
?>