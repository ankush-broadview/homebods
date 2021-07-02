<html>
<head>
<?php

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

?>
	<title><?php  echo "Register"; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/css/client-registration.css" />
	<script src="assets/js/jquery-2.1.4.min.js"></script>
	<script src="assets/js/client-registration.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
	<body>
		<div class="ct-loading-main">
      <div class="loader">Loading...</div>
    </div>
		<div class="cont ">
			<?php if(isset($_REQUEST['e']) && $_REQUEST['e']){ ?>
		  	<div class="" style="padding: 5%;text-align: center;">
				<h2>Share Your Email Notification OTP</h2>
				<div style="padding: 5%;text-align: center;">
					<input type="hidden" name="staff_email" id="staff_email" value="<?php echo $_REQUEST['e']; ?>">
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $_REQUEST['u']; ?>">
					<label>
				  		<span>OTP</span>
				  		<input type="text" name="verify_staff_otp" id="verify_staff_otp" class="verify_staff_otp" class="verify_staff_otp" />
					</label>
					<button type="button" href="javascript:void(0);"
					class="submit staff_register_otp">Submit</button>
					<div id="register-meesg" style="display: none;text-align: center;padding-top: 10px;">
						
					</div>
				</div>
			</div>
			<?php } else{ ?>
				<h5> Invalid Url </h5>
			<?php }?>
		</div>
	</body>
</html>
<script>
	
    var baseurlObj = {'base_url': '<?php echo BASE_URL;?>','stripe_publishkey':'<?php echo $settings->get_option('ct_stripe_publishablekey');?>','stripe_status':'<?php echo $settings->get_option('ct_stripe_payment_form_status');?>'};
    var siteurlObj = {'site_url': '<?php echo SITE_URL;?>'};
    var ajaxurlObj = {'ajax_url': '<?php echo AJAX_URL;?>'};
    var fronturlObj = {'front_url': '<?php echo FRONT_URL;?>'};
    var termsconditionObj = {'terms_condition': '<?php echo $settings->get_option('ct_allow_terms_and_conditions');?>'};
		</script>