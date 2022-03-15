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
  	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="/booking/assets/css/bootstrap-select.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
  	<link rel="stylesheet" href="assets/css/client-registration.css" />

  	<script src="assets/js/jquery-2.1.4.min.js"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/booking/assets/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery.Jcrop.min.js" type="text/javascript"></script>
    <script src="assets/js/client-registration.js"></script>
	
    <!------ Include the above in your HEAD tag ---------->
  </head>
	<body>
    <div class="ct-loading-main">
      <div class="loader">Loading...</div>
    </div>
		<div class="cont grinder-main" style="height: 95%;">
		  <div class="form sign-in" >
			  <h2><a href="https://www.homebods.club/"><img src="assets/images/homebods_logo.png" style="width: 130px;border-radius: 50%;"></a></h2>
			  <h3 style="text-align: center;font-weight: bolder;color: #8b29fc;">LET’S GRIND!</h3>
			  <!-- <h6 style="text-align: center;">Client Registration</h6> -->
        <form id="grinder_registration_form" class="" method="post">
  			  <label>
  				  <span>First Name</span>
  				  <input type="text" name="first_name" placeholder="" id="first_name" />
  			  </label>
			  <label>
  				  <span>Last Name</span>
  				  <input type="text" name="last_name" placeholder="" id="last_name" />
  			  </label>
          <label>
            <span>Homebod User ID</span>
            <input type="text" name="grinder_user_id" placeholder="" id="grinder_user_id" />
            <label for="grinder_user_id" style="display: none;" id="grinder_user_id_exist" generated="true" class="error">User ID Already Exist</label>
          </label>
  			  <label>
  				  <span>Email</span>
  				  <input type="email" name="client_email" placeholder="" id="client_email" />
            <label for="client_email" style="display: none;" id="client_email_exist" generated="true" class="error">Email ID Already Exist</label>
  			  </label>
          <label>
            <span>Bio/Fitness Goal</span>
            <input type="text" name="fitness_goal" placeholder="" id="fitness_goal" />
          </label>
  			  <label>
  				  <span>Password</span>
  				  <input type="password" name="client_password" placeholder="" id="client_password" />
  			  </label>
  			  <label>
  				  <span>Re-Enter Password</span>
  				  <input type="password" name="client_repassword" placeholder="" id="client_repassword" />
  			  </label>
  				<label>
  				  <span>Phone</span>
  				  <input type="text" placeholder="" name="client_phone" id="client_phone" />
  			  </label>
  			  <label>
  			    <span>Address</span>
  				  <input type="text" placeholder="" name="client_address" id="client_address" />
  			  </label>
  				<label>
  				  <span>City</span>
  				  <input type="text" placeholder="" required name="client_city" id="client_city" />
  				</label>
  				<label>
  				  <span>State</span>
  				  <input type="text" placeholder="" name="client_state" id="client_state" />
  			  </label>
  				<label>
  				  <span>Zip</span>
  				  <input type="text" placeholder="" name="client_zip" id="client_zip" />
  			  </label> 
  			  <label>
  				  <span>Country</span>
  				  <input type="text" placeholder="" name="client_country" id="client_country" />
  			  </label> 
          <label class="w-100 image-upload-main">
            <span>Photo Upload</span>
            <input data-us="pcas" class="ct-upload-images" type="file" name="" id="ct-upload-imagepcas" /> 
            <button type="button" href="" class="upload-file-button">Select Upload File</button>
            <div class="ct-clean-service-image-uploader service-image-upload-set" style="height: 100%">
              <img id="pcasserviceimage" src="<?php echo SITE_URL; ?>assets/images/default_service.png" class="ct-clean-service-image br-100" height="100" width="100">
              <label for="ct-upload-imagepcas" class="ct-clean-service-img-icon-label">                             
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
                      <td>
                        <a href="javascript:void(0)" id="" value="Delete" class="btn btn-danger btn-sm" type="submit"><?php echo $label_language_values['yes']; ?></a>
                        <a href="javascript:void(0)" id="ct-close-popover-service-imagepcas" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo $label_language_values['cancel']; ?></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- end pop up -->                                                                    
            </div>
            <label class="error_image" style="margin-top: 14px;"></label>
          </label>
  				<label style="width:100% !important; text-align:left !important">	
  					<input type="checkbox" style="width: 10px !important; float:left;" class="term_condition" id="term_condition" name="term_condition" value="Y"><span  style="margin: 10px !important;">BY REGISTERING AS A GRINDER WITH HOMEBODS, YOU HEREBY REPRESENT THAT YOU HAVE READ AND AGREE TO OUR <a href="<?php echo $settings->get_option('ct_terms_condition_link_for_customer');?>">TERMS OF SERVICE</a> WHICH INCLUDES OUR PRIVACY POLICY, COMMUNITY GUIDELINES, AND COVID-19 POLICY.<span>
            <label class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</label>
  				</label> 
  			  <div class="before-submit">
  				  <button type="button" href="javascript:void(0);" class="client_register_front">Homebod Registration</button>
  			  </div>
        </form>
			</div>
			<div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
			  <div class="modal-dialog">
  				<div class="modal-content">
  				  <div class="modal-header">
  					  <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
  					  <h4 class="modal-title" id="myModalLabel"></h4>
  				  </div>
  				  <div class="modal-body">
  					  <p style="text-align:center; font-size:20px">Thank You for Registering with HOMEBODS! You will receive a Welcome Email Shortly!</p>                     
  				  </div>    
  				</div>
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
<script>
  var ajax_url = '<?php echo AJAX_URL; ?>';  
  var baseurlObj = {'base_url': '<?php echo BASE_URL;?>','stripe_publishkey':'<?php echo $settings->get_option('ct_stripe_publishablekey');?>','stripe_status':'<?php echo $settings->get_option('ct_stripe_payment_form_status');?>'};
  var siteurlObj = {'site_url': '<?php echo SITE_URL;?>'};
  var ajaxurlObj = {'ajax_url': '<?php echo AJAX_URL;?>'};
  var fronturlObj = {'front_url': '<?php echo FRONT_URL;?>'};
  var termsconditionObj = {'terms_condition': '<?php echo $settings->get_option('ct_allow_terms_and_conditions');?>'};
  var servObj={'site_url':'<?php echo SITE_URL . 'assets/images/business/'; ?>'};
  var imgObj={'img_url':'<?php echo SITE_URL . 'assets/images/'; ?>'};
</script>
<?php  
  include(dirname(__FILE__)."/admin/language_js_objects.php");
?>