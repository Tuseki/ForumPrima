<?php
require_once(APPPATH.'/model/DAO/mysql.php');
 class UserDAO{
 	private $db;  	
  	 
  	public function __construct()
    {
       $this->db = Forum_Mysql::getInstance();        
    }  
    public function register_user($user){    	
		$this->db->register_user($user);
    }
    public function user_already_exist($login){
    	return $this->db->user_already_exist($login);
    }
      	 
    /*
     * cette fonction regarde si une connexion est possible en regardant 
     * le login/password donné en paramètre et regarde s'ils correspondent à ceux dans la DB
     * 
     * retourne true si c'est le cas
     * retourne false sinon
     */
    public function user_connexion_attempt($login,$password){    	
 		return $this->db->check_user_password($login,$password);
    
    }
        
    public function activate_user($login,$code){
    	// ... on vérifie si le code est correct avec celui dans la DB
	 	
	 	$isValided = $this->db->compare_user_code($login,$code);
	 	// si c'est le cas, on active le compte
	 	if ($isValided)$this->db->set_user_active($login,true);
	 	return $isValided;
    }
   
 }
 
 
?>
