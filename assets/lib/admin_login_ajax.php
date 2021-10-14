<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();

include (dirname(dirname(dirname(__FILE__))) . '/header.php');
include (dirname(dirname(dirname(__FILE__))) . "/objects/class_connection.php");
include (dirname(dirname(dirname(__FILE__))) . "/objects/class_login_check.php");
include (dirname(dirname(dirname(__FILE__))) . "/objects/class_adminprofile.php");
include (dirname(dirname(dirname(__FILE__))) . "/objects/class_dayweek_avail.php");
include (dirname(dirname(dirname(__FILE__))) . '/objects/class.phpmailer.php');
include (dirname(dirname(dirname(__FILE__))) . '/objects/class_setting.php');
include (dirname(dirname(dirname(__FILE__))) . '/objects/class_users.php');
include (dirname(dirname(dirname(__FILE__))) . '/objects/class_front_first_step.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$con = new cleanto_db();
$conn = $con->connect();
$settings = new cleanto_setting();
$settings->conn = $conn;
$users = new cleanto_users();
$users->conn = $conn;
$first_step = new cleanto_first_step();
$first_step->conn = $conn;
$objdayweek_avail = new cleanto_dayweek_avail();
$objdayweek_avail->conn = $conn;
if ($settings->get_option('ct_smtp_authetication') == 'true')
{
    $mail_SMTPAuth = '1';
    if ($settings->get_option('ct_smtp_hostname') == "smtp.gmail.com")
    {
        $mail_SMTPAuth = 'Yes';
    }
}
else
{
    $mail_SMTPAuth = '0';
    if ($settings->get_option('ct_smtp_hostname') == "smtp.gmail.com")
    {
        $mail_SMTPAuth = 'No';
    }
}
$mail = new cleanto_phpmailer();
$mail->Host = $settings->get_option('ct_smtp_hostname');
$mail->Username = $settings->get_option('ct_smtp_username');
$mail->Password = $settings->get_option('ct_smtp_password');
$mail->Port = $settings->get_option('ct_smtp_port');
$mail->SMTPSecure = $settings->get_option('ct_smtp_encryption');
$mail->SMTPAuth = $mail_SMTPAuth;
$mail->CharSet = "UTF-8";
$objlogin = new cleanto_login_check();
$objlogin->conn = $conn;
$objadmininfo = new cleanto_adminprofile();
$objadmininfo->conn = $conn;
$company_email = $settings->get_option('ct_company_email');
$company_name = $settings->get_option('ct_company_name');
if (isset($_POST['checkadmin']))
{
    $name = trim(strip_tags(mysqli_real_escape_string($conn, $_POST['name'])));
    $password = md5($_POST['password']);
    $objlogin->remember = $_POST['remember'];
    $objlogin->cookie_passwords = $_POST['password'];
    $t = $objlogin->checkadmin($name, $password);
	
}
elseif (isset($_POST['logout']))
{
    session_destroy();
	echo "user";
}
elseif (isset($_GET['resetpassword']))
{
    $newpass = $_GET['password'];
    $id = $_GET['userid'];
    $objlogin->resetpassword($id, $newpass);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'forget_password')
{
    $objadmininfo->email = trim(strip_tags(mysqli_real_escape_string($conn, $_POST['email'])));
    $res = $objadmininfo->forget_password();
    $userid = $res[0];
    if (count((array)$res) >= 1)
    {
        $current_time = date('Y-m-d H:i:s');
        $ency_code = base64_encode(base64_encode($userid + 135) . '#' . strtotime("+120 minutes", strtotime($current_time)));
        $to = $_POST['email'];
        $subject = "Forget Password";
        $from = $settings->get_option('ct_company_email');
        $body = '<html>
        		<head>
      				<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      				<title>Welcome to ' . $settings->get_option('ct_company_name') . '</title>
        		</head>
        		<body>
        			<div style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;box-sizing: border-box;">
        				<div style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;">
        					<table style="border: 1px solid #c2c2c2;width: 100%;float: left;margin: 30px 0px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">
        						<tbody>
        							<tr>
        								<td>
        									<div style="padding: 25px 30px;background: #fff;float: left;width: 90%;display: block;">
        										<div style="border-bottom: 1px solid #e6e6e6;float: left;width: 100%;display: block;">
        											<h3 style="color: #606060;font-size: 20px;margin: 15px 0px 0px;font-weight: 400;">Hi,</h3><br />
        											<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">Forgot your password - <a href="' . SITE_URL . 'admin/forgot-password_admin.php?code=' . $ency_code . '" >Reset it here</a></p>
      											</div>
      											<div style="padding: 15px 0px;float: left;width: 100%;">
      												<h5 style="color: #606060;font-size: 13px;margin: 10px 0px px;">Regards,</h5>
      												<h6 style="color: #606060;font-size: 14px;font-weight: 600;margin: 10px 0px 15px;">' . $settings->get_option('ct_company_name') . '</h6>
      											</div>
        									</div>
      									</td>
      								</tr>
      							</tbody>
      						</table>
      					</div>
      				</div>
      			</body>
      		</html>';
        if ($settings->get_option('ct_smtp_hostname') != '' && $settings->get_option('ct_email_sender_name') != '' && $settings->get_option('ct_email_sender_address') != '' && $settings->get_option('ct_smtp_username') != '' && $settings->get_option('ct_smtp_password') != '' && $settings->get_option('ct_smtp_port') != '')
        {
            $mail->IsSMTP();
        }
        else
        {
            $mail->IsMail();
        }
        $mail->SMTPDebug = 0;
        $mail->IsHTML(true);
        $mail->From = $company_email;
        $mail->FromName = $company_name;
        $mail->Sender = $company_email;
        $mail->AddAddress($to, "Admin");
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
        $mail->ClearAllRecipients();
    }
    else
    {
        echo "not";
    }
}
elseif (isset($_POST['action']) && $_POST['action'] == 'reset_new_password')
{
    $objadmininfo->id = $_SESSION['user_id'];
    $objadmininfo->password = $_POST['retype_new_reset_pass'];
    $reset_new_pass = $objadmininfo->update_password();
    if ($reset_new_pass)
    {
        echo '1';
    }
    unset($_SESSION['fp_admin']);
    unset($_SESSION['fp_user']);
}
elseif (isset($_POST['action']) && $_POST['action'] == 'staff_reg')
{
    $objadmininfo->email = $_POST['email'];
    $objadmininfo->fullname = ucwords($_POST['fullname']);
    $objadmininfo->pass = $_POST['pass'];
    $objadmininfo->service = $_POST['service_ids'];
    $staff_register = $objadmininfo->reg_staff();
    if ($staff_register)
    {
        $values = "weekly";
        $staff_id = $staff_register;
        $objdayweek_avail->set_schedule_type($values, $staff_id);
        echo "Staff Register Successfully";
    }
}
elseif (isset($_POST['action']) && $_POST['action'] == 'pre_staff_reg_himself')
{ 
	// ini_set('display_errors', 1);	
	// ini_set('display_startup_errors', 1);	
	// error_reporting(E_ALL);	
	// chmod(dirname(dirname(dirname(__FILE__)))."/assets/images/services", 0777);
	$allData = $objadmininfo->readall_staff();
  while($value = mysqli_fetch_array($allData)){
  
    if(strcasecmp($value['pro_user_id'], $_POST['pro_user_id']) == 0){
      echo 0;
      die();
    }
  }

  $allUserData = $users->readAll();
  while($value = mysqli_fetch_array($allUserData)){
    if(strcasecmp($value['grinders_id'], $_POST['pro_user_id']) == 0){
      echo 0;
      die();
    }elseif(strcasecmp($value['user_email'], $_POST['email']) == 0){
      echo 2;
      die();
    }
  }

	$objadmininfo->email = isset($_POST['email']) ? $_POST['email'] : '';
	$objadmininfo->first_name = isset($_POST['first_name'])?ucwords($_POST['first_name']):''; 
    $objadmininfo->last_name = isset($_POST['last_name'])?ucwords($_POST['last_name']):'';   	
	$objadmininfo->pass = md5($_POST['pass']);  	
	$objadmininfo->zip_code = isset($_POST['zip_code'])?$_POST['zip_code']:'';  	
	$objadmininfo->phone = isset($_POST['phone'])?$_POST['phone']:'';  	
	//$objadmininfo->address = isset($_POST['address'])? $_POST['address'] : '';  	
	$objadmininfo->city = isset($_POST['city'])?$_POST['city']:'';  	
	$objadmininfo->state = isset($_POST['state'] ) ? $_POST['state'] : '';  	
  $objadmininfo->country = isset($_POST['country'])? $_POST['country'] : '';    
	$objadmininfo->zoom_link = isset($_POST['zoom_link'])? $_POST['zoom_link'] : '';  	
	$objadmininfo->offered = isset($_POST['offered'])? $_POST['offered'] : '';  
	$objadmininfo->price_for_single = isset($_POST['price_for_single'])? $_POST['price_for_single'] : '';  
	$objadmininfo->price_for_3 = isset($_POST['price_for_3'])? $_POST['price_for_3'] : '';  
	$objadmininfo->price_for_5 = isset($_POST['price_for_5'])? $_POST['price_for_5'] : '';   
  $objadmininfo->staff_bio = isset($_POST['staff_bio'])? $_POST['staff_bio'] : '';  
	$objadmininfo->pro_user_id = isset($_POST['pro_user_id'])? $_POST['pro_user_id'] : '';  
	$objadmininfo->custom_rate = isset($_POST['custom_rate'])? $_POST['custom_rate'] : '';
	$objadmininfo->single_customer_rate = isset($_POST['single_custom_rate'])? $_POST['single_custom_rate'] : '';
	/*if($_POST['trainer_type']=='general'){
		$objadmininfo->service_ids = 9;
		
	}else if($_POST['trainer_type']=='yoga'){
		$objadmininfo->service_ids = 10;
	}else{
		$objadmininfo->service_ids = '';
	}*/
  if($_POST['trainer_type']!=''){
    $new_service = implode(",",$_POST['trainer_type']);
  }else{
    $new_service = $_POST['trainer_type'];
  }
  $objadmininfo->service_ids = $new_service;

	$filename = basename( $_POST['file']);
	$objadmininfo->image = $filename; 

	if (isset($_POST['email'])){	  
		$objadmininfo->email =trim(strip_tags(mysqli_real_escape_string($conn,$_POST['email'])));	  
		$check_staff_email_existing = $objadmininfo->check_staff_email_existing();	  
		if ($check_staff_email_existing > 0){	    
			$checkemail = 0;	  
		}else{	    
			$checkemail = 1;	  
		}	
	}	
	if($checkemail){	  	
		$otp = rand(1000,99999);	  	
		$objadmininfo->otp = $otp;		
		$staff_register=$objadmininfo->pre_reg_staff();	
		
		if ($staff_register) {
		$_SESSION['staff_tem_id'] = $staff_register;
		$_SESSION['staff_tem_email'] = $_POST['email'];						
			$values = "weekly";			
			$staff_id = $staff_register;			
			$objdayweek_avail->set_schedule_type($values,$staff_id);					
			$to = $_POST['email'];			
			$subject = "Email Verification";			
			$from = $settings->get_option('ct_company_email');			
			$body = '<html>				
				<head>					
					<meta name="viewport" content="width=device-width, initial-scale=1.0"/>				
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					<title>Welcome to ' . $settings->get_option('ct_company_name'). '</title>		
				</head>				
				<body>					
					<div style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;box-sizing: border-box;">	
						<div style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;">							
							<table style="border: 1px solid #c2c2c2;width: 100%;float: left;margin: 30px 0px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">								
								<tbody>									
									<tr>										
										<td>											
											<div style="padding: 25px 30px;background: #fff;float: left;width: 90%;display: block;">						
												<div style="border-bottom: 1px solid #e6e6e6;float: left;width: 100%;display: block;">					
													<h3 style="color: #606060;font-size: 20px;margin: 15px 0px 0px;font-weight: 400;">Hi,</h3><br />		
													<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">Your Email OTP is  - '. $otp . '</p>	
												</div>												
												<div style="padding: 15px 0px;float: left;width: 100%;">
													<h5 style="color: #606060;font-size: 13px;margin: 10px 0px px;">Regards,</h5>							
													<h6 style="color: #606060;font-size: 14px;font-weight: 600;margin: 10px 0px 15px;">' . $settings->get_option('ct_company_name') . '</h6>			
												</div>											
											</div>										
										</td>									
									</tr>								
								</tbody>							
							</table>						
						</div>					
					</div>				
				</body>			
			</html>';			
			if($settings->get_option('ct_smtp_hostname') != '' && 
				$settings->get_option('ct_email_sender_name') != '' && $settings->get_option('ct_email_sender_address') != '' && $settings->get_option('ct_smtp_username') != '' && 
				$settings->get_option('ct_smtp_password') != '' && 
				$settings->get_option('ct_smtp_port') != ''){		

				$mail->IsSMTP();		
			}else{			
				$mail->IsMail();		
			}		
			$mail->SMTPDebug  = 0;		
			$mail->IsHTML(true);		
			$mail->From = $company_email;		
			$mail->FromName = $company_name;		
			$mail->Sender = $company_email;		
			$mail->AddAddress($to,"Staff");		
			$mail->Subject = $subject;		
			$mail->Body = $body;		
			$mail->send();
			$mail->ClearAllRecipients();		
			echo 1;
		} else {			
			echo "not";
		} 	
	}else{		
		echo "email id already exists.";
	}
		
}elseif (isset($_POST['action']) && $_POST['action'] == 'pre_client_reg_himself') {

  $allUserData = $users->readAll();
  while($value = mysqli_fetch_array($allUserData)){
    if(strcasecmp($value['grinders_id'], $_POST['grinder_user_id']) == 0){
      echo 1;
      die();
    }elseif(strcasecmp($value['user_email'], $_POST['email']) == 0){
      echo 2;
      die();
    }
  }

  $allAdminData = $objadmininfo->readall_staff();
  while($value = mysqli_fetch_array($allAdminData)){
    if(strcasecmp($value['pro_user_id'], $_POST['grinder_user_id']) == 0){
      echo 1;
      die();
    }elseif (strcasecmp($value['email'], $_POST['email']) == 0) {
      echo 2;
      die();
    }
  }

	$users->user_email = $_POST['email'];  
	$users->first_name = $_POST['first_name'];
	$users->last_name = $_POST['last_name'];
	$users->user_pwd = md5($_POST['pass']);  
	$users->zip = $_POST['zip_code'];  
	$users->usertype = serialize(array("client"));  
	$users->phone = $_POST['phone'];  
	$users->address = $_POST['address'];  
	$users->city = $_POST['city'];  
	$users->state = $_POST['state'];  
  $users->country = $_POST['country'];  
  $users->grinders_id = $_POST['grinder_user_id'];  
  $users->user_bio = $_POST['fitness_goal'];
	$users->status = 'E';

	@$filename = basename( $_POST['file']);
	$users->image = $filename;

	$staff_register=$users->pre_reg_user();	
	   
	if ($staff_register) {			
		$to = $_POST['email'];		
		$subject = "Registration Confirmation";		
		$from = $settings->get_option('ct_company_email');		
		$body = '<html>			
				<head>				
					<meta name="viewport" content="width=device-width, initial-scale=1.0"/>				
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />				
					<title>Welcome to HOMEBODS!</title>			
				</head>			
				<body>				
					<div style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;box-sizing: border-box;">		
						<div style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;">						
							<table style="border: 1px solid #c2c2c2;width: 100%;float: left;margin: 30px 0px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">							
								<tbody>								
									<tr>									
										<td>										
											<div style="padding: 25px 30px;background: #fff;float: left;width: 90%;display: block;">
												<div style="border-bottom: 1px solid #e6e6e6;float: left;width: 100%;display: block;">
													<h3 style="color: #606060;font-size: 20px;margin: 15px 0px 0px;font-weight: 400;">Hi '.$_POST['first_name'].' '.$_POST['last_name'].',</h3><br />
													<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">Welcome to HOMEBODS!</p>
													<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">
													You are now registered as a Grinder! Your username is '.$_POST['grinder_user_id'].' You can now login and edit your profile at <a href="https://homebods.co/booking/admin/my-appointments.php">https://homebods.co/booking/admin/my-appointments.php</a>  by entering your username and password. Do not hesitate to contact us and let’s get to WORK!
													</p>
												</div>											
												<div style="padding: 15px 0px;float: left;width: 100%;">
													<h5 style="color: #606060;font-size: 13px;margin: 10px 0px px;">Regards,</h5>
													<h6 style="color: #606060;font-size: 14px;font-weight: 600;margin: 10px 0px 15px;">' . $settings->get_option('ct_company_name') . '</h6>
												</div>										
											</div>									
										</td>								
									</tr>							
								</tbody>						
							</table>					
						</div>				
					</div>			
				</body>		
			</html>';
		
		if($settings->get_option('ct_smtp_hostname') != '' && 
			$settings->get_option('ct_email_sender_name') != '' && $settings->get_option('ct_email_sender_address') != '' && $settings->get_option('ct_smtp_username') != '' && 
			$settings->get_option('ct_smtp_password') != '' && 
			$settings->get_option('ct_smtp_port') != ''){		

			$mail->IsSMTP();		
		}else{			
			$mail->IsMail();		
		}		
		$mail->SMTPDebug  = 0;		
		$mail->IsHTML(true);		
		$mail->From = $company_email;		
		$mail->FromName = $company_name;		
		$mail->Sender = $company_email;		
		$mail->AddAddress($to,"Grinders");		
		$mail->Subject = $subject;		
		$mail->Body = $body;		
		$mail->send();		
		$mail->ClearAllRecipients();	
	} else {		
		echo "not";	
	} 		
	echo "Fitness Pros Register Successfully";

}elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'pre_staff_otp_check'){	
	/* ini_set('display_errors', 1);	
	ini_set('display_startup_errors', 1);	
	error_reporting(E_ALL);	
	echo 1;	 */

	$objadmininfo->email = $_REQUEST['email'];	
	$objadmininfo->otp = $_REQUEST['otp'];	
	$check_staff_email_existing = $objadmininfo->verify_staff_otp_for_email();	
	
	if ($check_staff_email_existing){	 
   $objadmininfo->update_staff_validate();
       /* $_SESSION['ct_staffid'] = $_SESSION['staff_tem_id'];
		$_SESSION['ct_useremail'] = $_SESSION['staff_tem_email'];	 */
		$objadmininfo->otp ='';	     
		$data = $objadmininfo->staff_update_otp_for_email();
		$to = $_REQUEST['email'];
		$reg_subject = "Registration Confirmation";
		$reg_body = '<html>			
				<head>				
					<meta name="viewport" content="width=device-width, initial-scale=1.0"/>				
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />				
					<title>Welcome to HOMEBODS!</title>			
				</head>			
				<body>				
					<div style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;box-sizing: border-box;">		
						<div style="display: block !important;max-width: 600px !important;margin: 0 auto !important;clear: both !important;">						
							<table style="border: 1px solid #c2c2c2;width: 100%;float: left;margin: 30px 0px;-webkit-border-radius: 5px;-moz-border-radius: 5px;-o-border-radius: 5px;border-radius: 5px;">							
								<tbody>								
									<tr>									
										<td>										
											<div style="padding: 25px 30px;background: #fff;float: left;width: 90%;display: block;">
												<div style="border-bottom: 1px solid #e6e6e6;float: left;width: 100%;display: block;">
													
													<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">Welcome to HOMEBODS!</p>
													<p style="color: #606060;font-size: 15px;margin: 10px 0px 15px;">
													You are now registered as a Fitness Pro! Your username is '.$_REQUEST['user_id'].'. You can now login and edit your profile at <a href="https://homebods.co/booking/staff/staff-dashboard.php">https://homebods.co/booking/staff/staff-dashboard.php</a> by entering your username and password. Do not hesitate to contact us and let’s get to WORK!
													</p>
												</div>											
												<div style="padding: 15px 0px;float: left;width: 100%;">
													<h5 style="color: #606060;font-size: 13px;margin: 10px 0px px;">Regards,</h5>
													<h6 style="color: #606060;font-size: 14px;font-weight: 600;margin: 10px 0px 15px;">' . $settings->get_option('ct_company_name') . '</h6>
												</div>										
											</div>									
										</td>								
									</tr>							
								</tbody>						
							</table>					
						</div>				
					</div>			
				</body>		
			</html>';

			if($settings->get_option('ct_smtp_hostname') != '' && 
				$settings->get_option('ct_email_sender_name') != '' && $settings->get_option('ct_email_sender_address') != '' && $settings->get_option('ct_smtp_username') != '' && 
				$settings->get_option('ct_smtp_password') != '' && 
				$settings->get_option('ct_smtp_port') != ''){		

				$mail->IsSMTP();		
			}else{			
				$mail->IsMail();		
			}		
			$mail->SMTPDebug  = 0;		
			$mail->IsHTML(true);		
			$mail->From = $company_email;		
			$mail->FromName = $company_name;		
			$mail->Sender = $company_email;		
			$mail->AddAddress($to,"Fitness Pros");		
			$mail->Subject = $reg_subject;		
			$mail->Body = $reg_body;		
			$mail->send();		
			$mail->ClearAllRecipients();
		echo  1;	
	}else{	   	
		echo  2;	
	}
}	
// if (isset($_POST['email'])){
	//   $objadmininfo->email =trim(strip_tags(mysqli_real_escape_string($conn,$_POST['email'])));
	//   $check_staff_email_existing = $objadmininfo->check_staff_email_existing();
	//   if ($check_staff_email_existing > 0){
		//     echo "false";
	//   }else{
		//     echo "true";
	//   }
// }
?>
