<?php        

class cleanto_adminprofile {

	public $id;

	public $email;

	public $pass;

	public $fullname;

	public $password;

	public $phone;

	public $address;

	public $city;

	public $state;

	public $zip;

	public $country;

	public $role;

	public $latitude;

	public $longitude;

	public $description;

	public $enable_booking;

	public $service_commission;

	public $commission_value;

	public $staff_select_according_service;

	public $postal_code;

	public $schedule_type;

    public $APIUsername;

    public $APIPassword;

    public $APISignature;

    public $APItestmode;

	public $ct_service_staff;

	public $tablename="ct_admin_info";

	public $tablename_user="ct_users";

    public $tablename_otp="ct_register_otp";

    public $update_wallet_value;

	public $conn;

	public $otp;

	public $trainer_type;

	public $staff_bio;
	
	public $pro_user_id;
	
	public $zoom_link;




	/*Function for Read Only one data matched with Id*/

	public function readone(){

		$query="select * from `".$this->tablename."` where `id`='".$this->id."'";

		$result=mysqli_query($this->conn,$query);

		$value=mysqli_fetch_array($result);

		return $value;

	}

	/*Function for Update service-Not Used in this*/

	public function update_profile(){

		$address = mysqli_real_escape_string($this->conn,$this->address);

		$query="update `".$this->tablename."` set `fullname`='".$this->fullname."' ,email='".$this->email."' ,`phone`='".$this->phone."' ,`address`='".$address."' ,`city`='".$this->city."' ,`state`='".$this->state."' ,`zip`='".$this->zip."' ,`country`='".$this->country."',`password`='".$this->password."' where `id`='".$this->id."' ";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}

	public function forget_password(){

		$query = "SELECT `id` as `user_id` FROM `".$this->tablename."` where `email`='".$this->email."'";

		$result=mysqli_query($this->conn,$query);

		$res = mysqli_fetch_row($result);

		if(count((array)$res) != 0 ){

			$_SESSION['fp_admin'] = "yes";

			return $res;

		} else {

			$query = "SELECT `id` as `user_id` FROM `".$this->tablename_user."` where `user_email`='".$this->email."'";

			$result=mysqli_query($this->conn,$query);

			$res = mysqli_fetch_row($result);

			$_SESSION['fp_user'] = "yes";

			return $res;

		}

	}

	public function update_password(){

		if(isset($_SESSION['fp_admin'])){

			$query = "update `".$this->tablename."`  set `password`='".md5($this->password)."'  where `id`='".$this->id."'";

			$result=mysqli_query($this->conn,$query);

			return $result;

		}

		elseif(isset($_SESSION['fp_user'])){

			$query = "update `".$this->tablename_user."` set `user_pwd`='".md5($this->password)."'  where `id`='".$this->id."'";

			$result=mysqli_query($this->conn,$query);

			return $result;

		}

	}

	public function readone_adminname(){

		$query="select * from `".$this->tablename."` LIMIT 1";

		$result=mysqli_query($this->conn,$query);

		$value=mysqli_fetch_array($result);

		return $value;

	}

	/* Function for add staff */

	public function add_staff(){

		 $query="insert into `".$this->tablename."` (`id`, `password`, `email`, `fullname`, `phone`, `address`, `city`, `state`, `zip`, `country`,`role`, `description`, `enable_booking`, `service_commission`, `commision_value`, `schedule_type`, `image`, `service_ids`, `last_name`) values(NULL,'".md5($this->pass)."','".$this->email."','".$this->fullname."','', '', '', '', '', '', '".$this->role."', '', 'N', 'F', '0', 'W', '', '','".$this->last_name."')";

		$result=mysqli_query($this->conn,$query);	

		$value=mysqli_insert_id($this->conn);

		return $value;

	}

	/* Function for count staff */

	public function countall_staff(){

		$query="select count(`id`) as `c_sid` from `".$this->tablename."` where `role` = 'staff'";

		$result=mysqli_query($this->conn,$query);	

		$value = mysqli_fetch_array($result);

		return $value= isset($value[0])? $value[0] : '' ;

	}	

	

	/*  display all staff in staff page in admin pane  */

