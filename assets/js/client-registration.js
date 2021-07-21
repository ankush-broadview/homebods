 /*jQuery(document).ready(function () {

  document.querySelector('.img__btnss').addEventListener('click', function() {

    document.querySelector('.cont').classList.toggle('s--signup');

  });

 });*/



  /* LOAD ALL NOTIFICATION */
/* Create variables (in this scope) to hold the Jcrop API and image size */ 

var jcrop_api, boundx, boundy;
  jQuery(document).on("change", ".ct-upload-images", function (e) {

  var uploadsection = jQuery(this).attr("id");

  var ctus = jQuery(this).attr("data-us");

  var oFile = jQuery("#" + uploadsection)[0].files[0];

  jQuery("#" + ctus + "ctimagename").val(oFile.name);

  /* check for image type (jpg and png are allowed) */

  var rFilter = /^(image\/jpeg|image\/png|image\/gif)$/i;

  if (!rFilter.test(oFile.type)) {

    jQuery(".error_image").addClass("error");

    jQuery(".error_image").html("Please select valid image, Only jpeg, jpg, png, and gif images allowed").show();

    return;

  }

  /*  check for file size  */

  var file = this.files[0];

  var fileType = file["type"];

  var ValidImageTypes = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

  if (jQuery.inArray(fileType, ValidImageTypes) < 0) {

    jQuery(".error_image").addClass("error");

    jQuery(".error_image").html("Only jpeg, jpg, png, and gif images allowed");

    return;

  }

  var file_size = jQuery(this)[0].files[0].size;

  var maxfilesize = 1048576 * 2;

  /*  Here 2 repersent MB  */

  if (file_size >= maxfilesize) {

    jQuery(".error_image").addClass("error");
    jQuery(".error_image").show();
    jQuery(".error_image").html("Maximum file upload size is 2 MB");

    return;

  }

  var file_size = jQuery(this)[0].files[0].size;

  var minfilesize = 1048576 * 0.0005; 

  /*  Here 5 repersent KB  */

  if (file_size <= minfilesize) {

    jQuery(".error_image").addClass("error");

    jQuery(".error_image").html("Minimum file upload size is 1 KB");

    return;

  }

  /* preview element */

  var oImage = document.getElementById("ct-preview-img" + ctus);

  /* prepare HTML5 FileReader */

  var oReader = new FileReader();
  // alert("#ct-image-upload-popup" + ctus);
  oReader.onload = function (e) {
    jQuery(".error_image").hide();
    /* e.target.result contains the DataURL which we can use as a source of the image */

    oImage.src = e.target.result;

    oImage.onload = function () { /* onload event handler */

      /* show image popup for image crop */

      jQuery("#ct-image-upload-popup" + ctus).modal();

      jQuery("#ct-image-upload-popup" + ctus).modal('show');

      /*  display some basic image info */

      var sResultFileSize = bytesToSize(oFile.size);

      jQuery("#" + ctus + "filesize").val(sResultFileSize);

      jQuery("#" + ctus + "ctimagetype").val(oFile.type);



      /* destroy Jcrop if it is existed */

      if (typeof jcrop_api != "undefined") {

        jcrop_api.destroy();

        jcrop_api = null;

        jQuery("#ct-preview-img" + ctus).width(oImage.naturalWidth);

        jQuery("#ct-preview-img" + ctus).height(oImage.naturalHeight);

      }

      jQuery("#ct-preview-img" + ctus).width(oImage.naturalWidth);

      jQuery("#ct-preview-img" + ctus).height(oImage.naturalHeight);

      setTimeout(function () {

        jQuery("#ct-preview-img" + ctus).Jcrop({

          minSize: [32, 32], /* min crop size */

          /* onSelect: [0, 0, 150, 180], */

          setSelect: [1000,1000, 180, 200],

          /* aspectRatio: 1, */ /* keep aspect ratio 1:1 */

          bgFade: true, /* use fade effect */

          bgOpacity: .3, /* fade opacity   */

          /* maxSize: [200, 200],           */



          boxWidth: 575,   /* Maximum width you want for your bigger images */

          boxHeight: 400,

          /* trueSize : [1000,1500], */

          /* onSelect: showCoords,   */

          /* onChange: showCoords,   */



          onChange: function (e) {

            jQuery("#" + ctus + "x1").val(e.x);

            jQuery("#" + ctus + "y1").val(e.y);

            jQuery("#" + ctus + "x2").val(e.x2);

            jQuery("#" + ctus + "y2").val(e.y2);

            jQuery("#" + ctus + "w").val(e.w);

            jQuery("#" + ctus + "h").val(e.h);

          },

        onSelect: function (e) {

            jQuery("#" + ctus + "x1").val(e.x);

            jQuery("#" + ctus + "y1").val(e.y);

            jQuery("#" + ctus + "x2").val(e.x2);

            jQuery("#" + ctus + "y2").val(e.y2);

            jQuery("#" + ctus + "w").val(e.w);

            jQuery("#" + ctus + "h").val(e.h);

          },

          onRelease: clearInfo

        }, function () {

          /* jcrop_api.destroy(); */

          /* use the Jcrop API to get the real image size */

          var bounds = this.getBounds();

          boundx = bounds[0];

          boundy = bounds[1];



          /* Store the Jcrop API in the jcrop_api variable */

          jcrop_api = this;

        });

      }, 500);



    };

  };

  oReader.readAsDataURL(oFile);

});

