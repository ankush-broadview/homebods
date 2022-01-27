<?php

session_start();

require dirname(__FILE__).'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
include(dirname(__FILE__) . '/config.php');

/**
* 
*/
class User
{
		
	private $conn;
	private $firebase;

	function __construct()
	{	
		try {
			$cvars = new cleanto_myvariable();
			$host = trim($cvars->hostnames);
			$un = trim($cvars->username);
			$ps = trim($cvars->passwords); 
			$db = trim($cvars->database);
		
			$this->conn = new PDO("mysql:host=".$host.";dbname=".$db,$un,$ps);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

			// This assumes that you have placed the Firebase credentials in the same directory
			// as this PHP file.
			// $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/my-test-app-91f99-firebase-adminsdk-tftew-34a984e387.json');
			$serviceAccount = ServiceAccount::fromJsonFile(dirname(__FILE__).'/chat-system-demo-5a5ff-firebase-adminsdk-av8cl-aaf29094bd.json');

			$this->firebase = (new Factory)
			     ->withServiceAccount($serviceAccount)
			     ->create();
		} catch (PDOException $e) {
			echo 'Exception -> ';
    		var_dump($e->getMessage());
		}
		
	}

	private function getUuid(){
		return $this->conn->query("SELECT uuid() as uuid")->fetch()['uuid'];
	}

