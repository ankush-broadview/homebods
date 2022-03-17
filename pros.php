<html>

<head>
	<?php
	$filename =  './config.php';
	$file = file_exists($filename);
	if ($file) {
		if (!filesize($filename) > 0) {
			header('location:ct_install.php');
		} else {
			include(dirname(__FILE__) . "/objects/class_connection.php");
			$cvars = new cleanto_myvariable();
			$host = trim($cvars->hostnames);
			$un = trim($cvars->username);
			$ps = trim($cvars->passwords);
			$db = trim($cvars->database);

			$con = new cleanto_db();
			$conn = $con->connect();

			if (($conn->connect_errno == '0' && ($host == '' || $db == '')) || $conn->connect_errno != '0') {
				header('Location: ./config_index.php');
			}
		}
	} else {
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
	<title><?php echo "Register"; ?></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

	<!-- jQuery library -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

	<link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="assets/css/client-registration-new.css" type="text/css" media="all">


	<script src="assets/js/jquery.validate.min.js"></script>

	<script src="assets/js/jquery.Jcrop.min.js" type="text/javascript"></script>
	<script src="assets/js/client-registration.js"></script>
	<link href="assets/select2.css" rel="stylesheet" />
	<script src="assets/select2.js"></script>
	<!-- <script src="https://www.google.com/recaptcha/api.js"></script> -->
	<!------ Include the above in your HEAD tag ---------->


</head>

<body class="body-formt">
	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>

			<div class="col-md-6">
				<div class="ct-loading-main hide">
					<div class="loader">Loading...</div>
				</div>


				<form id="pros_registration_form" class="" method="post">
					<div class="form-group mb-3 mt-3">
						<div class="text-center">
							<a href="https://www.homebods.club/"> <img style="width: 130px;border-radius: 50%;" class="rounded-circle" src="http://localhost/homebods/assets/images/services/company_74315.png" alt="homebods"></a>

							<h3>Let's Grind!</h3>
						</div>
					</div>
					<?php
					include_once('register/step1.php');
					include_once('register/step2.php');


					?>

					<div id="register-meesg" class="pt-3" style="text-align: center;padding-top: 10px;"></div>
				</form>


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
											<label class="error_image"></label>
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
								<label class="error_image"></label>
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


		// for customer rate  float validation

		function isNumberKey(evt, element) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8))
				return false;
			else {
				var len = $(element).val().length;
				var index = $(element).val().indexOf('.');
				if (index > 0 && charCode == 46) {
					return false;
				}
				if (index > 0) {
					var CharAfterdot = (len + 1) - index;
					if (CharAfterdot > 3) {
						return false;
					}
				}

			}
			return true;
		}

		//validation for customer rate end here
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.form-select').css('color', 'black');
			$('#staff_city').select2();
			$('#trainer_type').select2({
				placeholder: "Choose Trainer Type",
				allowClear: true
			});
		});


		var stateWithCities = [];

		function getStates() {
			$.getJSON("http://localhost/homebods/assets/us_states.json", function(resp) {
				stateWithCities = resp;
				let states = Object.keys(stateWithCities);
				$("#staff_state").html('');
				let options = ' <option selected">Select State</option>'
				states.forEach(state => {
					options += `<option>${state}</option>`;
				});
				$("#staff_state").html(options);
				$('#staff_state').select2();
			});
		}

		function getStateCities(state) {

			let cities = stateWithCities[state]
			console.log(cities);
			$("#staff_city").html('');
			let options = '<option selected>Select City</option>'
			cities.forEach(city => {
				options += `<option>${city}</option>`;
			});
			$("#staff_city").html(options);
			$('#staff_city').select2();

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
			}
			
			


		}
		getStates();
	</script>

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

<?php
include(dirname(__FILE__) . "/admin/language_js_objects.php");
?>