/*  image upload in services  */

/* convert bytes into friendly format */

function bytesToSize(bytes) {

  var sizes = ["Bytes", "KB", "MB"];

  if (bytes == 0) return "n/a";

  var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));

  return (bytes / Math.pow(1024, i)).toFixed(1) + " " + sizes[i];

};
/* clear info by cropping (onRelease event handler) */

function clearInfo() {

  jQuery(".info #w").val("");

  jQuery(".info #h").val("");

};

/* UPLOAD SERVCIE IMAGE */

var serviceimagename = "";

jQuery(document).on("click", ".ct_upload_img1", function (e) {

  jQuery(".ct-loading-main").show();

  var img_site_url = servObj.site_url;

  var imgObj_url = imgObj.img_url;

  var imageuss = jQuery(this).attr("data-us");

  var imageids = jQuery(this).attr("data-imageinputid");

  var file_data = jQuery("#" + jQuery(this).attr("data-imageinputid")).prop("files")[0];

  var formdata = new FormData();

  var ctus = jQuery(this).attr("data-us");

  var img_w = jQuery("#" + ctus + "w").val();

  var img_h = jQuery("#" + ctus + "h").val();

  var img_x1 = jQuery("#" + ctus + "x1").val();

  var img_x2 = jQuery("#" + ctus + "x2").val();

  var img_y1 = jQuery("#" + ctus + "y1").val();

  var img_y2 = jQuery("#" + ctus + "y2").val();

  var img_name = jQuery("#" + ctus + "newname").val();



  

  var img_id = jQuery("#" + ctus + "id").val();

  formdata.append("image", file_data);

  formdata.append("w", img_w);

  formdata.append("h", img_h);

  formdata.append("x1", img_x1);

  formdata.append("x2", img_x2);

  formdata.append("y1", img_y1);

  formdata.append("y2", img_y2);

  formdata.append("newname", img_name);

  formdata.append("img_id", img_id);

  jQuery(".ct-loading-main").show();
  
  jQuery.ajax({

    url: ajax_url + "upload.php",

    type: "POST",

    data: formdata,

    cache: false,

    contentType: false,

    processData: false,

    success: function (data) {

      jQuery(".ct-loading-main").hide();

      if (data == "") {

        jQuery(".error-service").addClass("show");

        jQuery(".hidemodal").trigger("click");

      } else {

        jQuery("#" + ctus + "ctimagename").val(data);

        jQuery(".hidemodal").trigger("click");

        jQuery("#" + ctus + "serviceimage").attr("src", imgObj_url + "services/" + data);

        jQuery(".error_image").hide();

        jQuery("#" + ctus + "serviceimage").attr("data-imagename", data);

        serviceimagename = jQuery("#" + ctus + "serviceimage").attr("data-imagename");

      }

      jQuery("#"+imageids).val("");

    }

  });

});