	private function isExists($table, $key, $value){
		
		try{
			$stmt = $this->conn->prepare("SELECT uuid FROM $table WHERE :key = :value LIMIT 1");
		
			$stmt->bindParam(':key', $key, PDO::PARAM_STR);
			$stmt->bindParam(':value', $value, PDO::PARAM_STR);

			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				return array('status'=> 303, 'message'=> $value.' already exists');
			}else{
				return array('status'=> 200, 'message'=> $value);
			}
		}catch(Exception $e){
			return array('status'=>405, 'message'=>$e->getMessage());
		}
		
	}

	public function createAccount($fullname, $username, $email, $password){

		if (empty($fullname) || empty($username) || empty($email) || empty($password)) {
			return array('status'=> 303, 'message'=> 'Empty Fields');
		}else{
			
			$emailResp = $this->isExists('users', 'email', $email);
			if ($emailResp['status'] != 200) {
				return $emailResp;
			}
			
			$usernameResp = $this->isExists('users', 'username', $username);
			if ($usernameResp['status'] != 200) {
				return $usernameResp;
			}

			$password = password_hash($password, PASSWORD_BCRYPT, ['cost'=> 8]);
			$stmt = $this->conn->prepare("INSERT INTO `users`(`uuid`, `fullname`, `username`, `email`, `password`) VALUES (:uuid, :fullname, :username , :email, :password)");
			
			$uuid = $this->getUuid();
			
			$stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
			$stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':password', $password, PDO::PARAM_STR);

			if ($stmt->execute()) {
				return array('status'=> 200, 'message'=> 'Account creatded Successfully..!');
			}else{
				return array('status'=> 303, 'message'=> print_r($stmt->errorInfo()));
			}

		}
		
	}

	public function loginUser($user_email, $password){

		if(isset($_SESSION['ct_staffid'])){ 
			$stmt = $this->conn->prepare("SELECT email as user_email,uuid,pro_user_id,fullname FROM ct_admin_info WHERE email = :user_email LIMIT 1");
			$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
			$stmt->execute();
		}else{
			$stmt = $this->conn->prepare("SELECT * FROM ct_users WHERE user_email = :user_email LIMIT 1");
			$stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
			$stmt->execute();
		}

		if ($stmt->rowCount() == 1) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// if (password_verify($password, $row['password'])) {
				if($_SESSION['ct_staffid']){ $username = $row['pro_user_id'];} else {$username = $row['grinders_id'];}
				if($_SESSION['ct_staffid']){ $fullname = $row['fullname'];} else {$fullname = $row['first_name'].' '.$row['last_name'];}
				
				$_SESSION['user_uuid'] = $row['uuid'];
				$_SESSION['username'] = $username;
				$_SESSION['fullname'] = $fullname;

				$ar = [];
				$ar['message'] =  'User Logged in Successfully';
				$ar['user_uuid'] = $row['uuid'];

				$additionalClaims = ['username'=> $username, 'email'=> $row['user_email']];
				$customToken = $this->firebase->getAuth()->createCustomToken($ar['user_uuid'], $additionalClaims);
				

				$ar['token'] = (string)$customToken;
				
				return array('status'=> 200, 'message'=> $ar);

			// }else{
			// 	return array('status'=> 303, 'message'=> 'Password does not match');
			// }
		}else{
			return array('status'=> 303, 'message'=> $user_email.' does not exists');
		}

	}

	public function createChatRecord($user_1_uuid, $user_2_uuid){

		$chat_uuid_stmt = $this->conn->prepare("SELECT chat_uuid FROM chat_record WHERE (user_1_uuid = :user_1_uuid AND user_2_uuid = :user_2_uuid) OR (user_1_uuid = :user_22_uuid AND user_2_uuid = :user_11_uuid) LIMIT 1");
		
		$chat_uuid_stmt->bindParam(":user_1_uuid", $user_1_uuid, PDO::PARAM_STR);
		$chat_uuid_stmt->bindParam(":user_2_uuid", $user_2_uuid, PDO::PARAM_STR);
		$chat_uuid_stmt->bindParam(":user_22_uuid", $user_2_uuid, PDO::PARAM_STR);
		$chat_uuid_stmt->bindParam(":user_11_uuid", $user_1_uuid, PDO::PARAM_STR);

		$chat_uuid_stmt->execute();
		$ar = [];

		if (empty($user_1_uuid) || empty($user_2_uuid)) {
			return  array('status' => 303, 'message'=> 'Invalid details');
		}

		$ar['user_1_uuid'] = $user_1_uuid;
		$ar['user_2_uuid'] = $user_2_uuid;

		if ($chat_uuid_stmt->rowCount() == 1) {
			$ar['chat_uuid'] = $chat_uuid_stmt->fetch(PDO::FETCH_ASSOC)['chat_uuid'];
			return array('status'=>200, 'message'=> $ar);
		}else{
			$chat_uuid = $this->getUuid();
			$begin_chat_stmt = $this->conn->prepare("INSERT INTO `chat_record`(`chat_uuid`, `user_1_uuid`, `user_2_uuid`) VALUES (:chat_uuid, :user_1_uuid, :user_2_uuid)");
			
			$begin_chat_stmt->bindParam(':chat_uuid', $chat_uuid, PDO::PARAM_STR);
			$begin_chat_stmt->bindParam(':user_2_uuid', $user_1_uuid, PDO::PARAM_STR);
			$begin_chat_stmt->bindParam(':user_1_uuid', $user_2_uuid, PDO::PARAM_STR);
			
			$begin_chat_stmt->execute();
			$ar['chat_uuid'] = $chat_uuid;
			
			return array('status'=> 200, 'message'=> $ar);

		}
		


	}

	public function getUsers(){

		$ar = [];
		if(isset($_SESSION['ct_login_user_id'])){

			$query1 = $this->conn->query("SELECT staff_ids FROM ct_bookings WHERE  client_id=".$_SESSION['ct_login_user_id']." and staff_ids!=''");
			$row1 = $query1->fetchAll(PDO::FETCH_ASSOC);
			$staff_ids = implode(",", array_column($row1,"staff_ids")) ;
			
			$query = $this->conn->query("SELECT uuid, fullname,pro_user_id as username,image FROM ct_admin_info WHERE id in(".$staff_ids.") ");

			
			
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$user_1_uuid = $_SESSION['user_uuid'];
				$user_2_uuid = $row['uuid'];
				$user_22_uuid = $row['uuid'];
				$user_11_uuid = $_SESSION['user_uuid'];
				$query1 = $this->conn->query("SELECT chat_uuid FROM chat_record WHERE (user_1_uuid = '".$user_1_uuid."' AND user_2_uuid = '".$user_2_uuid."') OR (user_1_uuid = '".$user_22_uuid."' AND user_2_uuid = '".$user_11_uuid."') LIMIT 1");
				$row1 = $query1->fetch(PDO::FETCH_ASSOC);
				
				// $ar[] = array("uuid" => $row['uuid'],"fullname" =>$row['fullname'],"username" => $row['username'],"image" =>$row['image'], "chat_uuid" => $row1['chat_uuid']);
				$ar[] = array("loginuser_uuid"=>$_SESSION['user_uuid'],"uuid" => $row['uuid'],"fullname" =>$row['fullname'],"username" => $row['username'],"image" =>$row['image'], "chat_uuid" => isset($row1['chat_uuid'])? $row1['chat_uuid'] : '');
			}
			
		}else if(isset($_SESSION['ct_staffid'])){
			$query1 = $this->conn->query("SELECT client_id FROM ct_bookings WHERE  staff_ids=".$_SESSION['ct_staffid']);
			$row1 = $query1->fetchAll(PDO::FETCH_ASSOC);
			$client_ids = implode(",", array_column($row1,"client_id")) ;

			$query = $this->conn->query("SELECT uuid, concat(first_name,' ',last_name) as fullname,first_name as username,image FROM ct_users WHERE id in(".$client_ids.")");
			
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				// var_dump($row);
				$user_1_uuid = $_SESSION['user_uuid'];
				$user_2_uuid = $row['uuid'];
				$user_22_uuid = $row['uuid'];
				$user_11_uuid = $_SESSION['user_uuid'];

				$query1 = $this->conn->query("SELECT chat_uuid FROM chat_record WHERE (user_1_uuid = '".$user_1_uuid."' AND user_2_uuid = '".$user_2_uuid."') OR (user_1_uuid = '".$user_22_uuid."' AND user_2_uuid = '".$user_11_uuid."') LIMIT 1");
				
				// echo "SELECT chat_uuid FROM chat_record WHERE (user_1_uuid = '".$user_1_uuid."' AND user_2_uuid = '".$user_2_uuid."') OR (user_1_uuid = '".$user_22_uuid."' AND user_2_uuid = '".$user_11_uuid."') LIMIT 1";die;
				$row1 = $query1->fetch(PDO::FETCH_ASSOC);
				
				// $ar[] = array("uuid" => $row['uuid'],"fullname" =>$row['fullname'],"username" => $row['username'],"image" =>$row['image'], "chat_uuid" => $row1['chat_uuid']);
				$ar[] = array("loginuser_uuid"=>$_SESSION['user_uuid'],"uuid" => $row['uuid'],"fullname" =>$row['fullname'],"username" => $row['username'],"image" =>$row['image'], "chat_uuid" => isset($row1['chat_uuid'])? $row1['chat_uuid'] : '');
			}
		}
		return array('status'=>200, 'message'=>['users'=>$ar]);

	}

	public function logout(){

		if (isset($_SESSION['username'])) {
			
			unset($_SESSION['username']);
			unset($_SESSION['user_uuid']);
			session_destroy();
			
			return array('status'=>200, 'message'=>'User Logout Successfully');
		}
		return array('status'=>303, 'message'=>'Logout Fail');

	}




}








?>