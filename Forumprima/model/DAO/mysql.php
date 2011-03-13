<?php

 class Forum_Mysql { 
 	
 	private static $forum_mysql;
 	private $DBConnect; 

 	private $db_host = DB_HOST;
 	private $db_user = DB_USER;
 	private $db_password = DB_PASSWORD;
 	
 	private function __construct(){
 		try
		{			
        	$this->DBConnect = new PDO($this->db_host,$this->db_user,$this->db_password);
        	$this->DBConnect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        	$this->DBConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
 
		catch(Exception $e)
		{			        	
        	die('Une erreur est survenue lors de la connection à la DB!');
		}		 		 		 		 	
 	} 
 	public static function get_Forum_Mysql(){
 		if(!isset(self::$forum_mysql)){
 			self::$forum_mysql = new Forum_Mysql(); 			
 		}
 		return self::$forum_mysql; 		
 	}
 	
 	/**
 	 * user request 
 	 */
	// Prévient les utilisateurs sur le clônage de l'instance
    public function __clone()
    {
        trigger_error('Le clônage n\'est pas autorisé.', E_USER_ERROR);
    }
     		 	
 	// param = $user est un tableau contenant les datas à mettre dans la DB 
 	public function register_user($user){
 		if (isset($this->DBConnect)){
 			try{		 		
 				$this->DBConnect->exec("INSERT INTO forum_user (u_login, u_password, u_mail,code) VALUES ('".$user['login']."','".$user['password']."','".$user['email']."',".$user['code'].")"); 			 				 			
 			}
 			catch(Exception $e){
 				die ("insert error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized"); 		 				 		 		
 	}
 	public function user_already_exist($user_name){
 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->query("SELECT u_login FROM forum_user WHERE u_login = '".$user_name."'");
 				$result = $result->fetch();
 				 				 			 			   
 				if (empty($result)){ 					
 					return false;
 				} 
 				else return true;
 				 				 			 				 		
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	}
 	
 	//retourne vrai si le $code correspond à celui de la DB
 	public function compare_user_code($login, $code){
 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->query("SELECT u_login FROM forum_user WHERE u_login = '".$login."' AND code =".$code);
 				$result = $result->fetch();
 				 		
 				//si on a aucun résultat, c'est que le code ne correspond pas ou le login invalide, dans les deux cas, on retourne faux		 			 			   
 				if (empty($result)){ 					
 					return false;
 				} 
 				else return true;
 				 				 			 				 		
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	}
 	public function check_user_password($login,$password){
 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->query("SELECT u_login FROM forum_user WHERE u_login = '".$login."' AND u_password ='".$password."'");
 				$result = $result->fetch();
 				 		
 				//si on a aucun résultat, c'est que le password ne correspond pas ou le login invalide, dans les deux cas, on retourne faux		 			 			   
 				if (empty($result)){ 					
 					return false;
 				} 
 				else return true;
 				 				 			 				 		
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	}
 	public function set_user_active($login,$bool){
 		
 		if ($bool == true) $b = 1;
 		else $b = 0;  
 		
 		if (isset($this->DBConnect)){
 			try{	
 				$sql = "UPDATE forum_user SET isActive = ".$b." WHERE u_login = '".$login."'";	 		
 				$this->DBConnect->exec("UPDATE forum_user SET isActive = ".$b." WHERE u_login = '".$login."'");
				 				 			 				 		
 			}
 			catch(Exception $e){
 				die ("update isActive error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized"); 
 	}
 	/**
 	 * forum request 
 	 */
 	 public function get_cat_list(){
 	 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->query("SELECT cat_name, cat_id FROM forum_cat ORDER BY cat_ordre");
 				return $result->fetchAll(); 	
 						 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	 } 
 	 public function get_forum_list($cat_id){
 	 		if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->query("SELECT forum_id, forum_name FROM forum_forum WHERE cat_id = ".$cat_id." ORDER BY forum_ordre"); 				
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	 } 
 	 public function get_topic_list($forum_id){
 		if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->query("SELECT topic_id, topic_name FROM forum_topic WHERE forum_id = ".$forum_id." ORDER BY topic_ordre"); 				
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 public function get_forum_name($forum_id){
 	 	if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->query("SELECT forum_name FROM forum_forum WHERE forum_id = ".$forum_id); 				
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
}
?>