jQuery(document).on("click",".staff_register_front",function() {
  jQuery("#pros_registration_form").validate({
    rules: {
      first_name:{ required:true },
	    last_name:{ required:true },
      staff_user_id:{ required:true },
      trainer_type:{ required:true },
      staff_email:{ required:true,email:true },
      staff_password:{ required:true,minlength:10 },
      staff_repassword:{ required:true, equalTo: "#staff_password" },
      staff_bio:{ required:true },
      staff_phone:{ required:true,digits: true },
      //staff_address:{ required:true },
      staff_city:{ required:true },
      staff_state:{ required:true },
      staff_zip:{ required:true,digits: true },
      staff_country:{ required:true },
      zoom_link:{ required:true },
	    custom_rate:{ required:true },
      //price_for_single:{ required:true,digits: true },
      //price_for_3:{ required:true,digits: true },
      //price_for_5:{ required:true,digits: true }
    },
    ignore: ':hidden:not("#trainer_type")',
    messages: {
      first_name:{ required:'Please Enter First Name' },
	    last_name:{ required:'Please Enter Last Name' },
      staff_user_id:{ required:'Please Enter User ID' },
      trainer_type:{ required:'Please Select Trainer Type' },
      staff_email:{ required:'Please Enter Email', email:'Please Enter Valid Email' },
      staff_password:{ required:'Please Enter Password',minlength:'Password Must be 10 Characters' },
      staff_repassword:{ required:'Please Re-Enter Password', equalTo:'Password Not Matched' },
      staff_bio:{ required:'Please Enter Bio/Services Offered' },
      staff_phone:{ required:'Please Enter Phone No.',digits:'Only Digits Allow' },
      //staff_address:{ required:'Please Enter Address' },
      staff_city:{ required:'Please Enter City' },
      staff_state:{ required:'Please Enter State' },
      staff_zip:{ required:'Please Enter Zip Code',digits:'Only Digits Allow' },
      staff_country:{ required:'Please Enter Country' },
      zoom_link:{ required:'Please Enter Zoom Link' },
	    custom_rate:{ required:'Please Enter Custom Rate' },
      //price_for_single:{ required:'Please Enter Price',digits:'Only Digits Allow' },
      //price_for_3:{ required:'Please Enter Price',digits:'Only Digits Allow' },
      //price_for_5:{ required:'Please Enter Price',digits:'Only Digits Allow' }
    }
  });

  if(!jQuery("#pros_registration_form").valid()){
    return false;
  }
  var ajax_url=ajaxurlObj.ajax_url;
  var site_url=siteurlObj.site_url;

  jQuery(".ct-load-bar").show();
  
  var ct_email = jQuery("#staff_email").val();
  var ct_password = jQuery("#staff_password").val();
  var ct_staff_bio = jQuery("#staff_bio").val();
  var first_name = jQuery("#first_name").val();
  var last_name = jQuery("#last_name").val();
  var ct_phone = jQuery("#staff_phone").val();
  var ct_address = jQuery("#staff_address").val(); 
  var ct_zip_code = jQuery("#staff_zip").val();
  var ct_city = jQuery("#staff_city").val();
  var ct_state = jQuery("#staff_state").val();          
  var ct_country = jQuery("#staff_country").val();          
  var zoom_link = jQuery("#zoom_link").val();          
  var trainer_type = jQuery("#trainer_type").val();  
  var offered = jQuery("#offered").val();  
  var price_for_single = '';  
  var price_for_3 = '';  
  var price_for_5 = '';  
  var pro_user_id = jQuery("#staff_user_id").val();  
  var fileInput =jQuery("#pcasctimagename").val();
  var term_condition = jQuery("#term_condition").prop("checked");
  var custom_rate = jQuery("#custom_rate").val();

  if(term_condition == false){
    jQuery(".spacial_class").show();
    return false;
  }

  jQuery(".ct-loading-main").show();
  jQuery.ajax({
    type: "POST",
    data: { 
      "phone":ct_phone,
      "address":'',
      "city":ct_city,
      "state":ct_state,
      "country":ct_country,
      "zoom_link":zoom_link,
      "first_name":first_name,
	    "last_name":last_name,
      "email":ct_email,
      "pass":ct_password,
      "staff_bio":ct_staff_bio,
      "zip_code":ct_zip_code,
      "offered":offered,
      "price_for_single":price_for_single,
      "price_for_3":price_for_3,
      "price_for_5":price_for_5,
      "trainer_type":trainer_type,
      "pro_user_id":pro_user_id,
      "file" : fileInput,
	    "custom_rate" : custom_rate,
      action:"pre_staff_reg_himself" 
    }, 
    url: ajax_url + "admin_login_ajax.php",
    success: function (res) { 
      //console.log(res);
      if (res == 2) {
        jQuery(".ct-loading-main").hide();
        jQuery("#staff_email_exist").show();
        jQuery("#staff_email").focus();
        return false;
      }else if(res == 0){
        jQuery(".ct-loading-main").hide();
        jQuery("#staff_user_id_exist").show();
        jQuery("#staff_user_id").focus();
        return false;
      }
      jQuery(".ct-loading-main").hide();
      if(res == 1){
        window.location.href = site_url + "otp_berify.php?e="+ct_email+"&u="+pro_user_id;
        jQuery(".ct-loading-main").hide();
        /*setTimeout(function() {
          window.location.href = site_url + "otp_berify.php?e="+ct_email;
        }, 2000);*/ 
      }else{
        jQuery(".ct-loading-main").hide();
		    jQuery("#register-meesg").show();
        jQuery("#register-meesg").html('<h5 style="color:red">'+res+'</h5>');
      }
    }
  });

  jQuery(".ct-notifications-inner").addClass("visible");
});

