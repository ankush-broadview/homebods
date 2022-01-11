<?php   

include (dirname(__FILE__) . '/header.php');
include (dirname(__FILE__) . '/admin_session_check.php');
include (dirname(dirname(__FILE__)) . "/objects/class_userdetails.php");

$con = new cleanto_db();
$conn = $con->connect();
$objuserdetails = new cleanto_userdetails();
$objuserdetails->conn = $conn;
?>

<div id="cta-user-profile">
  <div class="panel-body">
    <div class="tab-content">
      <form novalidate="novalidate" id="user_info_form">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        <?php 
        /* SET SESSION VALUE HERE IN HARD CODED VALUE OF USERid FROM 1 TO SESSION id */
        $objuserdetails->id = $_SESSION['ct_login_user_id'];
		$user_id = $_SESSION['ct_login_user_id'];
        $userinfo = $objuserdetails->readone();
        ?>
        </div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
								<div class="ct-clean-service-image-uploader" style="position: inherit;">
									<?php  		
									if($userinfo[16]==''){
										$imagepath=SITE_URL."assets/images/user.png";
									}else{
										$imagepath=SITE_URL."assets/images/services/".$userinfo[16];
									}

									?>
									<img data-imagename="" id="pppp<?php  echo $user_id; ?>staffimage" src="<?php echo $imagepath;?>" class="ct-clean-staff-image br-100" height="100" width="100">
									<input data-us="pppp<?php  echo $user_id; ?>" class="hide ct-upload-images" type="file" name="" id="ct-upload-imagepppp<?php  echo $user_id;?>" data-id="<?php echo $user_id;?>" />
									<?php 
									if($userinfo[16]==''){
										?>
										<label for="ct-upload-imagepppp<?php echo $user_id; ?>" class="ct-clean-staff-img-icon-label old_cam_ser<?php  echo $user_id; ?>"> 
										 <i class="ct-camera-icon-common br-100 fa fa-camera" id="pcls<?php echo $user_id; ?>camera"></i> 
										 <i class="pull-left fa fa-plus-circle fa-2x" id="ctsc<?php echo $user_id; ?>plus"></i> 
										</label>
									<?php    
									}
									?>
									<label for="ct-upload-imagepppp<?php  echo $user_id; ?>" class="ct-clean-staff-img-icon-label new_cam_ser ser_cam_btn<?php  echo $user_id; ?>" id="ct-upload-imagepppp<?php  echo $user_id; ?>" style="display:none;">
										<i class="ct-camera-icon-common br-100 fa fa-camera stfp-cam-icon" id="pppp<?php  echo $user_id; ?>camera"></i>
										<i class="pull-left fa fa-plus-circle fa-2x stfp-add-icon" id="ctsc<?php  echo $user_id; ?>plus"></i>
									</label>
									<?php 
									if( $userinfo[16] !==''){
										?>
										<a id="ct-remove-staff-imagepppp<?php  echo $user_id; ?>" data-pclsid="<?php echo $user_id; ?>" data-staff_id="<?php echo $user_id; ?>" class="delete_staff_image pull-left br-100 btn-danger bt-remove-staff-img btn-xs ser_new_del<?php  echo $user_id; ?>" rel="popover" data-placement='right' title="<?php echo $label_language_values['remove_image'];?>"> <i class="fa fa-trash" title="<?php echo "Remove profile image";?>"></i></a>
									<?php 
									}
									?>
									 <label><b class="error-service error_image" style="color:red;"></b></label>
									<div id="popover-ct-remove-staff-imagepppp<?php  echo $user_id; ?>" style="display: none;">
										<div class="arrow"></div>
										<table class="form-horizontal" cellspacing="0">
											<tbody>
											<tr>
												<td>
													<a href="javascript:void(0)" id="customer_del_images" value="Delete" data-staff_id="<?php echo $user_id; ?>" class="btn btn-danger btn-sm" type="submit"><?php echo $label_language_values['yes'];?></a>
													<a href="javascript:void(0)" id="ct-close-popover-staff-image" class="btn btn-default btn-sm" href="javascript:void(0)"><?php echo $label_language_values['cancel'];?></a>
												</td>
											</tr>
											</tbody>
										</table>
									</div><!-- end pop up -->
								</div>
								<div id="ct-image-upload-popuppppp<?php  echo $user_id; ?>" class="ct-image-upload-popup modal fade" tabindex="-1" role="dialog">
									<div class="vertical-alignment-helper">
										<div class="modal-dialog modal-lg vertical-align-center">
											<div class="modal-content">
												<div class="modal-header">
													<div class="col-md-12 col-xs-12">
														<a data-staff_id="<?php echo $user_id; ?>" data-us="pppp<?php  echo $user_id; ?>" class="btn btn-success ct_upload_img_staff" data-imageinputid="ct-upload-imagepppp<?php  echo $user_id; ?>" data-id="<?php echo $user_id; ?>"><?php echo $label_language_values['crop_and_save'];?></a>
														<button type="button" class="btn btn-default hidemodal" data-dismiss="modal" aria-hidden="true"><?php echo $label_language_values['cancel'];?></button>
													</div>
												</div>
												<div class="modal-body">
													<img id="ct-preview-imgpppp<?php  echo $user_id; ?>" style="width: 100%;"  />
												</div>
												<div class="modal-footer">
													<div class="col-md-12 np">
														<div class="col-md-12 np">
															<div class="col-md-4 col-xs-12">
																<label class="pull-left"><?php echo $label_language_values['file_size'];?></label> <input type="text" class="form-control" id="ppppfilesize<?php  echo $user_id; ?>" name="filesize" />
															</div>
															<div class="col-md-4 col-xs-12">
																<label class="pull-left">H</label> <input type="text" class="form-control" id="pppp<?php  echo $user_id; ?>h" name="h" />
															</div>
															<div class="col-md-4 col-xs-12">
																<label class="pull-left">W</label> <input type="text" class="form-control" id="pppp<?php  echo $user_id; ?>w" name="w" />
															</div>
															<!-- hidden crop params -->
															<input type="hidden" id="pppp<?php  echo $user_id; ?>x1" name="x1" />
															<input type="hidden" id="pppp<?php  echo $user_id; ?>y1" name="y1" />
															<input type="hidden" id="pppp<?php  echo $user_id; ?>x2" name="x2" />
															<input type="hidden" id="pppp<?php  echo $user_id; ?>y2" name="y2" />
															<input type="hidden" id="pppp<?php  echo $user_id; ?>id" name="id" value="<?php echo $user_id; ?>" />
															<input id="ppppctimage<?php  echo $user_id; ?>" type="hidden" name="ctimage" />
															<input type="hidden" id="recordid" value="<?php echo $user_id; ?>">
															<input type="hidden" id="pppp<?php  echo $user_id; ?>ctimagename" class="ppppimg" name="ctimagename" value="<?php echo $userinfo[16];?>" />
															<input type="hidden" id="pppp<?php  echo $user_id; ?>newname" value="staff_" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								</div>
        <div class="col-lg-8 col-md-8 col-xs-12 np">
          <h4 class="header4"><?php echo $label_language_values['personal_information']; ?></h4>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="firstname"><?php echo $label_language_values['first_name']; ?></label>
            <input class="form-control" name="userfirstname" id="userfirstname" value="<?php echo $userinfo[3]; ?>" type="text">
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="lastname"><?php echo $label_language_values['last_name']; ?></label>
            <input class="form-control" name="userlastname" id="userlastname" value="<?php echo $userinfo[4]; ?>" type="text">
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="grinderid">Grinder User ID</label>
            <input class="form-control usergrinderid" name="usergrinderid" id="usergrinderid" value="<?php echo $userinfo[21]; ?>" type="text">
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="inputEmail"><?php echo $label_language_values['email']; ?></label>
            <input class="form-control useremail" name="useremail" id="useremail" value="<?php echo $userinfo[1]; ?>" type="text">
            <!-- <span class="form-control"><?php //echo $userinfo[1]; ?></span> -->
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="userbio">Bio/Fitness Goal</label>
            <input class="form-control" name="userfitnessbio" id="userfitnessbio" value="<?php echo $userinfo[22]; ?>" type="text">
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="admin-phone-number"><?php echo $label_language_values['phone']; ?></label>
            <input type="tel" class="form-control phone_number" name="userphone" id="userphone" value="<?php echo $userinfo[5]; ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" />
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="admin-address"><?php echo "address"; ?></label>
            <input class="form-control" id="useraddress" name="useraddress" value="<?php echo $userinfo[7]; ?>" />
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="city"><?php echo $label_language_values['city']; ?></label>
            <input class="form-control value_city" id="usercity" name="usercity" placeholder="<?php echo $label_language_values['city']; ?>" value="<?php echo $userinfo[8]; ?>" type="text">
          </div>
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="state"><?php echo $label_language_values['state']; ?></label>
            <input class="form-control value_state" id="userstate" name="userstate" placeholder="<?php echo $label_language_values['state']; ?>" value="<?php echo $userinfo[9]; ?>" type="text"> 
          </div>
          <?php if ($setting->get_option('ct_user_zip_code') == 'Y') { ?>                        
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label for="zip"><?php echo $label_language_values['zip']; ?></label>
            <input class="form-control value_zip" id="userzip" name="userzip" placeholder="<?php echo $label_language_values['zip']; ?>" value="<?php echo $userinfo[6]; ?>" type="text">
          </div>
          <?php } ?>                        
          <div class="form-group col-md-12 col-sm-12 col-xs-12  mb-0">
            <a href="javascript:void(0)" id="btn-change-pass" class="btn btn-link pl-0"><?php echo $label_language_values['change_password']; ?></a>
          </div>
          <div class="ct-change-password hide-div">
            <div class="form-group col-md-12 col-sm-12 col-xs-12 mb-0">
              <label for="useroldpass"><?php echo $label_language_values['old_password']; ?></label>
              <input name="userdboldpass" value="<?php echo $userinfo[2]; ?>" class="form-control" id="userdboldpass" type="hidden">
              <input name="useroldpass" class="form-control u_op" id="useroldpass" type="password" value="<?php echo $userinfo[2]; ?>">
              <label id="msg_oldps" class="old_pass_msg"></label>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <label for="usernewpasswrd"><?php echo $label_language_values['new_password']; ?></label>
              <input name="usernewpasswrd" class="form-control" id="usernewpasswrd" type="password">
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12 mb-0">
              <label for="userrenewpasswrd"><?php echo $label_language_values['retype_new_password']; ?></label>
              <input name="userrenewpasswrd" class="form-control u_rp" id="userrenewpasswrd" type="password">
              <label id="msg_retype" class="retype_pass_msg"></label>
            </div>
          </div>
          <div class="form-group cb col-md-12 col-sm-12 col-xs-12 mb-0 mt-10">
            <!-- SET SESSION ID IN ID -->
            <a href="javascript:void(0)" data-zip="<?php echo $setting->get_option('ct_user_zip_code'); ?>" data-id="<?php echo $_SESSION['ct_login_user_id']; ?>" class="btn btn-success ct-btn-width mybtnuserprofile_save"><?php echo $label_language_values['save']; ?></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"></div>
      </form>
    </div>
  </div>
</div>
<?php include (dirname(__FILE__) . '/footer.php'); ?>
<script type="text/javascript">
	var ajax_url = '<?php echo AJAX_URL;?>';
	var servObj={'site_url':'<?php echo SITE_URL.'assets/images/business/';?>'};
	var imgObj={'img_url':'<?php echo SITE_URL.'assets/images/';?>'};
</script>