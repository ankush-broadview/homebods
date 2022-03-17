<div id="step2">

     

    <div class="mb-3">
        <label class="form-label">State</label><br>
        <select onchange="getStateCities(this.value)"  id="staff_state" name="staff_state" class="form-control"  aria-label="Default select example">
            <option selected>Select State</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label class="form-label">City</label><br>
        <select class="form-control"  name="staff_city" id="staff_city" aria-label="Default select example">
            <option selected>Select City</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Zip</label>
        <input type="text" name="staff_zip"  id="staff_zip" class="form-control" placeholder="Enter Zip">
    </div>
    <div class="mb-3">
        <label class="form-label">Online video link</label>
        <input type="text" name="zoom_link" id="zoom_link" class="form-control" placeholder="Enter Online Video Link">
    </div>

    <div class="mb-3">Online Option Offered?</label>
        <select name="offered" id="offered" class="form-control">
           			<option value="Y">Yes</option>
           			<option value="N">No</option>
           		</select>
    </div>



    <div class="mb-3">
        <label class="form-label">Services</label>
      
        <!-- <select name="trainer_type" id="trainer_type" class="staff_image select-imag-set"> -->
        <select class="form-control" name="trainer_type" id="trainer_type" multiple >
                <!-- <option value="">---Choose Trainer Type---</option> -->
               
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
    </div>




    <div class="mb-3">

        <div class="row pl-3">

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
                   
                </div>
                <label class="error_image" style="margin-top: 16px;"></label>
            </label>
        </div>

    </div>
    <div class="mb-3">

        <div class="row">

            <label style="width:100% !important; margin-top:10px;margin-left:15px; text-align:left !important">
                <input type="checkbox" style="width: 11px !important; float:left;" class="term_condition" id="term_condition" name="term_condition" value="Y"><!-- <span  style="margin: 10px !important;">By Registering with HOMEBODS, Ltd., you are agreeing to the Terms and Conditions of the Company.<span> -->
                <span style="margin: 10px !important;font-size:12">BY REGISTERING AS A FITNESS PRO WITH HOMEBODS, YOU HEREBY REPRESENT THAT YOU HAVE READ AND AGREE TO OUR <a href="<?php echo $settings->get_option('ct_terms_condition_link_for_staff'); ?>">TERMS OF SERVICE</a> WHICH INCLUDES OUR PRIVACY POLICY, COMMUNITY GUIDELINES, AND COVID-19 POLICY.<span>
                        <label class="spacial_class" style="display:none; color:red">Please Agree Terms and Condition for Register</label>
            </label>
        </div>

    </div>
    <div class="mb-3">

        <div class="row">

            <div class="col"><button type="button" id="form2" class="form-control btnback" onclick="nextform(this.id)">Back</button></div>
            <div class="col"><button type="button" class="form-control btnsubmit staff_register_front">Submit</button></div>
            <div id="register-meesg" style="text-align: center;"></div>
        </div>

    </div>

</div>