jQuery(document).on("keyup","#staff_user_id",function() {
  jQuery("#staff_user_id_exist").hide();
});

jQuery(document).on("keyup","#staff_email",function() {
  jQuery("#staff_email_exist").hide();
});

jQuery(document).on("click",".staff_register_otp",function() {
  jQuery(".ct-loading-main").show();
  var ajax_url = ajaxurlObj.ajax_url;
  var site_url = siteurlObj.site_url;
  jQuery(".ct-load-bar").show();
  var ct_email = jQuery("#staff_email").val();
  var ct_user_id = jQuery("#user_id").val();
  var verify_staff_otp = jQuery("#verify_staff_otp").val();          
  
  jQuery.ajax({
      type: "POST",
      data: { 
        "email":ct_email,
        "user_id":ct_user_id,
        "otp":verify_staff_otp,
        action:"pre_staff_otp_check" 
      },
      url: ajax_url + "admin_login_ajax.php",
      success: function (res) {   
        jQuery(".ct-loading-main").hide();
        jQuery("#register-meesg").css('display','block');
        var result = jQuery.parseJSON(res);
        let resStatus = result.status;
        if(resStatus == 11 || resStatus == 1){
          if (result.data && result.data.onboarding_url) {
             setTimeout(function() {
               window.location.href = result.data.onboarding_url;
            }, 500); 
          }else{
            jQuery("#register-meesg").html('<h5 style="color:red">Something went wrong..</h5>');
          }
         
        }else if(resStatus == 12 || resStatus == 2){
           jQuery("#register-meesg").html('<h5 style="color:red">Invalid OTP.</h5>');
        }else{
          jQuery("#register-meesg").html('<h5 style="color:red">'+result.msg+'</h5>');
        }
      }
  }); 
  
});



