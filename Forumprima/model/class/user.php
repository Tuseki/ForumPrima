<?php
class User{
	private $user_id;
	private $user_name;	
	private $email;
	
	public function __construct(){
		$user_id = null;
		$user_name = null;
	}
	
	public function set_user_id($user_id){
		$this->user_id = $user_id;
	}
	public function get_user_id(){
		return $this->user_id;
	}
	public function set_user_name($user_name){
		$this->user_name = $user_name;
	}
	public function get_user_name(){
		return 	$this->user_name;
	}
	public function set_email($email){
		$this->email = $email;
	}
	public function get_email(){
		return $this->email;	
	}
	
}
?>