	public function readall_staff(){

		$query = "select * from `".$this->tablename."` where `role` = 'staff'";

		$result = mysqli_query($this->conn,$query);

		return $result;

	}

	/*  display all staff available for booking  */

	public function readall_staff_booking(){

		$query  = "select * from `".$this->tablename."` where `role` = 'staff' and `enable_booking` = 'Y'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}



	/* staff details update*/

	public function update_staff_details(){

	echo $query="update `".$this->tablename."` set `fullname`='".$this->fullname."' ,`email`='".$this->email."' ,`description`='".$this->description."' ,`phone`='".$this->phone."' ,`address`='".$this->address."' ,`city`='".$this->city."' ,`state`='".$this->state."' ,`zip`='".$this->zip."' ,`country`='".$this->country."' ,`enable_booking`='".$this->enable_booking."' ,`image`='".$this->image."'  ,`service_ids`='".$this->ct_service_staff."',`paypal_api_username`='".$this->APIUsername."',`paypal_api_password`='".$this->APIPassword."',`paypal_api_signature`='".$this->APISignature."',`paypal_test_mode_status`='".$this->APItestmode."',`latitude`='".$this->latitude."',`longitude`='".$this->longitude."',`pro_user_id`='".$this->pro_user_id."',`staff_bio`='".$this->staff_bio."',`zoom_link`='".$this->zoom_link."',`last_name`='".$this->last_name."',`custom_rate`='".$this->custom_rate."',`single_customer_rate`='".$this->single_member_rate."' where `id`='".$this->id."' ";

		$result=mysqli_query($this->conn,$query);

    return $result;

	}

	/* delete staff */

	public function delete_staff(){

		$query = "delete from `".$this->tablename."` where `id` = '".$this->id."'";

		$result=mysqli_query($this->conn,$query);

	}

	/* Update image in staff page */	

	public function update_pic(){

		$query="update `".$this->tablename."` set `image`='' where `id`='".$this->id."'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}
	
	/* Update image in customer page */	

	public function update_picc(){

		$query="update `ct_users` set `image`='' where `id`='".$this->id."'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}

	/*display staff service details  in staff page*/

	public function staff_service_details(){

		$query="SELECT `ct_bookings`.`id`,`ct_services`.`title`,`ct_bookings`.`staff_ids`, `ct_admin_info`.`fullname`,`ct_payments`.`amount`,  `ct_admin_info`.`service_commission`, `ct_admin_info`.`commision_value`,`ct_bookings`.`booking_date_time`

		FROM `ct_bookings`, `ct_payments`, `ct_admin_info`,`ct_services`

		WHERE `ct_bookings`.`order_id` = `ct_payments`.`order_id`

		AND `ct_bookings`.`staff_ids` = `ct_admin_info`.`id` and `ct_bookings`.`service_id`=`ct_services`.`id` and `ct_bookings`.`staff_ids`='".$this->id."'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}

	/*display staff service details  in staff page*/

	public function check_staff_email_existing(){

		$query="select count(`id`) as `c` from `".$this->tablename."` where `email`='".$this->email."'";

    	$result=mysqli_query($this->conn,$query);

		$value = mysqli_fetch_array($result);

    	return $value= isset($value[0])? $value[0] : '' ;

	}

	/*new code*/
	public function check_client_email_existing(){

		$query="select count(`id`) as `c` from `".$this->tablename_user."` where `user_email`='".$this->email."'";

    	$result=mysqli_query($this->conn,$query);

		$value = mysqli_fetch_array($result);

    	return $value= isset($value[0])? $value[0] : '' ;

	}
	/*new code end*/
	public function verify_staff_otp_for_email(){
	

        $query = "select * from ct_admin_info where email ='".$this->email."' and otp  = '".$this->otp."'";
        $result = mysqli_query($this->conn,$query); 
        $res = mysqli_fetch_row($result);
        //var_dump($res);die;
        return $value = isset($res[0])? $res[0] : 0 ;
    }

    public function staff_update_otp_for_email(){
        $query="update `".$this->tablename."` set `otp`='".$this->otp."'  where `email`='".$this->email."' ";
        $result=mysqli_query($this->conn,$query);
        return $result;
    }


	public function get_postal_acc_provider(){

    	$query = "select id from ct_admin_info where role='staff' and zip like '" . $this->postal_code . "'";

		$result = mysqli_query($this->conn, $query);

		return $result;

	}

	public function get_service_acc_provider(){

     	$query = "select id from ct_admin_info where `service_ids` like '%" . $this->staff_select_according_service . "%' and `zip`='".$this->postal_code."'";

		$result = mysqli_query($this->conn, $query);

		return $result;

	}

	public function get_search_staff_detail_byid($staff_id){

		$query = "SELECT  `fullname`,`image`,`email`,`phone`,`address`,`city`,`state`,`zip`,`country`,`staff_bio`,`custom_rate`,`zoom_link`,`online_offered`,`single_customer_rate` FROM `".$this->tablename."` WHERE `id`='".$staff_id."'";

		$result = mysqli_query($this->conn, $query);

		$ress = mysqli_fetch_array($result); 

		return $ress;

  }

	public function update_password_api(){

		$query = "update `".$this->tablename."` set `password`='".md5($this->password)."'  where `id`='".$this->id."'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}

	/* API Function */

	public function get_service_acc_provider_api(){

		$query = "select id,fullname from ct_admin_info where service_ids like '%" . $this->staff_select_according_service . "%'";

		$result = mysqli_query($this->conn, $query);

		return $result;

	}



  	/* Function for reg staff */

  	public function reg_staff(){
  		$query1 = "SELECT uuid() as uuid";
	    $result=mysqli_query($this->conn,$query1);
	    $res = mysqli_fetch_array($result);
	    $uuid = $res['uuid'];

    	$query="insert into `".$this->tablename."` (`id`, `password`, `email`, `fullname`, `phone`, `address`, `city`, `state`, `zip`, `country`,`role`, `description`, `enable_booking`, `service_commission`, `commision_value`, `schedule_type`, `image`, `service_ids`,`uuid`) values(NULL,'".md5($this->pass)."','".$this->email."','".$this->fullname."','', '', '', '', '', '', 'staff', '', 'N', 'F', '0', 'W', '', '".$this->service."','".$uuid."')";

   		$result=mysqli_query($this->conn,$query); 

    	$value=mysqli_insert_id($this->conn);

    	return $value;

  	}

	public function pre_reg_staff(){
    	
		$query1 = "SELECT uuid() as uuid";
	    $result = mysqli_query($this->conn,$query1);
	    $res = mysqli_fetch_array($result);
	    $uuid = $res['uuid'];

    	$query="insert into `".$this->tablename."` (`id`, `password`, `email`, `fullname`, `phone`, `address`, `city`, `state`, `zip`, `country`,`role`, `description`, `enable_booking`, `service_commission`, `commision_value`, `schedule_type`, `image`, `service_ids`, `otp`,`online_offered`,`trainer_for`,`price_for_single`,`price_for_3`,`price_for_5`,`staff_bio`,`pro_user_id`,`zoom_link`,`custom_rate`, `last_name`,`uuid`) values(NULL,'".$this->pass."','".$this->email."','".$this->first_name."','".$this->phone."', '".$this->address."', '".$this->city."', '".$this->state."', '".$this->zip_code."', '".$this->country."', 'staff', '', 'N', 'F', '0', 'W', '".$this->image."', '".$this->service_ids."', '".$this->otp."','".$this->offered."','".$this->trainer_type."','".$this->price_for_single."','".$this->price_for_3."','".$this->price_for_5."','".$this->staff_bio."','".$this->pro_user_id."','".$this->zoom_link."','".$this->custom_rate."','".$this->last_name."','".$uuid."')";
    	// var_dump($query);die;		
    	$result = mysqli_query($this->conn,$query); 

    	$value = mysqli_insert_id($this->conn);

    	return $value;

  	}

  	public function update_staff_details_staffsection(){

    	$query="update `".$this->tablename."` set `fullname`='".$this->fullname."' ,`email`='".$this->email."' ,`description`='".$this->description."' ,`phone`='".$this->phone."' ,`address`='".$this->address."' ,`city`='".$this->city."' ,`state`='".$this->state."' ,`zip`='".$this->zip."' ,`country`='".$this->country."' ,`enable_booking`='".$this->enable_booking."' ,`image`='".$this->image."'  ,`service_ids`='".$this->ct_service_staff."',`last_name`='".$this->last_name."' where `id`='".$this->id."' ";
    	$result=mysqli_query($this->conn,$query);
    	return $result;
  	}

    /*insert otp in the otp table*/
  	public function insert_otp(){

    	$query="insert into `".$this->tablename_otp."` (`id`, `phone`, `otp`) values(NULL,'".$this->phoneno."','".$this->otp."')";
	    $result=mysqli_query($this->conn,$query); 
	    $value=mysqli_insert_id($this->conn);
	    return $result;
	} 

	/*check otp*/
  	public function check_otp_for_phone(){
    	$query="select otp from `".$this->tablename_otp."` where `phone`='".$this->phoneno."'";
        $result=mysqli_query($this->conn,$query);
        $res = mysqli_fetch_row($result);
    	return $res;
    }

    /*update otp*/
    public function update_otp(){
        $query="update `".$this->tablename_otp."` set `otp`='".$this->otp."'  where `phone`='".$this->phoneno."' ";
	    $result=mysqli_query($this->conn,$query);
	    return $result;
	}



  /*verify otp*/

  public function verify_otp(){

    $query = "select * from `".$this->tablename_otp."` where `phone`='".$this->phone."' and `otp` = '".$this->otp."'";

        $result=mysqli_query($this->conn,$query); 

    $res = mysqli_fetch_row($result);

    return $res;   

  }



  public function get_previous_staff_wallet(){

    $query="select `staff_wallet_amount`,`email`,`fullname` from `".$this->tablename."` where `id`='".$this->id."'";

    $result=mysqli_query($this->conn,$query);

    $value=mysqli_fetch_row($result);

    return $value;

  }



  public function update_staff_wallet(){

    $query = "update `".$this->tablename."`  set `staff_wallet_amount`='".$this->update_wallet_value."' where `id`='".$this->id."'";

    $result=mysqli_query($this->conn,$query);

    return $result;

  }

    

  public function update_staff_wallet_byemail(){

    $query = "update `".$this->tablename."`  set `staff_wallet_amount`='".$this->update_wallet_value."' where `email`='".$this->email."'";

    $result=mysqli_query($this->conn,$query);

    return $result;

  }



  public function get_staff_reve($staff_id){

    $query="select `revenue_percentage` from `".$this->tablename."` WHERE `id`='".$staff_id."'";

    $result=mysqli_query($this->conn,$query);

    $value=mysqli_fetch_array($result);

    return $value= isset($value[0])? $value[0] : '' ;

  } 
	/* Update status after otp verify */	

	public function update_staff_validate(){

		$query="update `".$this->tablename."` set `enable_booking`='Y' where `email`='".$this->email."'";

		$result=mysqli_query($this->conn,$query);

		return $result;

	}
	
	public function get_staff_details(){

		$query = "select `price_for_single`,`price_for_3`,`price_for_5` from `".$this->tablename."` where `id`='".$this->id."'";

		$result = mysqli_query($this->conn,$query);

		$value = mysqli_fetch_row($result);

		return $value;

	}

	public function getStripeAccountIdByEmail() {

		$query = "SELECT stripe_account_id FROM `".$this->tablename."` WHER `email`='".$this->email."'";
		
		$result = mysqli_query($this->conn,$query);

		$value = mysqli_fetch_row($result);

		return $value;
	}

	public function getStripeAccountIdById() {

		$query = "SELECT stripe_account_id FROM `".$this->tablename."` WHERE `email`='".$this->email."'";

		$value = [];

		$result = mysqli_query($this->conn,$query);

		if($result)
			$value = mysqli_fetch_row($result);

		return $value;
	}

	public function updateStripeAccountId($accntId) {

		$query = "update `".$this->tablename."` set `stripe_account_id`='$accntId' where `email`='".$this->email."'";
		$result=mysqli_query($this->conn,$query);

		return $result;
	}

	public function updateStripeAccountStatus($stripe_account_id, $status = 0) {

		$query = "UPDATE `".$this->tablename."` set `stripe_account_status`= $status where `stripe_account_id`='".$stripe_account_id."'";
		$result = mysqli_query($this->conn,$query);

		return $result;
	}
	

}