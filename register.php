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
      	<link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
      	<link rel="stylesheet" href="assets/css/client-registration.css" type="text/css" media="all">

      	<script src="assets/js/jquery-2.1.4.min.js"></script>
  		<script src="assets/js/bootstrap.min.js" type="text/javascript" ></script>
  		
  		<script src="assets/js/jquery.Jcrop.min.js" type="text/javascript" ></script>
      	<script src="assets/js/client-registration.js"></script>

     
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
						<label style="width:100% !important; text-align:left !important">
								
						<input type="checkbox" style="width: 10px !important; float:left;" class="term_condition" id="term_condition" name="term_condition" value="Y"><span  style="margin: 10px !important;">By Registering with HOMEBODS, Ltd., you are agreeing to the Terms and Conditions of the Company.<span>
				</label> 
				<span class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</span>
            <div class="before-submit">
               <button type="button" href="javascript:void(0);" class="client_register_front">Homebod Registration</button>
            </div>
        </div>
        <div class="sub-cont">
            <div class="img">
               <div class="img__text m--up">
                  <h2>New here?</h2>
                  <p>If you want to sign up as Vendor</p>
               </div>
               <div class="img__text m--in">
                  <h2>One of us?</h2>
                  <p>If you want to sign up as Client</p>
               </div>
               <div class="img__btn img__btnss">
                  <span class="m--up">Sign Up As Vendor</span>
                  <span class="m--in">Sign Up As Client</span>
               </div>
            </div>
            <div class="form sign-up">
                <h2><a href="www.homebods.club"><img src="assets/images/services/company_73345.png" style="width: 100px;"></a></h2>
               	<h2>FITNESS PRO REGISTRATION</h2>
             <form method="POST" id="proregister" name="proregister" >
                <label>
               		<span>Name</span>
               		<input type="text" name="staff_name" placeholder="" id="staff_name" class="staff_name"/>
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
				<span class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</span>
               	<div class="before-submit">
                  	<button type="button" href="javascript:void(0);" class="staff_register_front">Pro Registration</button>
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

<script type="text/javascript">    
	var ajax_url = '<?php echo AJAX_URL; ?>';    
	var ajaxObj = {'ajax_url':'<?php echo AJAX_URL; ?>'};    
	var servObj={'site_url':'<?php echo SITE_URL . 'assets/images/business/'; ?>'}; 
	var imgObj={'img_url':'<?php echo SITE_URL . 'assets/images/'; ?>'};
	var ajaxurlObj = {'ajax_url': '<?php echo AJAX_URL;?>'};  
	var siteurlObj = {'site_url': '<?php echo SITE_URL;?>'};
	</script>