jQuery(document).on("click",".client_register_front",function() {
  jQuery("#grinder_registration_form").validate({
    rules: {
      first_name:{ required:true },
	    last_name:{ required:true },
      grinder_user_id:{ required:true },
      client_email:{ required:true,email:true },
      fitness_goal:{ required:true },
      client_password:{ required:true,minlength:8 },
      client_repassword:{ required:true, equalTo: "#client_password" },
      client_phone:{ required:true,digits: true },
      client_address:{ required:true },
      client_city:{ required:true },
      client_state:{ required:true },
      client_zip:{ required:true,digits: true },
      client_country:{ required:true }
    },
    messages: {
      first_name:{ required:'Please Enter First Name' },
	    last_name:{ required:'Please Enter Last Name' },
      grinder_user_id:{ required:'Please Enter User ID' },
      client_email:{ required:'Please Enter Email', email:'Please Enter Valid Email' },
      fitness_goal:{ required:'Please Enter Bio/Fitness Goal' },
      client_password:{ required:'Please Enter Password',minlength:'Password Must be 8 Characters' },
      client_repassword:{ required:'Please Re-Enter Password', equalTo:'Password Not Matched' },
      client_phone:{ required:'Please Enter Phone No.',digits:'Only Digits Allow' },
      client_address:{ required:'Please Enter Address' },
      client_city:{ required:'Please Enter City' },
      client_state:{ required:'Please Enter State' },
      client_zip:{ required:'Please Enter Zip Code',digits:'Only Digits Allow' },
      client_country:{ required:'Please Enter Country' }
    }
  });

  if(!jQuery("#grinder_registration_form").valid()){
    return false;
  }

  var term_condition = jQuery("#term_condition").prop("checked");
  if(term_condition == false){
    jQuery(".spacial_class").show();
    return false;
  }

  var ct_first_name = jQuery("#first_name").val();
  var ct_last_name = jQuery("#last_name").val();
  var ct_grinder_user_id = jQuery("#grinder_user_id").val();
  var ct_email = jQuery("#client_email").val();
  var ct_fitness_goal = jQuery("#fitness_goal").val();
  var ct_password = jQuery("#client_password").val();
  var ct_phone = jQuery("#client_phone").val();
  var ct_address = jQuery("#client_address").val(); 
  var ct_city = jQuery("#client_city").val();
  var ct_state = jQuery("#client_state").val();
  var ct_zip_code = jQuery("#client_zip").val();         
  var ct_country = jQuery("#client_country").val();
  var fileInput =jQuery("#pcasserviceimage").attr('data-imagename');

  var dataString = {
    "first_name":ct_first_name,
	  "last_name":ct_last_name,
    "grinder_user_id":ct_grinder_user_id,
    "email":ct_email,
    "fitness_goal":ct_fitness_goal,
    "pass":ct_password,
    "phone":ct_phone,
    "address":ct_address,
    "city":ct_city,
    "state":ct_state,
    "zip_code":ct_zip_code,
    "country":ct_country,
    "file" : fileInput,
    action:"pre_client_reg_himself"
  }

  var site_url=siteurlObj.site_url;
  var ajax_url=ajaxurlObj.ajax_url;

  jQuery(".ct-loading-main").show();
  jQuery.ajax({
    type: "post",
    data: dataString,
    url: ajax_url + "admin_login_ajax.php",
    success: function (res) {
      if(res == 1){
        jQuery(".ct-loading-main").hide();
        jQuery("#client_email_exist").hide();
        jQuery("#grinder_user_id_exist").show();
        jQuery("#grinder_user_id").focus();
        return false;
      }else if (res == 2) {
        jQuery(".ct-loading-main").hide();
        jQuery("#grinder_user_id_exist").hide();
        jQuery("#client_email_exist").show();
        jQuery("#client_email").focus();
        return false;
      }

      jQuery(".ct-loading-main").hide();
      jQuery('#thankyouModal').modal('show');

      setTimeout(function() {
        window.location.href = site_url + "admin/";
      }, 2000); 
    }
  }); 
  jQuery(".ct-notifications-inner").addClass("visible");
});

jQuery(document).on("keyup","#grinder_user_id",function() {
  jQuery("#grinder_user_id_exist").hide();
});

jQuery(document).on("keyup","#client_email",function() {
  jQuery("#client_email_exist").hide();
});