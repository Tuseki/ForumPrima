<?php
require_once(APPPATH.'/model/DAO/UserDAO.php');
class ProfileTools{
	private $userDAO;
		
	const WRONG_PASSWORD = "Votre ancien mot de passe est incorrect"; 	
	const NEW_PASSWORDS_DOESNTMATCH = "Votre nouveau mot de passe et sa confirmation ne correspondent pas";
	const PASSWORD_EMPTY = "votre mot de passe est vide";	
	const NEWPASSWORD_EMTPY = "votre nouveau mot de passe est vide";
	const NEWPASSWORD_TOO_SHORT = "votre nouveau mot de passe trop court";
	const NEWPASSWORD_TOO_LONG = "votre nouveau mot de passe est trop long";	
	
	public function __construct(){
		$this->userDAO = new UserDAO();
	}
	
	 /*
	  * function de profil
	  */
	 public function get_user($user_id){
  	 	return $this->userDAO->get_user($user_id);
  	 }
  	 public function set_user_password($user_id,$password){
  	 	$this->userDAO->set_user_password($user_id,md5($password));
  	 }
  	 public function get_user_id($user_name){
  	 	return $this->userDAO->get_user_id($user_name);
  	 }
  	 public function validate_new_password($oldpassword,$newpassword,$confirmnewpassword, &$err_message){
		$valided = true;	
							
		if ( empty($oldpassword)){ 
			$valided = false;
			$err_message = utf8_encode(ProfileTools::PASSWORD_EMPTY);						
		}
		else if (! $this->userDAO->user_connexion_attempt(User_Connexion::get_user_name(),md5($oldpassword))){
			$valided = false;
			$err_message = utf8_encode(ProfileTools::WRONG_PASSWORD);
		}
		else if ( empty($newpassword)){ 
			$valided = false;
			$err_message = utf8_encode(ProfileTools::NEWPASSWORD_EMTPY);						
		}
		else if ( strlen($newpassword) < 3){ 
			$valided = false;
			$err_message = utf8_encode(ProfileTools::NEWPASSWORD_TOO_SHORT);						
		}
		else if ( strlen($newpassword) > 15){ 
			$valided = false;
			$err_message = utf8_encode(ProfileTools::NEWPASSWORD_TOO_LONG);						
		}		
		else if ($confirmnewpassword != $newpassword){
			$valided = false;
			$err_message = utf8_encode(ProfileTools::NEW_PASSWORDS_DOESNTMATCH);
		}
				  	 	  	 	  	 	
  	 	return $valided;
  	 }
}
?>
