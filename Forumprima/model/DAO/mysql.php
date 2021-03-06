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
        	die('Une erreur est survenue lors de la connection � la DB!');
		}		 		 		 		 	
 	} 
 	public static function getInstance(){
 		if(!isset(self::$forum_mysql)){
 			self::$forum_mysql = new Forum_Mysql(); 			
 		}
 		return self::$forum_mysql; 		
 	}
 	
 	/**
 	 * user request 
 	 */
	// Pr�vient les utilisateurs sur le cl�nage de l'instance
    public function __clone()
    {
        trigger_error('Le cl�nage n\'est pas autoris�.', E_USER_ERROR);
    }
     		 	
 	// param = $user est un tableau contenant les datas � mettre dans la DB 
 	public function register_user($user){
 		if (isset($this->DBConnect)){
 			try{		 		
 				
				$sth = $this->DBConnect->prepare("INSERT INTO forum_user (u_login, u_password, u_mail,code) VALUES ('".$user['login']."','".$user['password']."','".$user['email']."',".$user['code'].")");
				$sth->execute();
					 				 			 				 
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
 	
 	//retourne vrai si le $code correspond � celui de la DB
 	public function compare_user_code($login, $code){
 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->query("SELECT u_login FROM forum_user WHERE u_login = '".$login."' AND code =".$code);
 				$result = $result->fetch();
 				 		
 				//si on a aucun r�sultat, c'est que le code ne correspond pas ou le login invalide, dans les deux cas, on retourne faux		 			 			   
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
 				 		
 				//si on a aucun r�sultat, c'est que le password ne correspond pas ou le login invalide, dans les deux cas, on retourne faux		 			 			   
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
 	 
 	 /*
 	  * function de cat�gorie et de forum
 	  */
 	 public function get_cat_list(){
 	 		if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->prepare("SELECT cat_name, cat_id FROM forum_cat ORDER BY cat_ordre");
 				$result->execute();
 				return $result->fetchAll(); 	
 						 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	 } 
 	 public function get_cat($cat_id){
 	 		if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->prepare("SELECT forum_id, forum_name FROM forum_forum WHERE cat_id = ".$cat_id." ORDER BY forum_ordre"); 				
 				$result->execute();
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
 	 } 
 	 public function get_forum($forum_id){
 		if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->prepare("SELECT topic_id, topic_name FROM forum_topic WHERE forum_id = ".$forum_id." ORDER BY topic_last_post_time DESC"); 				
 				$result->execute();
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
 				$result = $this->DBConnect->prepare("SELECT forum_name " .
 												  "FROM forum_forum " .
 												  "WHERE forum_id = ".$forum_id); 				
 				$result->execute();
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 /*
 	  * function de vision de topic  	 
 	  */
 	 public function get_topic($topic_id){
 	 	if (isset($this->DBConnect)){
 			try{	
 				
 				$result = $this->DBConnect->prepare("SELECT post_id, post_text, post_creator,post_time " .
 								"FROM forum_post " . 								
 								"WHERE forum_post.topic_id = ".$topic_id." ".
 								"ORDER BY post_id ");
 				$result->execute(); 				
 				return $result->fetchAll();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 
 	 /*
 	  * function d'ariane 
 	  */
 	 public function get_topic_path($topic_id){
 	 	if (isset($this->DBConnect)){
 			try{		 	
 				$result = $this->DBConnect->prepare("SELECT topic_id, topic_name, forum_name, forum_forum.forum_id, cat_name " .
 								"FROM forum_forum,forum_topic,forum_cat " .
 								"WHERE topic_id = ".$topic_id." AND forum_topic.forum_id = forum_forum.forum_id AND forum_forum.cat_id = forum_cat.cat_id"); 				
 				$result->execute();
 				return $result->fetch();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 public function get_forum_path($forum_id){
 	 	if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->prepare("SELECT forum_name, forum_id, cat_name " .
 								"FROM forum_forum, forum_cat " .
 								"WHERE forum_id = ".$forum_id." AND forum_forum.cat_id = forum_cat.cat_id"); 				
 				$result->execute();
 				return $result->fetch();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 public function get_post($post_id){
 	 	if (isset($this->DBConnect)){
 			try{		 		 				
 				$result = $this->DBConnect->prepare("SELECT post_id, post_text, post_creator, post_time, topic_name " .
 								"FROM forum_post " .
								"LEFT OUTER JOIN forum_topic " .
								"ON forum_post.topic_id = forum_topic.topic_id ". 								
								"WHERE post_id = ".$post_id); 				
 				$result->execute();
 				return $result->fetch();
 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("select error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 /*
 	  * �criture de post
 	  */
 	 public function write_post($post_text,$post_creator,$topic_id,$post_time){
 	 	if (isset($this->DBConnect)){
 			try{		 	 				 	 			
 				$result = $this->DBConnect->prepare("INSERT INTO forum_post " .
 									   "(post_text,post_creator,topic_id,post_time) " .
 									   "VALUES (\"".$post_text."\" , \"".$post_creator."\" , ".$topic_id." , ".$post_time.")");
 				$result->execute();
 				$result = $this->DBConnect->prepare("UPDATE forum_topic " .
 									   "set topic_last_post_time = ".$post_time." ".
 									   "WHERE topic_id = ".$topic_id);
				$result->execute(); 									    
 				 				 				 								 				 			 				 	
 			}
 			catch(Exception $e){
 				die ("write post error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 } 
 	 public function write_topic($topic_name,$forum_id,$post_text,$topic_creator,$topic_last_post_time,$topic_creation_time){
 	 	if (isset($this->DBConnect)){ 	 		
 			try{
 				$result = $this->DBConnect->prepare("INSERT INTO forum_topic " .
 									   "(forum_id,topic_name,topic_creator,topic_creation_time,topic_last_post_time) " .
 									   "VALUES (\"".$forum_id."\" , \"".$topic_name."\" , \"".$topic_creator."\",".$topic_creation_time.", ".$topic_last_post_time.")"); 				 				 								 				 			 				 	
 				$result->execute();
 				$topic_id = $this->DBConnect->lastInsertId(); 			
 				echo $topic_id;	
 				$this->write_post($post_text,$topic_creator,$topic_id,$topic_last_post_time);
 				return $topic_id;
 			}
 			catch(Exception $e){
 				die ("write topic error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 	 }
 	 public function update_post($post_id,$post_text){
  	  	if (isset($this->DBConnect)){ 	 		
 			try{		 	 					 				
 				$result = $this->DBConnect->prepare("UPDATE forum_post " .
 									   "SET post_text = \"".$post_text."\"". 									   
 									   "WHERE post_id = ".$post_id); 	
				$result->execute(); 									   			 				 								 				 			 				 	 				
 			}
 			catch(Exception $e){
 				die ("update post error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	  }
  	  public function delete_post($post_id){
  	  	if (isset($this->DBConnect)){ 	 		
 			try{		 	 					 				
 				$result = $this->DBConnect->prepare("DELETE FROM forum_post " . 									    									  
 									   "WHERE post_id = ".$post_id);
				$result->execute(); 									    				 				 								 				 			 				 	 				 				 			 				
 			}
 			catch(Exception $e){
 				die ("delete post error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	  }
  	  /**
  	   * function de profil
  	   */
  	  public function get_user($user_id){  	  	
  	  	if (isset($this->DBConnect)){ 	 		
 			try{		 	 					 				
 				$result = $this->DBConnect->prepare("SELECT * FROM forum_user " . 									    									  
 									   "WHERE u_id = ".$user_id);
				$result->execute(); 
				return $result->fetch();									    				 				 								 				 			 				 	 				 				 			 				
 			}
 			catch(Exception $e){
 				die ("select user error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	  }
  	   public function set_user_password($user_id,$password){
  	 	if (isset($this->DBConnect)){ 	 		
 			try{		 	 					 				
 				$result = $this->DBConnect->prepare("UPDATE forum_user " .
 									   "SET u_password = \"".$password."\"".									    									  
 									   "WHERE u_id = ".$user_id);
				$result->execute(); 									    				 				 								 				 			 				 	 				 				 			 				
 			}
 			catch(Exception $e){
 				die ("change password error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	 }
  	 public function get_user_id($user_name){  	 	
  	 	if (isset($this->DBConnect)){ 	 		
 			try{		 	 	
 											    				 				
 				$result = $this->DBConnect->prepare("SELECT u_id FROM forum_user " . 									    									  
 									   "WHERE u_login = \"".$user_name."\"");
				$result->execute();
				return $result->fetch(); 									    				 				 								 				 			 				 	 				 				 			 				
 			}
 			catch(Exception $e){
 				die ("get user_id error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	 }
  	 public function get_user_name($user_id){  	 	
  	 	if (isset($this->DBConnect)){ 	 		
 			try{		 	 	
 											    				 				
 				$result = $this->DBConnect->prepare("SELECT u_login FROM forum_user " . 									    									  
 									   "WHERE u_id = \"".$user_id."\"");
				$result->execute();
				return $result->fetch(); 									    				 				 								 				 			 				 	 				 				 			 				
 			}
 			catch(Exception $e){
 				die ("get user_name error nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
  	 }
  	 public function email_exist($email){
  	 	if (isset($this->DBConnect)){
 			try{		 		
 				$result = $this->DBConnect->prepare("SELECT u_login,u_id FROM forum_user WHERE u_mail = '".$email."'");
 				$result->execute();
 				
 				$result = $result->fetch();
 				 		
 				//si on a aucun r�sultat, c'est que l'email n'existe pas dans la db		 			 			   
 				if (empty($result)){ 					
 					return null;
 				} 
 				else return $result;
 				 				 			 				 		
 			}
 			catch(Exception $e){
 				die ("email exist nbr ".$e->getCode()."\n message : ".$e->getMessage());
 			}
 		}
 		else die ("DBConnect not initialized");
  	 }
  	
 }
?>
