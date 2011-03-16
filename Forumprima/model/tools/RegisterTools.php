<?php
require_once(APPPATH.'/model/DAO/UserDAO.php');
 class RegisterTools{
 	private $userDAO; 
 	private $err_tab;
 	private $user;
  	 
  	//definition des constantes d'erreur
	const LOGIN_EMPTY = "Vous devez introduire un login";
	const LOGIN_ALREADY_EXIST = "Le login existe déjà"; 
	const LOGIN_TOO_SHORT = "Le login ne comporte pas assez de caractère";
	const LOGIN_TOO_LONG = "Le login ne peut pas comporter plus de 16 caractères";
	const PASSWORD_EMPTY = "Vous devez introduire un password";
	const PASSWORD_TOO_SHORT = "Le mot de passe ne comporte pas assez de caractère";
	const PASSWORD_TOO_LONG = "Le mot de passe ne peut pas comporter plus de 16 caractères";
	const EMAIL_EMPTY = "Vous devez introduire un email";
	const EMAIL_FORMAT_INVALID = "Ceci n'est pas un format d'email valide";
	const EMAIL_ALREADY_EXIST = "L'adresse email introduite existe déjà";
	const EMAIL_TOO_LONG = "L'adresse email est trop longue";
	const CONFIRM_PASSWORD_UNMATCH = "Votre mot de passe de confirmation ne correspond pas à votre mot de passe"; 
  	 
  	 
  	public function __construct()
    {
       $this->userDAO = new UserDAO();
        
       $this->err_tab['login'] = '';
	   $this->err_tab['password'] = '';
	   $this->err_tab['passwordconfirm'] = '';
	   $this->err_tab['email'] = '';	   
	   
	   $this->user['login'] = '';
	   $this->user['password'] = '';
	   $this->user['passwordconfirm'] = '';
	   $this->user['email'] = '';
    }
    public function get_err_tab(){
    	return $this->err_tab;
    }
    public function getUser(){
    	return $this->user;
    }
    public function registration($user){
    	
    	//calcul d'un code de confirmation de registration
		mt_srand((float) microtime()*1000000);
		$code = mt_rand(1000000000, 9999999999);
		
		// note : si le formulaire est validé, on assume que le tableau user est bien initalisé				
		$user['code'] = $code;
		$password = $user['password'];
		$user['password'] = md5($user['password']);
		
		$this->userDAO->register_user($user);
						
		//on envoi un mail de registration										
		Email::registerConfirmMail($user['email'],$user['login'],$password,$code);
    }
    public function validation($user){
    	$valided = true;		
			
		$this->user['login']= $user['login'];	
		$this->user['password']= $user['password'];
		$this->user['passwordconfirm']= $user['passwordconfirm'];
		$this->user['email']= $user['email'];
			
		//on commence les tests 
				
		//1 : le login est-il vide?	
		if ( empty($user['login'])){ 
			$valided = false;
			$this->err_tab['login'] = utf8_encode(RegisterTools::LOGIN_EMPTY);						
		}				
		//2 : le login est-il trop petit?
		else if (strlen($user['login']) < 3){
			$valided = false;
			$this->err_tab['login'] = utf8_encode(RegisterTools::LOGIN_TOO_SHORT);
			$this->user['login'] = '';
		}		
		//3 : le login est-il trop grand?
		else if (strlen($user['login']) > 15){
			$valided = false;
			$this->err_tab['login'] = utf8_encode(RegisterTools::LOGIN_TOO_LONG);
			
			$this->user['login'] = '';
		}
		//3 bis : le nom de login est déjà pris?			
		else if ($this->userDAO->user_already_exist($user['login'])){
			$valided = false;
			$this->err_tab['login'] = utf8_encode(RegisterTools::LOGIN_ALREADY_EXIST);			
		}
		
		//4 : le password est-il vide?		
		if ( empty($user['password'])){ 
			$valided = false;
			$this->err_tab['password'] = utf8_encode(RegisterTools::PASSWORD_EMPTY);
		}
		//5 : le password est-il trop petit?
		else if (strlen($user['password']) < 3){
			$valided = false;
			$this->err_tab['password'] = utf8_encode(RegisterTools::PASSWORD_TOO_SHORT);
			$this->user['password'] = '';
		}
		//6 : le password est-il trop grand?
		else if (strlen($user['password']) > 15){
			$valided = false;
			$this->err_tab['password'] = utf8_encode(RegisterTools::PASSWORD_TOO_LONG);
			$this->user['password'] = '';
		}		
		//7 : le confirmpassword est-il le même que le password?
		if ($user['password'] != $user['passwordconfirm']){
			$valided = false;
			$this->err_tab['passwordconfirm'] = utf8_encode(RegisterTools::CONFIRM_PASSWORD_UNMATCH);
			$this->user['password'] = '';
			$this->user['passwordconfirm'] = '';
		}				
		//8 : le email est-il vide?
		if ( empty($user['email'])){ 
			$valided = false;
			$this->err_tab['email'] = utf8_encode(RegisterTools::EMAIL_EMPTY);			
		}		
		//9 : le email est-il en bon format?
		else if(! filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
			$valided = false;
			$this->err_tab['email'] = utf8_encode(RegisterTools::EMAIL_FORMAT_INVALID); 
			$this->user['email'] = '';
		}
		//9 bis : le email est-il trop long?
		else if (strlen($user['password']) > 50){
			$valided = false;
			$this->err_tab['email'] = utf8_encode(RegisterTools::EMAIL_TOO_LONG); 
			$this->user['email'] = '';
		}
		//10 : l'émail est déjà pris
		/*
		 * TO-DO
		 */	 		
		
		//on retourne la valeur de $valided				
		return $valided;
    }      	   
    function activate_user($login,$code){  	
	 	 
	 	 	return $this->userDAO->activate_user($login,$code);
    }           
 }
 
 
?>
