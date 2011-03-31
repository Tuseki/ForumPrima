<?php
class ForumSession{
 	private $isConnected;
 	private $user_name; 
 	private $user_id;
 	
 	public function isConnected(){
 		return $this->isConnected;
 	}
 	public function connexion(){
 		$this->setConnected(true);
 	} 	
 	public function deconnexion(){
 		$this->setConnected(false);
 	}
 	public function get_user_name(){
 		return $this->user_name;
 	}
 	public function set_user_name($user_name){
 		$this->user_name = $user_name;
 	}
 	public function get_user_id(){
 		return $this->user_id;
 	}
 	public function set_user_id($user_id){
 		$this->user_id = $user_id;
 	}
 	private function setConnected($bool){
 		if(is_bool($bool)){
 			$this->isConnected = $bool;
 		}
 		// si le parametre est pas un boolean, on se connecte pas
 		else $this->isConnected = false;  		
 	}  
 
 }
?>
