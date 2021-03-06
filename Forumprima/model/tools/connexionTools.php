<?php

require_once(APPPATH.'/model/DAO/UserDAO.php');

class User_Connexion{
	
	static function is_already_Connected(){
		if( !isset($_SESSION['usersession']) || !$_SESSION['usersession']->isConnected())
		{
			return false;
		}
		else return true;
	}

	 static function forum_user_connexion($user_name){
	 	$_SESSION['usersession'] = new ForumSession();
		$_SESSION['usersession']->connexion();
		$_SESSION['usersession']->set_user_name($user_name);
		$userDAO = new UserDAO();
		$user_id = $userDAO->get_user_id($user_name); 		
		$_SESSION['usersession']->set_user_id($user_id);	
	 }
	 
	/*
     * cette fonction regarde si une connexion est possible en regardant 
     * le login/password donn� en param�tre et regarde s'ils correspondent � ceux dans la DB
     * 
     * retourne true si c'est le cas
     * retourne false sinon
     */
 	static function user_connexion_attempt($login,$password){ 		 
 			$password = md5($password); 
			$userDAO = new UserDAO();
 		    return $userDAO->user_connexion_attempt($login,$password); 		     		  
 	}
	 static function user_deconnexion(){ 	
		if(isset($_SESSION['usersession']) && $_SESSION['usersession']->isConnected()){
			session_destroy();		
		}	
	 }
	 static function get_user_name(){
	 	return $_SESSION['usersession']->get_user_name();
	 }
	  static function get_user_id(){
	 	return $_SESSION['usersession']->get_user_id();
	 }
}
  
?>
