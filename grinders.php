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
  	

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<!-- 
	  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

	 
	<link rel="stylesheet" href="assets/css/client-registration-new.css" type="text/css" media="all">

  	<!-- <script src="assets/js/jquery-2.1.4.min.js"></script> -->
    <script src="assets/js/jquery.validate.min.js"></script>
    <!-- <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/booking/assets/js/bootstrap-select.min.js" type="text/javascript"></script> -->
    <script src="assets/js/jquery.Jcrop.min.js" type="text/javascript"></script>
  	<script src="assets/js/client-registration.js"></script>
	<link href="assets/select2.css" rel="stylesheet" />
	<script src="assets/select2.js"></script>
	<!-- <script src="https://www.google.com/rec
	
   Include the above in your HEAD tag ---------->
  </head>
	<body class="body-formt">
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>

			<div class="col-md-6">
				<div class="ct-loading-main">
					<div class="loader">Loading...</div>
				</div>
        <form id="grinder_registration_form" class="" method="post">
					<div class="form-group mb-3 mt-3">
						<div class="text-center">
							<a href="https://www.homebods.club/"> <img style="width: 130px;border-radius: 50%;" class="rounded-circle" src="https://localhost/homebods/assets/images/services/company_74315.png" alt="homebods"></a>

							<h3>Let's Grind!</h3>
						</div>
					</div>
					<?php
					include_once('grinderRegister/step1.php');
					include_once('grinderRegister/step2.php');


					?>

					<div id="register-meesg" class="pt-3" style="text-align: center;padding-top: 10px;"></div>
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
  					  <p style="text-align:center; font-size:20px;color: #000;">Thank You for Registering with HOMEBODS! You will receive a Welcome Email Shortly!</p>                     
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
    
    


    <script type="text/javascript">
		var ajax_url = '<?php echo AJAX_URL; ?>';
		
		var ajaxObj = {
			'ajax_url': '<?php echo AJAX_URL; ?>'
		};
		var servObj = {
			'site_url': '<?php echo SITE_URL . 'assets/images/business/'; ?>'
		};
		var imgObj = {
			'img_url': '<?php echo SITE_URL . 'assets/images/'; ?>'
		};
		var ajaxurlObj = {
			'ajax_url': '<?php echo AJAX_URL; ?>'
		};
		var siteurlObj = {
			'site_url': '<?php echo SITE_URL; ?>'
		};
		console.log(siteurlObj);

	

		

		//validation for customer rate end here
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
		
			$('.form-select').css('color', 'black');
			$('#client_city').select2();
			$('#trainer_type').select2({
				placeholder: "Choose Trainer Type",
				allowClear: true
			});
		});


		var stateWithCities = [];

		function getStates() {
			$.getJSON(siteurlObj.site_url+"assets/us_states.json", function(resp) {
				stateWithCities = resp;
				let states = Object.keys(stateWithCities);
				$("client_state").html('');
				let options = ' <option selected">Select State</option>'
				states.forEach(state => {
					options += `<option>${state}</option>`;
				});
				$("#client_state").html(options);
				$('#client_state').select2();
			});
		}

		function getStateCities(state) {

			let cities = stateWithCities[state]
			console.log(cities);
			$("#client_city").html('');
			let options = '<option selected>Select City</option>'
			cities.forEach(city => {
				options += `<option>${city}</option>`;
			});
			$("#client_city").html(options);
			$('#client_city').select2();

		}

		
		function nextform(id) {
			// $("#step1Form").validate();
			// if ($("#step1Form").valid()) {
				if (id == "form1") {
				step1.style.display = "none";
				step2.style.display = "block";
				}
				if (id == "form2") {
					step2.style.display = "none";
					step1.style.display = "block";
				}
			//}
			
			


		}
		getStates();
	</script>



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