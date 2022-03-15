<html>
   <head>
      <?php 
			
			include (dirname(dirname(dirname(__FILE__))) . '/header.php');
include(dirname(__FILE__) . "/objects/class_connection.php");
include(dirname(__FILE__) . "/objects/class_login_check.php");
include(dirname(__FILE__) . "/objects/class_adminprofile.php");
include(dirname(__FILE__) . "/objects/class_dayweek_avail.php");
include(dirname(__FILE__) . "/objects/class.phpmailer.php");
include(dirname(__FILE__) . "/objects/class_setting.php");
include(dirname(__FILE__) . "/objects/class_users.php");
include(dirname(__FILE__) . "/objects/class_front_first_step.php");


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
         $filename =  './config.php';
         $file = file_exists($filename);
         if($file){
           if(!filesize($filename) > 0){
             header('location:ct_install.php');
           }
           else{
             include(dirname(__FILE__) . "/objects/class_connection.php");
             $cvars = new cleanto_myvariable();
             $host = trim($cvars->hostnames);
             $un = trim($cvars->username);
             $ps = trim($cvars->passwords); 
             $db = trim($cvars->database);
         
             $con = new cleanto_db();
             $conn = $con->connect();
             
             if(($conn->connect_errno=='0' && ($host=='' || $db=='')) || $conn->connect_errno!='0' ) {
               header('Location: ./config_index.php');
             }
           }
         }else{
           echo "Config file does not exist";
         }
         
         
         include(dirname(__FILE__) . '/class_configure.php');
         include(dirname(__FILE__) . "/header.php");
         include(dirname(__FILE__) . '/objects/class_setting.php');
         
         $con = @new cleanto_db();
         $conn = $con->connect();
         
         $settings = new cleanto_setting();
         $settings->conn = $conn;
				 
				 
				 if($_POST){


$data = [
'secret' => '6LdINhAaAAAAAG9ZzgQOytEfRfhMdFE_K9waToUL',
'response' => @$_POST['g-recaptcha-response']
];

$curl = curl_init();

curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($curl);
$response = json_decode($response, true);
/* print_r($response); */
if ($response['success'] === false) {

// Failure

} else {
  $objadmininfo->email = isset($_POST['staff_email']) ? $_POST['staff_email'] : '';  	
	$objadmininfo->fullname = isset($_POST['staff_name'])?ucwords($_POST['staff_name']):'';  	
	$objadmininfo->pass = isset($_POST['staff_password'])?$_POST['staff_password']:'';  	
	$objadmininfo->zip_code = isset($_POST['staff_zip'])?$_POST['staff_zip']:'';  	
	$objadmininfo->phone = isset($_POST['staff_phone'])?$_POST['staff_phone']:'';  	
	$objadmininfo->address = isset($_POST['staff_address'])? $_POST['staff_address'] : '';  	
	$objadmininfo->city = isset($_POST['staff_city'])?$_POST['staff_city']:'';  	
	$objadmininfo->state = isset($_POST['staff_state'] ) ? $_POST['staff_state'] : '';  	
	$objadmininfo->country = isset($_POST['staff_country'])? $_POST['staff_country'] : '';  	
	$objadmininfo->offered = isset($_POST['offered'])? $_POST['offered'] : '';  
	$objadmininfo->trainer_type = isset($_POST['trainer_type'])? $_POST['trainer_type'] : '';  

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
				$settings->get_option('ct_email_sender_name') != '' && 
				$settings->get_option('ct_email_sender_address') != '' && 
				$settings->get_option('ct_smtp_username') != '' && 
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
			echo 1;exit();		
		} else {			
			echo "not";exit();		
		} 	
	}else{		
		echo "email id already exists.";exit();	
	}		
