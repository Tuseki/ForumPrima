<?php

require_once(APPPATH.'/model/DAO/UserDAO.php');

class ForgottenPasswordTools{
	const EMAIL_DOESNT_EXIST = "Aucun utilisateur trouvé lié à cet email";
	
	private $userDAO;
	
	public function __construct(){
		$this->userDAO = new UserDAO();
	}
	
	private function email_exist($email){					
		return $this->userDAO->email_exist($email);
	}
	private function send_password($user_id,$user_name,$email){
		
		
		//calcul d'un nouveau mot de passe à 6 chiffre
		mt_srand((float) microtime()*1000000);
		$password = mt_rand(100000, 999999);
		echo $password."<br><br>";					
		Email::email_Password_Forgotten($email,$user_name,$password);		
				
		$this->userDAO->set_user_password($user_id,md5($password));
		
		echo $password;
    }
	public function forgotten_password($email,&$err){
		$done = true;
		$user = $this->email_exist($email);
		
		if($user != null){
			$user_id = $user->get_user_id();
			$user_name= $user->get_user_name();					
			$this->send_password($user_id,$user_name,$email);			
		}
		else {
			$done = false;
			$err = ForgottenPasswordTools::EMAIL_DOESNT_EXIST;	
		}
		
		return $done;
	}
}
?>
