var ct_postalcode_status_check = ct_postalcode_statusObj.ct_postalcode_status;

var ct_postalcode_zip_status = ct_postalcode_statusObj.zip_show_status;

var guest_user_status ="off";

var get_all_postal_code = [];

/* front language dropdown show hide list */

jQuery(document).on("click",".select-custom",function() {

  jQuery(".common-selection-main").addClass("clicked");

  jQuery(".custom-dropdown").slideDown();

});

/* front language select on click on custom */

jQuery(document).on("click",".select_custom",function() {

  jQuery("#selected_custom").html(jQuery(this).html());

  jQuery(".common-selection-main").removeClass("clicked");

  jQuery(".custom-dropdown").slideUp();

});

/* tooltipster jquery */

jQuery(document).ready(function() {

  jQuery(document).on("click", "#otp_model_close", function() {

    jQuery('#verify_otp').modal('hide');

    jQuery(".checkmark").hide();

  });



  jQuery(".fancy_input").on("keyup", function() {

    if (jQuery(this).val().length > 0) {

      jQuery(this).parent().addClass("focused_label_wrap");

    } else if (jQuery(this).val().length <= 0) {

      jQuery(this).parent().removeClass("focused_label_wrap");

    }

  });

  jQuery(".phone_no_wrap .fancy_input").on("keyup", function() {

    if (jQuery(this).val().length > 0) {

      jQuery(".phone_no_wrap").addClass("focused_label_wrap");

    } else if (jQuery(this).val().length <= 0) {

      jQuery(".phone_no_wrap").removeClass("focused_label_wrap");

    }

  });

  jQuery(".ct-tooltip").tooltipster({

    animation: "grow",

    delay: 20,

    theme: "tooltipster-shadow",

    trigger: "hover"

  });

  jQuery(".ct-tooltipss").tooltipster({

    animation: "grow",

    delay: 20,

    theme: "tooltipster-shadow",

    trigger: "hover"

  });

  jQuery(".ct-tooltip-services").tooltipster({

    animation: "grow",

    side: "bottom",

    interactive : "true",

    theme: "tooltipster-shadow",

    trigger: "hover",

    delayTouch : 300,

    maxWidth:400,

    functionPosition: function(instance, helper, position){

      position.coord.top -= 25;

      return position;

    },

    contentAsHTML : "true"

  });



  jQuery(".ct-tooltip-services-addons").tooltipster({

    animation: "grow",

    side: "bottom",

    interactive : "true",

    theme: "tooltipster-shadow",

    trigger: "hover",

    delayTouch : 300,

    maxWidth:400,

    functionPosition: function(instance, helper, position){

      position.coord.top -= 25;

      return position;

    },

    contentAsHTML : "true"

  });



  

  /* card payment validations */

  jQuery("input.cc-number").payment("formatCardNumber");

  jQuery("input.cc-cvc").payment("formatCardCVC");  

  jQuery("input.cc-exp-month").payment("restrictNumeric");

  jQuery("input.cc-exp-year").payment("restrictNumeric");

  jQuery("body").niceScroll();

  jQuery(".common-data-dropdown").niceScroll();

  jQuery(".ct-services-dropdown").niceScroll();

  var frequently_discount_id=jQuery("input[name=frequently_discount_radio]:checked").attr("data-id");

  var frequently_discount_name=jQuery("input[name=frequently_discount_radio]:checked").attr("data-name");

  if(frequently_discount_id == 0){

    jQuery(".f_dis_img").hide();

  }else{

    jQuery(".f_dis_img").show();

    jQuery(".f_discount_name").text(frequently_discount_name);

  }

  jQuery(".ct-loading-main").hide();

    var subheader_status=subheaderObj.subheader_status;

    if(subheader_status == "Y"){

      jQuery(".ct-sub").show();

    }else{

      jQuery(".ct-sub").hide();

    }

  if(ct_postalcode_status_check == "Y"){

    jQuery(".ct_remove_id").attr("id","");

    jQuery(document).on("click",".ct_remove_id",function(){

      jQuery("#ct_postal_code").focus();

      jQuery("#ct_postal_code").keyup();

    });

  }

  jQuery(".ct-sub").show();

  jQuery(".ct-loading-main-complete_booking").hide();

  jQuery(".remove_guest_user_preferred_email").hide();

  jQuery(".show_methods_after_service_selection").hide();

  jQuery(".freq_discount_display").hide();

  jQuery(".hide_allsss_addons").hide();

  jQuery(".partial_amount_hide_on_load").hide();

  jQuery(".hide_right_side_box").hide();

  jQuery(".client_logout").hide();

  jQuery(".postal_code_error").show();

  jQuery(".postal_code_error").html(errorobj_please_enter_postal_code);

  jQuery(".hideservice_name").hide();

  jQuery(".hidedatetime_value").hide();

  jQuery(".hideduration_value").hide();

  jQuery(".s_m_units_design_1").hide();

  jQuery(".s_m_units_design_2").hide();

  jQuery(".s_m_units_design_3").hide();

  jQuery(".s_m_units_design_4").hide();

  jQuery(".s_m_units_design_5").hide();

  jQuery(".ct-provider-list").hide();

  /*Coupon Apply*/

  jQuery(".ct-display-coupon-code").hide();

  jQuery(".coupon_display").hide();



  /* Jay */

  jQuery(".user_coupon_display").hide();

  jQuery(".ct-display-user-coupon-code").hide();

  /* */



  /* Jay */

  jQuery(".ct-display-referral-code").hide();

  /* */



  /* user contact no. */

  var site_url=siteurlObj.site_url;

  var country_alpha_code = countrycodeObj.alphacode;

  var allowed_country_alpha_code = countrycodeObj.allowed;

  var array = allowed_country_alpha_code.split(",");

  var phone_visi = phone_status.statuss;

  if(phone_visi == "on"){

    if(allowed_country_alpha_code = ""){

      jQuery("#ct-user-phone").intlTelInput({

        onlyCountries: array,

        autoPlaceholder: false,

        utilsScript: site_url+"assets/js/utils.js"

      });

      jQuery(".selected-flag .iti-flag").addClass(country_alpha_code);

      jQuery(".selected-flag").attr("title",countrycodeObj.countrytitle);

    } else {

      jQuery("#ct-user-phone").intlTelInput({

        autoPlaceholder: false,

        utilsScript: site_url+"assets/js/utils.js"

      });

      jQuery(".selected-flag .iti-flag").addClass(country_alpha_code);

      jQuery(".selected-flag").attr("title",countrycodeObj.countrytitle);

    }

  }

  /*  create the back to top button */

  jQuery("body").prepend('<a href="javascript:void(0)" class="ct-back-to-top"></a>');

  var amountScrolled = 500;

  jQuery(window).scroll(function() {

    if ( jQuery(window).scrollTop() > amountScrolled ) {

      jQuery("a.ct-back-to-top").fadeIn("slow");

    } else {

      jQuery("a.ct-back-to-top").fadeOut("slow");

    }

  });

  jQuery("a.ct-back-to-top, a.ct-simple-back-to-top").click(function() {

    jQuery("html, body").animate({ scrollTop: 0 }, 2000);

    return false;

  });

  var password_check = check_password;

  jQuery("#user_login_form").validate({

    rules: {

      ct_user_name:{ required:true,email:true},

      ct_user_pass:{ required: true,minlength:password_check.min,maxlength:password_check.max}

    },

    messages: {

      ct_user_name:{ required:errorobj_please_enter_email_address,email : errorobj_please_enter_valid_email_address},

      ct_user_pass:{ required: errorobj_please_enter_password, minlength:errorobj_min_ps, maxlength:errorobj_max_ps}

    }

  });

  var front_url=fronturlObj.front_url;

  jQuery.validator.addMethod("pattern_phone", function(value, element) {

    return this.optional(element) || /^[0-9+]*$/.test(value);

  }, "Enter Only Numerics");

  jQuery.validator.addMethod("pattern_zip", function(value, element) {

    return this.optional(element) || /^[a-zA-Z 0-9\-\ ]*$/.test(value);

  }, "Enter Only Alphabets");

  jQuery.validator.addMethod("pattern_name", function(value, element) {

    return this.optional(element) || /^[a-zA-Z ']+$/.test(value);

  }, "Enter Only Alphabets");

  jQuery.validator.addMethod("pattern_city_state", function(value, element) {

    return this.optional(element) || /^[a-zA-Z &]+$/.test(value);

  }, "Enter Only Alphabets");

  var phone_check =phone_status;

  var password_check =check_password;

  var fn_check =check_fn;

  var ln_check =check_ln;

  var address_check =check_addresss;

  var zip_check =check_zip_code;

  var city_check =check_city;

  var state_check =check_state;

  var notes_check =check_notes;

  /* validaition condition*/

  jQuery("#user_details_form").validate();

  if(appoint_details.status == "on"){

    if(check_addresss.statuss=="on" &&  check_addresss.required=="Y"){ 

      jQuery("#app-street-address").rules("add", 

      { required: true,minlength:check_addresss.min,maxlength:check_addresss.max,

      messages: { required: errorobj_req_sa, minlength:errorobj_min_sa, maxlength:errorobj_max_sa}});

    }

    if(check_zip_code.statuss=="on" &&  check_zip_code.required=="Y"){ 

      jQuery("#app-zip-code").rules("add", { required: true,minlength:check_zip_code.min,maxlength:check_zip_code.max, messages: { required: errorobj_req_zc, minlength:errorobj_min_zc, maxlength:errorobj_max_zc}});

    }

    if(check_city.statuss=="on" &&  check_city.required=="Y"){ 

      jQuery("#app-city").rules("add", 

      { required: true,minlength:check_city.min,maxlength:check_city.max,

      messages: { required: errorobj_req_ct, minlength:errorobj_min_ct, maxlength:errorobj_max_ct}});

    }

    if(check_state.statuss=="on" &&  check_state.required=="Y"){ 

      jQuery("#app-state").rules("add", 

      { required: true,minlength:check_state.min,maxlength:check_state.max,

      messages: { required: errorobj_req_st, minlength:errorobj_min_st, maxlength:errorobj_max_st

      }});

    }

  }

  if(fn_check.statuss=="on" &&  fn_check.required=="Y"){ 

    jQuery("#ct-first-name").rules("add", 

    { required: true,minlength:fn_check.min,maxlength:fn_check.max,pattern_name:true,

    messages: { required: errorobj_req_fn, minlength:errorobj_min_fn, maxlength:errorobj_max_fn}});

  }

  if(ln_check.statuss=="on" &&  ln_check.required=="Y"){ 

    jQuery("#ct-last-name").rules("add", 

    { required: true,minlength:ln_check.min,maxlength:ln_check.max,pattern_name:true,

    messages: { required: errorobj_req_ln, minlength:errorobj_min_ln, maxlength:errorobj_max_ln}});

  }

  if(phone_check.statuss=="on" &&  phone_check.required=="Y"){ 

    jQuery("#ct-user-phone").rules("add", 

    { required: true,minlength:phone_check.min,maxlength:phone_check.max,

    messages: { required: errorobj_req_ph, minlength:errorobj_min_ph, maxlength:errorobj_max_ph}});

  }

  if(address_check.statuss=="on" &&  address_check.required=="Y"){ 

    jQuery("#ct-street-address").rules("add", 

    { required: true,minlength:address_check.min,maxlength:address_check.max,

    messages: { required: errorobj_req_sa, minlength:errorobj_min_sa, maxlength:errorobj_max_sa}});

  }

  if(zip_check.statuss=="on" &&  zip_check.required=="Y"){ 

    jQuery("#ct-zip-code").rules("add", 

    { required: true,minlength:zip_check.min,maxlength:zip_check.max,

    messages: { required: errorobj_req_zc, minlength:errorobj_min_zc, maxlength:errorobj_max_zc}});

  }

  if(city_check.statuss=="on" &&  city_check.required=="Y"){ 

    jQuery("#ct-city").rules("add", 

    { required: true,minlength:city_check.min,maxlength:city_check.max,

    messages: { required: errorobj_req_ct, minlength:errorobj_min_ct, maxlength:errorobj_max_ct}});

  }

  if(state_check.statuss=="on" &&  state_check.required=="Y"){ 

    jQuery("#ct-state").rules("add", 

    { required: true,minlength:state_check.min,maxlength:state_check.max,

    messages: { required: errorobj_req_st, minlength:errorobj_min_st, maxlength:errorobj_max_st}});

  }

  if(notes_check.statuss=="on" &&  notes_check.required=="Y"){ 

    jQuery("#ct-notes").rules("add", 

    { required: true,minlength:notes_check.min,maxlength:notes_check.max,

    messages: { required: errorobj_req_srn, minlength:errorobj_min_srn, maxlength:errorobj_max_srn}});

  }

  if(password_check.statuss=="on" &&  password_check.required=="Y"){

    jQuery("#ct-preffered-pass").rules("add", 

    { required: true,minlength:password_check.min,maxlength:password_check.max,

    messages: { required: errorobj_please_enter_password, minlength:errorobj_min_ps, maxlength:errorobj_max_ps}});

    

    jQuery("#ct-email").rules("add", 

    { required:true, email:true, remote: {

      url:front_url+"firststep.php",

      type: "POST",

      async:false,

      data: {

        email: function(){ return jQuery("#ct-email").val(); },

        action:"check_user_email"

      }

    },

    messages: { required:errorobj_please_enter_email_address,email: errorobj_please_enter_valid_email_address,remote: errorobj_email_already_exists}});

  }

  /* end validaition condition*/

  if(jQuery(".guest-user").is(":checked")) {

    jQuery("#ct-email-guest").val("");

    jQuery("#ct-user-name").val("");

    jQuery("#ct-user-pass").val("");

    jQuery("#ct-preffered-name").val("");

    jQuery("#ct-preffered-pass").val("");

    jQuery("#ct-first-name").val("");

    jQuery("#ct-last-name").val("");

    jQuery("#ct-email").val("");

    jQuery("#ct-user-phone").val("");

    jQuery("#ct-street-address").val("");

    jQuery("#ct-zip-code").val("");

    jQuery("#ct-city").val("");

    jQuery("#ct-state").val("");

    jQuery("#ct-notes").val("");

    jQuery(".ct-new-user-details").show( "blind", {direction: "vertical"}, 700);

    jQuery(".ct-login-existing").hide( "blind", {direction: "vertical"}, 300);

    jQuery(".ct-peronal-details").show( "blind", {direction: "vertical"}, 300);

    jQuery(".remove_preferred_password_and_preferred_email").hide( "blind", {direction: "vertical"}, 300);    

    jQuery(".remove_guest_user_preferred_email").show( "blind", {direction: "vertical"}, 300);

    if(jQuery( ".remove_zip_code_class" ).hasClass( "ct-md-4" )){

      jQuery(".remove_zip_code_class").removeClass("ct-md-4");

      jQuery(".remove_zip_code_class").addClass("ct-md-6");

    }

    if(jQuery( ".remove_city_class" ).hasClass( "ct-md-4" )){

      jQuery(".remove_city_class").removeClass("ct-md-4");

      jQuery(".remove_city_class").addClass("ct-md-6");

    }

    if(jQuery( ".remove_state_class" ).hasClass( "ct-md-4" )){

      jQuery(".remove_state_class").removeClass("ct-md-4");

      jQuery(".remove_state_class").addClass("ct-md-6");

    }

    guest_user_status ="on";

  }

  jQuery(".space_between_date_time").hide();

  jQuery(".special_day").hide();                           

  var site_url=siteurlObj.site_url;

  var ajax_url=ajaxurlObj.ajax_url;

  jQuery.ajax({

    type:"POST",

    url: ajax_url+"calendar_ajax.php",

    data : { "get_calendar_on_page_load" : 1 },

    success: function(res){

      jQuery(".cal_info").html(res);

      var d = new Date();

      var month = d.getMonth()+1;

      var day = d.getDate();

      var year = d.getFullYear();

      var output = day + "-" +(month<10 ? "0" : "") + month + "-" +  year;

      var selected_dates = jQuery(".selected_date").data("selected_dates");

      var cur_dates = jQuery(".selected_date").data("cur_dates");

      if(output == cur_dates){

        jQuery(".by_default_today_selected").addClass("active_today");

      }

      cleanto_sidebar_scroll();

    }

  });

  jQuery.ajax({

    type:"POST",

    url: ajax_url+"front_ajax.php",

    data : { "get_postal_code" : 1 },

    success: function(res){

      get_all_postal_code = jQuery.parseJSON(res);

    }

  });

  /* validation for reset_password.php */

  jQuery("#forget_pass").submit(function(event){

    event.preventDefault();

    event.stopImmediatePropagation();

  });

  jQuery("#forget_pass").validate({

    rules: {

      rp_user_email: {

        required: true,

        email: true,

      }

    },

    messages:{

      rp_user_email: {

        required : errorobj_please_enter_email_address,

        email : errorobj_please_enter_valid_email_address

      },

    }

  });

  /* validation for reset_new_password.php */

  jQuery("#reset_new_passwd").submit(function(event){

    event.preventDefault();

    event.stopImmediatePropagation();

  });

  jQuery.validator.addMethod("noSpace", function(value, element) {

    return value.indexOf(" ") < 0 && value != "";

  }, "No space allowed");

  jQuery("#reset_new_passwd").validate({

    rules: {

      n_password: {

        required: true,

        minlength: 8,

        maxlength: 20,

        noSpace: true

      },

      rn_password: {

        required: true,

        minlength: 8,

        maxlength: 20,

        noSpace: true

      }

    },

    messages:{

      n_password: {

        required : errorobj_please_enter_new_password,

        minlength: errorobj_password_must_be_8_character_long,

        maxlength: "Password Must Be Only 20 Characters"

      },

      rn_password: {

        required: errorobj_please_enter_confirm_password,

        minlength: errorobj_password_must_be_8_character_long,

        maxlength: "Password Must Be Only 20 Characters"

      },

    }

  });

  var front_url=fronturlObj.front_url;

  jQuery.ajax({

    type : "post",

    data: { check_for_option : 1 },

    url : front_url+"firststep.php",

    success : function(res){      

      if(jQuery.trim(res) != ""){

        window.location=front_url+"maintainance.php";

      }

    }

  });

  jQuery('[data-toggle="tooltip"]').tooltip({"placement": "right"});

  if(is_login_user == "Y"){

    var site_url=siteurlObj.site_url;

    var ajax_url=ajaxurlObj.ajax_url;

    jQuery(".add_show_error_class_for_login").each(function(){

      jQuery(this).trigger("keyup");

    });

    jQuery(".add_show_error_class").each(function(){

      var id = jQuery(this).attr("id");

      jQuery( this ).removeClass("error");

      jQuery( "#"+id ).parent().removeClass("error");

      jQuery( this ).removeClass("show-error");

      jQuery( "#"+id ).parent().removeClass("show-error");

      jQuery( ".intl-tel-input" ).parent().removeClass("show-error");

    });

    var existing_username = jQuery("#ct-user-name").val();

    var existing_password = jQuery("#ct-user-pass").val();

    if(!jQuery("#user_login_form").valid()){ return false; }

    dataString={action:"get_login_user_data"};

    jQuery.ajax({

      type:"POST",

      url:ajax_url+"front_ajax.php",

      data:dataString,

      success:function(response){

        var userdata=jQuery.parseJSON(response);

        if(userdata.status == "No Login"){

          is_login_user = "N";

          jQuery(".fancy_input").each(function(){jQuery(this).trigger("keyup");});

          return false;

        }else if(userdata.status == "Incorrect Email Address or Password"){

          is_login_user = "N";

          jQuery(".fancy_input").each(function(){jQuery(this).trigger("keyup");});

          return false;

        }else{

          is_login_user = "Y";

          jQuery("#check_login_click").val("clicked");

          jQuery(".client_logout").css("display","block");

          jQuery(".client_logout").show();

          jQuery(".fname").text(userdata.firstname);

          jQuery(".lname").text(userdata.lastname);

          jQuery("#ct-email").val(userdata.email);

          jQuery("#ct-user-name").val(userdata.email);

          jQuery("#existing-user").attr("checked", true);

          jQuery(".hide_login_btn").hide();

          jQuery(".hide_radio_btn_after_login").hide();

          jQuery(".hide_email").hide();

          jQuery(".hide_login_email").hide();

          jQuery(".hide_password").hide();

          jQuery(".ct-peronal-details").show();

          jQuery(".login_unsuccessfull").hide();

          jQuery(".ct-new-user-details").hide();

          jQuery(".ct-sub").hide();

          jQuery("#ct-first-name").val(userdata.firstname);

          jQuery("#ct-last-name").val(userdata.lastname);

          jQuery("#ct-user-phone").intlTelInput("setNumber", userdata.phone);

          if(check_addresss.statuss=="on"){ jQuery("#ct-street-address").val(userdata.address); }

          if(check_zip_code.statuss=="on"){  jQuery("#ct-zip-code").val(userdata.zip); }

          if(check_city.statuss=="on"){  jQuery("#ct-city").val(userdata.city); }

          if(check_state.statuss=="on"){  jQuery("#ct-state").val(userdata.state); }

          jQuery("#ct-notes").val(userdata.notes);

          if(userdata.vc_status == "N"){

            jQuery("#vaccum-no").attr("checked", true);

          }else{

            jQuery("#vaccum-yes").attr("checked", true);

          }

          if(userdata.p_status == "N"){

            jQuery("#parking-no").attr("checked", true);

          }else{

            jQuery("#parking-yes").attr("checked", true);

          }

          var con_staatus = userdata.contact_status;

          if(con_staatus == "I'll be at home" || con_staatus == "Please call me" || con_staatus == "The key is with the doorman"){

            jQuery("#contact_status").val(userdata.contact_status);

          }else{

            jQuery("#contact_status").val("Other");

            jQuery(".ct-option-others").show();

            jQuery("#other_contact_status").val(userdata.contact_status);

          }

          jQuery(".fancy_input").each(function(){jQuery(this).trigger("keyup");});

        }

      }

    });

  }

});





/* scroll to next step */

jQuery(document).on("click",".ct-service",function() {

  jQuery("html, body").stop().animate({ "scrollTop": jQuery(".ct-scroll-meth-unit").offset().top - 30 }, 800, "swing", function () {});

});

/* forget password */

jQuery(document).on("click","#ct_forget_password",function() {

  jQuery("#rp_user_email").val("");

  jQuery(".forget_pass_correct").hide();

  jQuery(".forget_pass_incorrect").hide();

  jQuery(".ct-front-forget-password").addClass("show-data");

  jQuery(".ct-front-forget-password").removeClass("hide-data");

  jQuery(".main").css("display", "block");

});

jQuery(document).on("click","#ct_login_user",function() {

  jQuery(".ct-front-forget-password").removeClass("show-data");

  jQuery(".ct-front-forget-password").addClass("hide-data");

  jQuery(".main").css("display", "none");

});

/* dropdown services list */

/* services dropdown show hide list */

jQuery(document).on("click",".service-is",function() {

  jQuery(".ct-services-dropdown").toggle( "blind", {direction: "vertical"}, 300 );

});

jQuery(document).on("click",".select_service",function() {

  jQuery("#ct_selected_service").html(jQuery(this).html());

  jQuery(".ct-services-dropdown").hide( "blind", {direction: "vertical"}, 300 );

});

/* select hours based service */

jQuery(document).on("click",".ct-duration-btn",function() {

  jQuery(".ct-duration-btn").each(function(){

    jQuery(this).removeClass("duration-box-selected");

  });

  jQuery(this).addClass("duration-box-selected");

});

/* for show how many addon counting when checked */

jQuery(document).on("click",'input[type="checkbox"]',function() {

  

  if(jQuery(".addon-checkbox").is(":checked")) {

    jQuery(".common-selection-main.addon-select").show();

  } else {

    jQuery(".common-selection-main.addon-select").hide();

  }

});

/* addons */

jQuery(document).on("click",".ct-addon-btn",function() {

  var curr_methodname = jQuery(this).attr("data-method_name");

  jQuery(".ct-addon-btn").each(function(){

    if(jQuery(this).attr("data-method_name") == curr_methodname){

      jQuery(this).removeClass("ct-addon-selected");

    }

  });

  jQuery(this).addClass("ct-addon-selected");

});

/* checkout payment method listing show hide */

jQuery(document).on("click",".cccard",function() {

  var test = jQuery(this).val();

  jQuery(".common-payment-style").show("blind", {direction: "vertical"}, 300);

});

jQuery(document).on("click","input[name=payment-methods]",function() {

  var abc = jQuery(this).val();

  if (abc == 'braintree') {
    jQuery('#braintree-payment-form').show();
    jQuery('#ct-complete-booking-main').hide();
  }else{
    jQuery('#braintree-payment-form').hide();
    jQuery('#ct-complete-booking-main').show();
  }

  if(jQuery(this).hasClass("cccard")) {

    jQuery(".common-payment-style-bank-transfer").hide();

    jQuery(".partial_amount_hide_on_load").hide();

    jQuery("#wallet").removeAttr('checked');

  } else if(jQuery(this).hasClass("pay-cash")){

    jQuery(".common-payment-style").hide();

    jQuery(".common-payment-style-bank-transfer").hide();

    jQuery(".partial_amount_hide_on_load").hide();

    jQuery("#wallet").removeAttr('checked');

  } else {

    jQuery(".common-payment-style").hide();

    jQuery(".common-payment-style-bank-transfer").hide();

    jQuery(".partial_amount_hide_on_load").hide();

    jQuery("#pay-cash").removeAttr('checked');

    jQuery("#pay-card").removeAttr('checked');

  }

});



/* bank transfer */

jQuery(document).on("click",".bank_transfer",function() {

  jQuery(".common-payment-style-bank-transfer").show("blind", {direction: "vertical"}, 300);

  jQuery("#wallet").removeAttr('checked');

});

jQuery(document).on("click","input[name=payment-methods]",function() {

  if(jQuery(this).hasClass("bank_transfer")) {

    jQuery(".common-payment-style").hide();

  } else {

    jQuery(".common-payment-style-bank-transfer").hide();

  }

});

/* see more instructions in service popup */

jQuery(document).on("click",".show-more-toggler",function() {

  jQuery(".bullet-more").toggle( "blind", {direction: "vertical"}, 500);

  jQuery(".show-more-toggler:after").addClass("rotate");

});

/* right side scrolling cart */

var scrollable_cart_value=scrollable_cartObj.scrollable_cart;

if(scrollable_cart_value == "Y"){

  function cleanto_sidebar_scroll(){

    var $sidebar   = jQuery(".ct-price-scroll"),

      $window    = jQuery(window),

      offset     = $sidebar.offset(),

      sel_service = jQuery(".sel-service").text();

      

    if(sel_service != ""){

      $window.scroll(function() {

        if(offset.top > $window.scrollTop()){

          $sidebar.stop().animate({

            marginTop: 20

          });

        }else{

          $sidebar.stop().animate({

            marginTop: ($window.scrollTop() - offset.top) + 40

          });

        }

      });

    }else{

      $window.scroll(function() {

        if(offset.top > $window.scrollTop()){

          $sidebar.stop().animate({

            marginTop: 20

          });

        }else{

          $sidebar.stop().animate({

            marginTop: ($window.scrollTop() - offset.top) + 20

          });

        }

      });

    }

  }

}else{

  function cleanto_sidebar_scroll(){}

}

/************* Code by developer side --- ****************/

jQuery(document).on("keyup keydown blur",".add_show_error_class",function(event){

  var id = jQuery(this).attr("id");

  var Number = /(?:\(?\+\d{2}\)?\s*)?\d+(?:[ -]*\d+)*$/;

  if(jQuery(this).hasClass("error")){

    jQuery( this ).removeClass("error");

    jQuery( "#"+id ).parent().removeClass("error");

    jQuery( this ).addClass("show-error");

    jQuery( "#"+id ).parent().addClass("show-error");

    if(jQuery("#ct-user-phone").val() != ""){

      if(!jQuery("#ct-user-phone").val().match(Number)){

        jQuery( ".intl-tel-input" ).parent().addClass("show-error");

      }

    }

  }else{

    jQuery( this ).removeClass("error");

    jQuery( "#"+id ).parent().removeClass("error");

    jQuery( this ).removeClass("show-error");

    jQuery( "#"+id ).parent().removeClass("show-error");

    if(jQuery("#ct-user-phone").val() != ""){

      if(jQuery("#ct-user-phone").val().match(Number)){

        jQuery( ".intl-tel-input" ).parent().removeClass("show-error");

      }

    }

  }

});

jQuery(document).on("keyup keydown blur",".add_show_error_class_for_login",function(event){

  var id = jQuery(this).attr("id");

  if(jQuery(this).hasClass("error")){

    jQuery( this ).removeClass("error");

    jQuery( "#"+id ).parent().removeClass("error");

    jQuery( this ).addClass("show-error");

    jQuery( "#"+id ).parent().addClass("show-error");

  }else{

    jQuery( this ).removeClass("error");

    jQuery( "#"+id ).parent().removeClass("error");

    jQuery( this ).removeClass("show-error");

    jQuery( "#"+id ).parent().removeClass("show-error");

  }

});

jQuery(document).ready(function(){

  var two_checkout_status = twocheckout_Obj.twocheckout_status;

  if(two_checkout_status == "Y"){

    TCO.loadPubKey("sandbox");

  }

});

var clicked = false;

jQuery(document).ready(function () {

  jQuery(document).on("change","#recurrence-booking",function () {

    var recurrence_booking = jQuery("#recurrence-booking").prop("checked");

    if(recurrence_booking == true){

      jQuery(".recurrence_type_dropdown").show();

      jQuery(".recurrence_type_dropdown").show();

    } else{

      jQuery(".recurrence_type_dropdown").hide();

      jQuery(".recurrence_type_dropdown").hide();

    }

  });

});

jQuery(document).on("click",".ct-provider-img",function(e){
    jQuery(".date_time_error1").hide();
});


jQuery(document).on("click","#complete_bookings",function(e){

  var site_url=siteurlObj.site_url;

  var ajax_url=ajaxurlObj.ajax_url;

  var front_url=fronturlObj.front_url;

  var stripe_pubkey = baseurlObj.stripe_publishkey;

  var stripe_status = baseurlObj.stripe_status;   

  if(stripe_status=="on"){  Stripe.setPublishableKey(stripe_pubkey);  }

  var terms_condition_setting_value=termsconditionObj.terms_condition;

  var privacy_policy_setting_value=privacypolicyObj.privacy_policy;

  var thankyou_page_setting_value=thankyoupageObj.thankyou_page;

  var existing_username = jQuery("#ct-user-name").val();

  var existing_password = jQuery("#ct-user-pass").val();

  var password = jQuery("#ct-preffered-pass").val();

  var firstname = jQuery("#ct-first-name").val();

  var lastname = jQuery("#ct-last-name").val();

  var email = "";

  if(guest_user_status == "on"){

    email = jQuery("#ct-email-guest").val();

  }else{

    if(is_login_user == "Y"){

      email = existing_username;

    }else{

      email = jQuery("#ct-email").val();

    }

  }

  var phone = jQuery("#ct-user-phone").val();

  /***newly added start***/

  var user_address = jQuery("#ct-street-address").val();

  var user_zipcode = jQuery("#ct-zip-code").val();

  var user_city = jQuery("#ct-city").val();

  var user_state = jQuery("#ct-state").val();

  if(appoint_details.status == "on"){

    if(check_addresss.status="on"){ var address = jQuery("#app-street-address").val(); }

    else { var address = jQuery("#ct-street-address").val(); }

    if(check_zip_code.status="on"){ var zipcode = jQuery("#app-zip-code").val(); }

    else { var zipcode = jQuery("#ct-zip-code").val(); }

    if(check_city.status="on"){ var city = jQuery("#app-city").val(); }

    else { var city = jQuery("#ct-city").val(); }

    if(check_state.status="on"){ var state = jQuery("#app-state").val(); }

    else { var state = jQuery("#ct-state").val(); }

  }

  else {

    var address = jQuery("#ct-street-address").val();

    var zipcode = jQuery("#ct-zip-code").val();

    var city = jQuery("#ct-city").val();

    var state = jQuery("#ct-state").val();

  }

  var notes = jQuery("#ct-notes").val();

  var payment_method = jQuery(".payment_gateway:checked").val();
  /** new **/

  var staff_id = jQuery(".provider_disable:checked").attr("data-staff_id");


  if(staff_id == undefined){

    var staff_id = "";

  } else {

    var staff_id = staff_id;

  }

  var v_c_status = jQuery(".vc_status").prop("checked");

  var vc_status = "";

   if(v_c_status == undefined){

    vc_status = "-";

  }else{

    if(v_c_status == true){ vc_status = "Y"; }else{ vc_status = "N"; }

  }

  var prkng_status = jQuery(".p_status").prop("checked");

  var p_status = "";

  if(prkng_status == undefined){

    p_status = "-";

  }else{

    if(prkng_status == true){ p_status = "Y"; }else{ p_status = "N"; }

  }

  var con_status = jQuery("#contact_status").val();

  var contact_status = "";

  if(con_status == "Other"){

    contact_status = jQuery("#other_contact_status").val();

  }else if(con_status == undefined){

    contact_status = "";

  }

  else{

    contact_status = jQuery("#contact_status").val();

  }

  var terms_condition = jQuery("#accept-conditions").prop("checked");

  var tc_check="N";

  if(terms_condition_setting_value == "Y" || privacy_policy_setting_value == "Y"){

    if(terms_condition == true){

      tc_check="Y";

    }

  }else{

    tc_check="Y";

  }

  var booking_date_text = jQuery(".cart_date").text();

  var booking_date = jQuery(".cart_date").attr("data-date_val");

  var booking_time = jQuery(".cart_time").attr("data-time_val");

  var booking_time_text = jQuery(".cart_time").text();

  var booking_date_time = booking_date+" "+booking_time;

  var currency_symbol = jQuery(this).attr("data-currency_symbol");

  var cart_sub_total=jQuery(".cart_sub_total").text();

  var amount = cart_sub_total.replace(currency_symbol, "");

  var cart_discount=jQuery(".cart_discount").text().substring(2);

  var discount = cart_discount.replace(currency_symbol, "");

  var cart_tax=jQuery(".cart_tax").text();

  var taxes = cart_tax.replace(currency_symbol, "");

  var cart_special_days=jQuery(".cart_special_days").text();

  var special_days = cart_special_days.replace(currency_symbol, "");

  var partialamount=jQuery(".partial_amount").text();

  var partial_amount = partialamount.replace(currency_symbol, "");

  var cart_total=jQuery(".cart_total").text();

  var net_amount = cart_total.replace(currency_symbol, "");

  

  if(net_amount<minimum_booking_price){

    jQuery(".minimum_price_show").css("display","block"); 

    return false;

  }else{

    jQuery(".minimum_price_show").css("display","none");

  }



  if(payment_method=="Wallet-payment"){

    var current_amount = jQuery('#wallet').attr('data-wallet');

  }else{

    var current_amount = "";

  }



  var cart_counting = jQuery("#total_cart_count").val();

  var coupon_code=jQuery("#coupon_val").val();

  var user_coupon_val=jQuery("#user_coupon_val").val();

  var frequently_discount_id=jQuery("input[name=frequently_discount_radio]:checked").attr("data-id");

  var frequent_discount_amount = 0;

  var recurrence_booking_1 = "N";

  if(frequently_discount_id != "1"){

    recurrence_booking_1 ="Y";

    var frequent_discount_text=jQuery(".frequent_discount").text();

    frequent_discount_amount = frequent_discount_text.replace(currency_symbol, "");

  }

  var no_units_in_cart_err= jQuery("#no_units_in_cart_err").val();

  var no_units_in_cart_err_count= jQuery("#no_units_in_cart_err_count").val();

  var cc_card_num = jQuery(".cc-number").val();

  var cc_exp_month = jQuery(".cc-exp-month").val();

  var cc_exp_year = jQuery(".cc-exp-year").val();

  var cc_card_code = jQuery(".cc-cvc").val();

  var braintree_nonce = jQuery("#nonce").val();

  dataString={braintree_nonce:braintree_nonce,existing_username:existing_username,existing_password:existing_password,password:password,firstname:firstname,lastname:lastname,email:email,phone:phone,user_address:user_address,user_zipcode:user_zipcode,user_city:user_city,user_state:user_state,address:address,zipcode:zipcode,city:city,state:state,notes:notes,vc_status:vc_status,p_status:p_status,contact_status:contact_status,payment_method:payment_method,staff_id:staff_id,amount:amount,discount:discount,taxes:taxes,partial_amount:partial_amount,net_amount:net_amount,booking_date_time:booking_date_time,frequently_discount:frequently_discount_id,frequent_discount_amount:frequent_discount_amount,coupon_code:coupon_code,user_coupon_val:user_coupon_val,cc_card_num:cc_card_num,cc_exp_month:cc_exp_month,cc_exp_year:cc_exp_year,cc_card_code:cc_card_code,guest_user_status:guest_user_status,recurrence_booking:recurrence_booking_1,current_amount:current_amount,is_login_user:is_login_user,special_days:special_days,action:"complete_booking"};
  
  if(jQuery("#user_details_form").valid()){

    if(jQuery("input[name='service-radio']:checked").val() != "on" && jQuery("#ct-service-0").val() != "off" && cart_counting == 1){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".service_not_selected_error").css("display","block");

      jQuery(".service_not_selected_error").css("color","red");

      jQuery(".service_not_selected_error").html(errorobj_please_select_a_service);

      jQuery(this).attr("href","#service_not_selected_error");

      /*}*/

    }else if(jQuery(".ser_name_for_error").text() == "Cleaning Service" && cart_counting == 1){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".service_not_selected_error_d2").css("color","red");

      jQuery(".service_not_selected_error_d2").html(errorobj_please_select_a_service);

      jQuery(this).attr("href","#service_not_selected_error_d2");

    }else if(jQuery("#ct_selected_servic_method .service-method-name").text() == "Service Usage Methods" && cart_counting == 1){

      clicked=false;

      jQuery(".method_not_selected_error").css("display","block");

      jQuery(".method_not_selected_error").css("color","red");

      jQuery(".method_not_selected_error").html("Please Select Method");

      jQuery(this).attr("href","#method_not_selected_error");

    }else if(cart_counting == 1){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".empty_cart_error").css("display","block");

      jQuery(".empty_cart_error").css("color","red");

      jQuery(".empty_cart_error").html(errorobj_please_select_units_or_addons);

      jQuery(this).attr("href","#empty_cart_error");

    

    }else if(staff_id < 0 || staff_id == ""){
      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".date_time_error1").css("display","block");
     
      jQuery(".date_time_error1").css("color","red");

      jQuery(".date_time_error1").html("Please select trainer");

      jQuery(this).attr("href","#date_time_error_id1");
    }else if(booking_date_text == "" && booking_time_text == ""){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".date_time_error").css("display","block");

      jQuery(".date_time_error").css("color","red");

      jQuery(".date_time_error").html(errorobj_please_select_appointment_date);

      jQuery(this).attr("href","#date_time_error_id");

    }else if(no_units_in_cart_err == "units_and_addons_both_exists" && no_units_in_cart_err_count == "unit_not_added"){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".no_units_in_cart_error").show();

      jQuery(".no_units_in_cart_error").css("color","red");

      jQuery(".no_units_in_cart_error").html(errorobj_please_select_atleast_one_unit);

      jQuery(this).attr("href","#no_units_in_cart_error");

    }else if(jQuery("#check_login_click").val() == "not" && jQuery("#existing-user").prop("checked") == true){

      clicked=false;

      jQuery(".ct-loading-main-complete_booking").hide();

      jQuery(".login_unsuccessfull").css("display","block");

      jQuery(".login_unsuccessfull").css("color","red");

      jQuery(".login_unsuccessfull").css("margin-left","15px");

      jQuery(".login_unsuccessfull").html(errorobj_please_login_to_complete_booking);

      jQuery(this).attr("href","#login_unsuccessfull");

    }else{

      if(tc_check=="Y"){

        if(clicked===false){

          jQuery(this).attr("href","javascript:void(0);");

          clicked=true;

          if(payment_method == "paypal"){

            jQuery(".ct-loading-main-complete_booking").show();

            jQuery.ajax({

              type:"POST",

              url:front_url+"checkout.php",

              data:dataString,

              success:function(response){

                var response_detail = jQuery.parseJSON(response);

                if(response_detail.status=="success"){

                  jQuery(".ct-loading-main-complete_booking").hide();

                  window.location = response_detail.value; 

                }

                if(response_detail.status=="error"){

                  clicked=false; 

                  jQuery(".ct-loading-main-complete_booking").hide();

                  jQuery("#paypal_error").show();

                  jQuery("#paypal_error").text(response_detail.value);

                }

              }

            });

          }

          if(payment_method == "Wallet-payment"){

            if(current_amount >= net_amount){           

              jQuery(".ct-loading-main-complete_booking").show();

              jQuery.ajax({

                type:"POST",

                url:front_url+"checkout.php",

                data:dataString,

                success:function(response){

                 

                  var response_detail = jQuery.parseJSON(response);

                  if(response_detail.status=="success"){

                    jQuery(".ct-loading-main-complete_booking").hide();

                    window.location=thankyou_page_setting_value;  

                  