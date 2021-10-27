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
         include(dirname(__FILE__) . '/header.php');
         include(dirname(__FILE__) . '/objects/class_setting.php');
         include(dirname(__FILE__) . '/objects/class_services.php');
         
         $con = @new cleanto_db();
         $conn = $con->connect();
         
         $settings = new cleanto_setting();
         $settings->conn = $conn;

         $objservices = new cleanto_services();
         $objservices->conn = $conn;
         
         ?>
      	<title><?php  echo "Register"; ?></title>
      	<link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css" type="text/css" media="all">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css" type="text/css" media="all">
      	<link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
      	<link rel="stylesheet" href="assets/css/client-registration.css" type="text/css" media="all">

      	<script src="assets/js/jquery-2.1.4.min.js"></script>
        <script src="assets/js/jquery.validate.min.js"></script>
  		  <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
  		  <script src="assets/js/bootstrap-select.min.js" type="text/javascript"></script>
  		  <script src="assets/js/jquery.Jcrop.min.js" type="text/javascript"></script>
      	<script src="assets/js/client-registration.js"></script>

     <!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
      <!------ Include the above in your HEAD tag ---------->
   </head>
   <body>
    <div class="ct-loading-main">
      <div class="loader">Loading...</div>
    </div>
    <div class="cont s--signup" style="height: 95%;">
      <div class="sub-cont pros-main">
        <div class="form sign-up">
          <h2><a href="https://www.homebods.club/"><img src="assets/images/services/company_74315.png" style="width: 130px;border-radius: 50%;"></a></h2> 
          <h3 style="text-align: center;font-weight: bolder;color: #8b29fc;">FITNESS PRO REGISTRATION</h3> 
          <form id="pros_registration_form" class="" method="post">
            <label>
              <span>First Name</span>
              <input type="text" name="first_name" placeholder="" id="first_name" />
            </label>
			<label>
              <span>Last Name</span>
              <input type="text" name="last_name" placeholder="" id="last_name" />
            </label>
			<label>
           		<span>Email</span>
           		<input type="email" name="staff_email" placeholder="" id="staff_email" />
              <label for="staff_email" style="display: none;" id="staff_email_exist" generated="true" class="error">Email ID Already Exist</label>
           	</label>
            <label>
              <span>Fitness Pro User ID</span>
              <input type="text" name="staff_user_id" placeholder="" id="staff_user_id" />
              <label for="staff_user_id" style="display: none;" id="staff_user_id_exist" generated="true" class="error">User ID Already Exist</label>
            </label>
            
           	<label>
           		<span>Password</span>
           		<input type="password" name="staff_password" placeholder="" id="staff_password" />
           	</label>
           	<label>
              <span>Re-Enter Password</span>
              <input type="password" name="staff_repassword" placeholder="" id="staff_repassword" />
            </label>
            <label>
              <span>Bio/Services Offered</span>
              <input type="text" name="staff_bio" placeholder="" id="staff_bio" />
            </label> 
           	<label>
           		<span>Phone</span>
           		<input type="text" name="staff_phone" id="staff_phone" placeholder="" />
           	</label>
           	<label>
           		<span>City</span>
           		<input type="text" name="staff_city" placeholder="" id="staff_city" />
           	</label>
           	<label>
           		<span>State</span>
           		<input type="text" name="staff_state" placeholder="" id="staff_state" />
           	</label> 
           	<label>
           		<span>Zip</span>
           		<input type="text" placeholder="" name="staff_zip" id="staff_zip" />
           	</label> 
           	<label>
           		<span>Country</span>
           		<input type="text" placeholder="" name="staff_country" id="staff_country" />
           	</label>
            <label>
              <span>Online video link</span>
              <input type="text" placeholder="" name="zoom_link" id="zoom_link" />
            </label>
           	<label>
           		<span>Online Option Offered?</span>
           		<select name="offered" id="offered" class="staff_image select-imag-set bg-trasprent">
           			<option value="Y">Yes</option>
           			<option value="N">No</option>
           		</select>
           	</label> 
			      <label>
              <span>Trainer For</span>
              <!-- <select name="trainer_type" id="trainer_type" class="staff_image select-imag-set"> -->
              <select class="selectpicker mb-10 w-100 trainer-select" name="trainer_type" id="trainer_type" multiple data-size="10" style="display: none;">
                <!-- <option value="">---Choose Trainer Type---</option> -->
                <option value="" disabled>Choose Trainer Type</option>
                <!-- <option value="general">Physical Training/General Fitness</option>
                <option value="yoga">Yoga</option> -->
                <?php 
                  $getservice = $objservices->getalldata();
                  while($arr = @mysqli_fetch_array($getservice)){
                    if ($arr[5] == 'E') {
                      echo "<option value='".$arr[0]."'>".$arr[1]."</option>";
                    }
                  }
                ?>
              </select>
            </label>
  			    <label>
              <span>Custom Rate</span>
              <input type="text" placeholder="" name="custom_rate" id="custom_rate" />
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
              <label class="error_image" style="margin-top: 16px;"></label>
           	</label>
		
						<label style="width:100% !important; margin-top:30px; text-align:left !important">
         			<input type="checkbox" style="width: 10px !important; float:left;" class="term_condition" id="term_condition" name="term_condition" value="Y"><!-- <span  style="margin: 10px !important;">By Registering with HOMEBODS, Ltd., you are agreeing to the Terms and Conditions of the Company.<span> -->
              <span  style="margin: 10px !important;">BY REGISTERING AS A FITNESS PRO WITH HOMEBODS, YOU HEREBY REPRESENT THAT YOU HAVE READ AND AGREE TO OUR <a href="<?php echo $settings->get_option('ct_terms_condition_link_for_staff');?>">TERMS OF SERVICE</a> WHICH INCLUDES OUR PRIVACY POLICY, COMMUNITY GUIDELINES, AND COVID-19 POLICY.<span>
              <label class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</label>
             	</label> 
           	<div class="before-submit">
              <button type="button" href="javascript:void(0);" class="staff_register_front">Pro Registration</button>
           	</div>
           	<div id="register-meesg" class="pt-3" style="text-align: center;padding-top: 10px;"></div>
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
<?php  
  include(dirname(__FILE__)."/admin/language_js_objects.php");
?>