// Success
}
}


         
         ?>
      	<title><?php  echo "Register"; ?></title>
      	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all">
      	<link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
      	<link rel="stylesheet" href="assets/css/client-registration.css" type="text/css" media="all">

      	<script src="assets/js/jquery-2.1.4.min.js"></script>
  		<script src="assets/js/bootstrap.min.js" type="text/javascript" ></script>
  		
  		<script src="assets/js/jquery.Jcrop.min.js" type="text/javascript" ></script>
      	<script src="assets/js/client-registration.js"></script>

     <script src="https://www.google.com/recaptcha/api.js"></script>
      <!------ Include the above in your HEAD tag ---------->
   </head>
   <body>
    <div class="cont s--signup" style="height: 630px;">
        <div class="form sign-in">
            <h2><a href="www.homebods.club"><img src="assets/images/services/company_73345.png" style="width: 100px;"></a></h2>
            <h2>LET’S GRIND!</h2>
            <label>
            	<span>Name</span>
            	<input type="text" name="client_name" placeholder="" id="client_name" class="client_name"/>
            </label>
            <label>
            	<span>Email</span>
            	<input type="email" name="client_email" placeholder="" id="client_email" class="client_email"/>
            </label>
            <label>
            	<span>Password</span>
            	<input type="password" name="client_password" placeholder="" id="client_password" class="client_password"/>
            </label> 
            <label>
            	<span>Phone</span>
            	<input type="text"  placeholder="" name="client_phone" id="client_phone" class="client_phone"/>
            </label>
            <label>
            	<span>Address</span>
            	<input type="text" placeholder="" name="client_address" id="client_address" class="client_address"/>
            </label>
            <label>
           		<span>City</span>
            	<input type="text" placeholder="" required name="client_city" id="client_city" class="client_city"/>
            </label>
            <label>
            	<span>State</span>
            	<input type="text" placeholder="" name="client_state" id="client_state" class="client_state"/>
            </label>
            <label>
            	<span>Zip</span>
            	<input type="text" placeholder="" name="client_zip" id="client_zip" class="client_zip"/>
            </label> 
            <label>
            	<span>Country</span>
            	<input type="text" placeholder="" name="client_country" id="client_country" class="client_email"/>
            </label> 
            <div class="before-submit">
               <button type="button" href="javascript:void(0);" class="client_register_front">Homebod Registration</button>
            </div>
        </div>
        <div class="sub-cont">
            <div class="img">
               <div class="img__text m--up">
                  <h2>New here?</h2>
                  <p>If you want to sing up as Vendor</p>
               </div>
               <div class="img__text m--in">
                  <h2>One of us?</h2>
                  <p>If you want to sing up as Client</p>
               </div>
               <div class="img__btn">
                  <span class="m--up">Sign Up As Vendor</span>
                  <span class="m--in">Sign Up As Client</span>
               </div>
            </div> 
            <div class="form sign-up">
                <h2><a href="www.homebods.club"><img src="assets/images/services/company_73345.png" style="width: 100px;"></a></h2> 
               	<h2>FITNESS PRO REGISTRATION</h2> 
             <form  id="proregister" action="" method="post" name="proregister" >
                <label>
               		<span>Name</span>
               		<input type="text"  name="staff_name" placeholder="" id="staff_name" class="staff_name"/>
                </label>
               	<label>
               		<span>Email</span>
               		<input type="email" name="staff_email" placeholder="" id="staff_email" class="staff_email"/>
               	</label>
               	<label>
               		<span>Password</span>
               		<input type="password" name="staff_password" placeholder="" id="staff_password" class="staff_password"/>
               	</label> 
								<label>
               		<span>Trainer For</span>
               		<select name="trainer_type" id="trainer_type" class="staff_image select-imag-set">
										<option value="">---Choose Trainer Type---</option>
										<option value="general">Physical Training/General Fitness</option>
										<option value="yoga">Yoga</option>
									</select>
               	</label> 
               	<label>
               		<span>Phone</span>
               		<input type="text" name="staff_phone" id="staff_phone" placeholder="" class="staff_phone"/>
               	</label>
               	<label>
               		<span>Address</span>
               		<input type="text" name="staff_address" placeholder="" id="staff_address" class="staff_address"/>
               	</label>
               	<label>
               		<span>City</span>
               		<input type="text" name="staff_city" placeholder="" id="staff_city" class="staff_city"/>
               	</label>
               	<label>
               		<span>State</span>
               		<input type="text" name="staff_state" placeholder="" id="staff_state" class="staff_state"/>
               	</label> 
               	<label>
               		<span>Zip</span>
               		<input type="text" placeholder="" name="staff_zip" id="staff_zip" class="staff_zip"/>
               	</label> 
               	<label>
               		<span>Country</span>
               		<input type="text" placeholder="" name="staff_country" id="staff_country" class="staff_email"/>
               	</label> 
							 
               	<label>
               		<span>Online Option Offered?</span>
               		<select name="offered" id="offered" class="staff_image select-imag-set">
               			<option value="Y">Yes</option>
               			<option value="N">No</option>
               		</select>
               	</label> 
               	<label class="w-100 image-upload-main">
               		<span>Photo Upload</span>
               		<input data-us="pcas" class="ct-upload-images" type="file" name="" id="ct-upload-imagepcas" /> 
               		<div class="ct-clean-service-image-uploader service-image-upload-set">
				        <img id="pcasserviceimage" src="<?php echo SITE_URL; ?>assets/images/default_service.png" class="ct-clean-service-image br-100" height="100" width="100">                                                               <label for="ct-upload-imagepcas" class="ct-clean-service-img-icon-label">                             
				        	<i class="ct-camera-icon-common br-100 fa fa-camera"></i>
				        	<i class="pull-left fa fa-plus-circle fa-2x"></i>
				        </label>    
				        <input data-us="pcas" class="hide ct-upload-images" type="file" name="" id="ct-upload-imagepcas" />
				        <a id="ct-remove-service-imagepcas" id="ct_service_image" class="pull-left br-100 btn-danger bt-remove-service-img btn-xs hide" rel="popover" data-placement='left' title="<?php echo $label_language_values['remove_image']; ?>"> <i class="fa fa-trash" title="<?php echo $label_language_values['remove_service_image']; ?>"></i></a>
				        <label><b class="error-service" style="color:red;"></b></label>
				        <div id="popover-ct-remove-service-imagepcas" style="display: none;">
				            <div class="arrow"></div>
				            <table class="form-horizontal" cellspacing="0">
				               <tbody>
				                  <tr>
				                     <td>                                                                                        <a href="javascript:void(0)" id="" value="Delete" class="btn btn-danger btn-sm" type="submit"><?php echo $label_language_values['yes']; ?></a>                                                                                        <a href="javascript:void(0)" id="ct-close-popover-service-imagepcas" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo $label_language_values['cancel']; ?></a>                                                                                    </td>
				                  </tr>
				               </tbody>
				            </table>
				        </div>
				        <!-- end pop up -->                                                                    
				    </div>
               	</label> 
				
								<label style="width:100% !important; text-align:left !important">
								
               			<input type="checkbox" style="width: 10px !important; float:left;" class="term_condition" id="term_condition" name="term_condition" value="Y"><span  style="margin: 10px !important;">By Registering with HOMEBODS, Ltd., you are agreeing to the Terms and Conditions of the Company.<span>
               	</label> 
			<label> 
