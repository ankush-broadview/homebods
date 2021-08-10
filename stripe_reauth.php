<?php
session_start();
?>
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

include (dirname(__FILE__) . '/class_configure.php');
include (dirname(__FILE__) . "/header.php");
include (dirname(__FILE__) . '/objects/class_setting.php');
include (dirname(__FILE__) . '/objects/class_stripe_utils.php');
include (dirname(__FILE__) . "/objects/class_adminprofile.php");

$con = @new cleanto_db();
$conn = $con->connect();
//$_SESSION['stripe_account_id'] = 'acct_1Ij4N0RjDTCejpyc';
$settings = new cleanto_setting();
$settings->conn = $conn;
$stripe_account_status = isset($_SESSION['stripe_account_status']) ? $_SESSION['stripe_account_status'] :  false;

#var_dump($stripe_account_status,$_SESSION['stripe_account_id']);
#die;
#echo "<pre>";
$stripeAcntId = ""; 
	$_SESSION['stripe_onboard_success'] = false;
if(isset($_SESSION['stripe_account_id']) && !empty($_SESSION['stripe_account_id'])) {
 	$stripeAcntId = $_SESSION['stripe_account_id'];
}
if(!$stripe_account_status && !empty($stripeAcntId) ){
	$stripeObj = new cleanto_stripe_utils();
	$accnt = $stripeObj->getStripeAccountDetails($stripeAcntId);
	if($accnt->charges_enabled && $accnt->payouts_enabled) {
		$objadmininfo = new cleanto_adminprofile();
		$objadmininfo->conn = $conn;
		$objadmininfo->updateStripeAccountStatus($stripeAcntId,1);
		$stripe_account_status  = $_SESSION['stripe_account_status'] = true;
	}
} else if (empty($stripeAcntId)) {
	header("Location:".SITE_URL);
}

if ($stripe_account_status) {
	unset($_SESSION['stripe_account_id']);
	unset($_SESSION['stripe_account_status']);
	$_SESSION['stripe_onboard_success'] = true;
	header("Location:".SITE_URL."staff/staff-dashboard.php");
	return;
}

?>
	<title><?php  echo "Register"; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/css/client-registration.css" />
	<script src="assets/js/jquery-2.1.4.min.js"></script>
	<script src="assets/js/client-registration.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
	<body>
		<div class="cont ">
			<?php if(!$stripe_account_status){ ?>
		  	<div class="" style="padding: 5%;text-align: center;">
				<h2>Stripe Account is not complete yet. To get payment the account has to be complete and verified.</h2>
				<div style="padding: 5%;text-align: center;">
					<input id="stripe_id" type="hidden" name="stripe_id" value="<?php echo $stripeAcntId; ?>">
					<a id="stripe-connect-btn" type="button" href="<?=$stripeObj->getStripeOnboardingLink($stripeAcntId);?>"
					class="stripe-connect-btn">Complete it now</a>
					<div id="register-meesg" style="display: none;text-align: center;padding-top: 10px;">
						
					</div>
				</div>
			</div>
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