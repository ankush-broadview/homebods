<?php class cleanto_login_check

{

    public $conn;

    public $remember;

    public $cookie_passwords; /* check the admin */

    public function checkadmin($name, $password)
	
	
    {

        $query = "select * from `ct_admin_info` where `email` = '" . $name . "' and `password` = '" . $password . "' and `role` = 'admin' and `enable_booking` = 'Y' ";

        $result = mysqli_query($this->conn, $query);
		
        if($result->num_rows <= 0) {

          $query = "select * from `ct_admin_info` where `pro_user_id` = '" . $name . "' and `password` = '" . $password . "' and `role` = 'staff' and `enable_booking` = 'Y' ";

          $result = mysqli_query($this->conn, $query);

        }

        $value = mysqli_fetch_assoc($result);
		
        if (isset($value['id']) && $value['id'] != 0)

        {
            if ($value['role'] == "admin")

            {
			
                $_SESSION['ct_adminid'] = $value['id'];

                $_SESSION['ct_useremail'] = $value['email'];
                
                $_SESSION['ct_username'] = $value['pro_user_id'];
				
				echo "yesadmin";

            }

            else

            {

                $_SESSION['ct_staffid'] = $value['id'];
                $_SESSION['ct_useremail'] = $value['email'];
                
                $_SESSION['ct_username'] = $value['pro_user_id'];
                $_SESSION['user_uuid'] = $value['uuid'];
                $_SESSION['ct_image'] = $value['image'];
                $_SESSION['username'] = $value['pro_user_id'];
                $_SESSION['fullname'] = $value['fullname'];
				
				echo "yesstaff";
            }

            if ($this->remember == "true")

            {

                setcookie('cleanto_username', $name, time() + (86400 * 30) , "/");

                setcookie('cleanto_password', $this->cookie_passwords, time() + (86400 * 30) , "/");

                setcookie('cleanto_remember', "checked", time() + (86400 * 30) , "/");

            }

            else

            {

                unset($_COOKIE['cleanto_username']);

                unset($_COOKIE['cleanto_password']);

                unset($_COOKIE['cleanto_remember']);

                setcookie('cleanto_username', null, -1, '/');

                setcookie('cleanto_password', null, -1, '/');

                setcookie('cleanto_remember', null, -1, '/');

            } 
            

        }

        else

        {
			
            $query = "select * from `ct_users` where `grinders_id` = '" . $name . "' and `user_pwd` = '" . $password . "'";

            $result = mysqli_query($this->conn, $query);

            $value = mysqli_fetch_assoc($result);
			
            if (isset($value['id']) && $value['id'] != 0)

            {

                $_SESSION['ct_login_user_id'] = $value['id'];
                $_SESSION['ct_useremail'] = $value['user_email'];
                
                $_SESSION['ct_username'] = $value['grinders_id'];
                $_SESSION['user_uuid'] = $value['uuid'];
                $_SESSION['ct_image'] = $value['image'];
                $_SESSION['username'] = $value['grinders_id'];
                $_SESSION['fullname'] = $value['first_name']." ".$value['last_name'];

                if ($this->remember == "true")

                {

                    setcookie('cleanto_username', $name, time() + (86400 * 30) , "/");

                    setcookie('cleanto_password', $this->cookie_passwords, time() + (86400 * 30) , "/");

                    setcookie('cleanto_remember', "checked", time() + (86400 * 30) , "/");

                }

                else

                {

                    unset($_COOKIE['cleanto_username']);

                    unset($_COOKIE['cleanto_password']);

                    unset($_COOKIE['cleanto_remember']);

                    setcookie('cleanto_username', null, -1, '/');

                    setcookie('cleanto_password', null, -1, '/');

                    setcookie('cleanto_remember', null, -1, '/');

                } 

                echo "yesuser";

            }

            else

            {

                echo 'no';

            }

        }

    } /* forgot password */

    public function getuserpassword($email)

    {

        $query = "select `password` from `ct_admin_info` where `email` = '" . $email . "'";

        $result = mysqli_query($this->conn, $query);

        $value = mysqli_fetch_row($result);

        if ($value[0] != 0)

        {

            echo "yes";

        }

        else

        {

            echo "no";

        }

    }

    public function resetpassword($id, $newpassword)

    {

        $query = "UPDATE `ct_users` SET `user_pwd` = '" . $newpassword . "' WHERE `id` = '" . $id . "'";

        $result = mysqli_query($this->conn, $query);

    }

} ?>