<div class="g-recaptcha" data-sitekey="6LdINhAaAAAAANWvHPOSFIOMSFC9svZZXvDfnDGy"></div>
</label>
								<span class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</span>
               	<div class="before-submit">
                  	<button type="submit"  class="staff_register_front">Pro Registration</button>
               	</div>
               	<div id="register-meesg" class="pt-3" style="display: none;text-align: center;padding-top: 10px;"></div>
            </form>
            </div>
        </div>
    </div>
    
    <div id="ct-image-upload-popuppcas" class="ct-image-upload-popup modal fade" tabindex="-1" role="dialog">
	    <div class="vertical-alignment-helper">
	        <div class="modal-dialog modal-md vertical-align-center">
	            <div class="modal-content">
	                <div class="modal-header">
	                	<div class="col-md-12 col-xs-12">
	                		<a data-us="pcas" class="btn btn-blue ct_upload_img1" data-imageinputid="ct-upload-imagepcas">crop and save</a>
	                		<button type="button" class="btn btn-white btn-default hidemodal" data-dismiss="modal" aria-hidden="true"> cancel</button>
	                	</div>
	                </div>
	                <div class="modal-body">
	                	<img id="ct-preview-imgpcas" class="ct-preview-img" style="width: 100%;" />
	                </div>
	                <div class="modal-footer">
	                 	<div class="col-md-12 np">
	                    	<div class="col-md-12 np">
	                       		<div class="col-md-4 col-xs-12"> 
	                       			<label class="pull-left">File size</label> 
	                       			<input type="text" class="form-control" id="pcasfilesize" name="filesize" />               
	                       		</div>
	                       		<div class="col-md-4 col-xs-12">
	                       			<label class="pull-left">H</label> 
	                       			<input type="text" class="form-control" id="pcash" name="h" />
	                       		</div>
	                       		<div class="col-md-4 col-xs-12">
	                       			<label class="pull-left">W</label> 
	                       			<input type="text" class="form-control" id="pcasw" name="w" />
	                       		</div>
	                       		<!-- hidden crop params -->
	                       		<input type="hidden" id="pcasx1" name="x1" /> 
	                       		<input type="hidden" id="pcasy1" name="y1" />
	                       		<input type="hidden" id="pcasx2" name="x2" />
	                       		<input type="hidden" id="pcasy2" name="y2" />
	                       		<input type="hidden" id="pcasid" name="id" value="" />
	                       		<label class="error_image" ></label>
	                       		<input id="pcasctimage" type="hidden" name="ctimage" />
	                       		<input type="hidden" id="lastrecordid" value="service_">
	                       		<input type="hidden" id="pcasctimagename" class="pcasimg" name="ctimagename" value="" />
	                       		<input type="hidden" id="pcasnewname" value="service_" />                                  
	                    	</div>
	                 	</div>
	              	</div>
	           	</div>
	        </div>
	    </div>
	</div>
   </body>
</html>
<?php
// <!-- if($_POST){


// $data = [
// 'secret' => '6Lf6aAsaAAAAAFnwJ86DBVkIDoQ3iLKcsw1K7c7Y',
// 'response' => @$_POST['g-recaptcha-response']
// ];

// $curl = curl_init();

// curl_setopt($curl, CURLOPT_POST, true);
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
// curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

// $response = curl_exec($curl);
// $response = json_decode($response, true);
// print_r($response);
// if ($response['success'] === false) {
// echo "okkk";
// die();
// // Failure

// } else {
// echo "sss";
// die;
// // Success
// } 
// } -->


?>
<script type="text/javascript">    
	var ajax_url = '<?php echo AJAX_URL; ?>';    
	var ajaxObj = {'ajax_url':'<?php echo AJAX_URL; ?>'};    
	var servObj={'site_url':'<?php echo SITE_URL . 'assets/images/business/'; ?>'}; 
	var imgObj={'img_url':'<?php echo SITE_URL . 'assets/images/'; ?>'};
	var ajaxurlObj = {'ajax_url': '<?php echo AJAX_URL;?>'};  
	var siteurlObj = {'site_url': '<?php echo SITE_URL;?>'};
	</script>