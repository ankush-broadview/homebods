<?php  
	
class cleanto_balance_logs{
	
	public $id;
	public $booking_id;
	public $pro_id;
	public $amount;
	public $created_at;	
	public $updated_at;	
	public $status;
	public $conn;
	public $table_name="ct_pro_balances_logs";
	
	/* 
	* Function for add Coupon in setting 
	*
	*/
	
	public function insert(){
		$query="insert into `".$this->table_name."` (`booking_id`,`pro_id`,`amount`,`status`,`created_at`,`updated_at`) values({$this->booking_id},{$this->pro_id},{$this->amount},'0',NOW(),NOW())";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_insert_id($this->conn);
		return $value;
	}
	
	public function getProBalances(){
		$query="select sum(amount) as pending_balance from `{$this->table_name}` where pro_id={$this->pro_id} and status='0'";
		$result=mysqli_query($this->conn,$query);
		$value=mysqli_fetch_array($result);
		return $value['pending_balance'];		
	}
	
	
	
	/* 
	* Function for Update Status of Coupon in setting
	*
	*/
	
	public function updatestatus(){
		$query="update `{$this->table_name}` set `status`='1', updated_at=NOW() where `pro_id`={$this->pro_id}";
		$result=mysqli_query($this->conn,$query);
		return $result;
	}

	
}
?>