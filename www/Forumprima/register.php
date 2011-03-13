<?php
	
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');
	require(RELATIVEAPPROOT.'/view/templates/RegisterForm.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/DAO/mysql.php');
	require(RELATIVEAPPROOT.'/model/class/mail.php');
	
	/**
	 * controller
	 */  
	session_start();
	//definition du tableau d'erreur
	$err_tab['login'] = '';
	$err_tab['password'] = '';
	$err_tab['passwordconfirm'] = '';
	$err_tab['email'] = '';
	
	//definition des constantes d'erreur
	define("LOGIN_EMPTY",utf8_encode("Vous devez introduire un login"));
	define("LOGIN_ALREADY_EXIST",utf8_encode("Le login existe d�j�"));
	define("LOGIN_TOO_SHORT",utf8_encode("Le login ne comporte pas assez de caract�re"));
	define("LOGIN_TOO_LONG",utf8_encode("Le login ne peut pas comporter plus de 16 caract�res"));
	define("PASSWORD_EMPTY",utf8_encode("Vous devez introduire un password"));
	define("PASSWORD_TOO_SHORT",utf8_encode("Le mot de passe ne comporte pas assez de caract�re"));
	define("PASSWORD_TOO_LONG",utf8_encode("Le mot de passe ne peut pas comporter plus de 16 caract�res"));
	define("EMAIL_EMPTY",utf8_encode("Vous devez introduire un email"));
	define("EMAIL_FORMAT_INVALID",utf8_encode("Ceci n'est pas un format d'email valide"));
	define("EMAIL_ALREADY_EXIST",utf8_encode("L'adresse email introduite existe d�j�'"));
	define("EMAIL_TOO_LONG",utf8_encode("L'adresse email est trop longue'"));
	define("CONFIRM_PASSWORD_UNMATCH",utf8_encode("Votre mot de passe de confirmation ne correspond pas � votre mot de passe"));
	
	
		/*
		 * 	Validation  
		 */
		
	//si on a d�j� tent� d'envoyer une fois un formulaire, sinon, on s'en fou
	if( isset($_POST['isSubmitted']) && $_POST['isSubmitted'] == "true"){
		
		$valided = true;
		
		//formatage des donn�es 
		$user['login'] = htmlentities($_POST['login']);
		$user['password'] = htmlentities($_POST['password']);
		$user['passwordconfirm'] = htmlentities($_POST['passwordconfirm']);
		$user['email'] = htmlentities($_POST['email']);
		
			
		//on commence les tests 
				
		//1 : le login est-il vide?	
		if ( empty($user['login'])){ 
			$valided = false;
			$err_tab['login'] = LOGIN_EMPTY;			
		}
				
		//2 : le login est-il trop petit?
		else if (strlen($user['login']) < 3){
			$valided = false;
			$err_tab['login'] = LOGIN_TOO_SHORT;
			$_POST['login'] = '';
		}
		//3 : le login est-il trop grand?
		else if (strlen($user['login']) > 15){
			$valided = false;
			$err_tab['login'] = LOGIN_TOO_LONG;
			$_POST['login'] = '';
		}
		//3 bis : le nom de login est d�j� pris?		
		
		else if (Forum_Mysql::get_Forum_Mysql()->user_already_exist($user['login'])){
			$valided = false;
			$err_tab['login'] = LOGIN_ALREADY_EXIST;
		}
		//4 : le password est-il vide?		
		if ( empty($user['password'])){ 
			$valided = false;
			$err_tab['password'] = PASSWORD_EMPTY;
		}
		//5 : le password est-il trop petit?
		else if (strlen($user['password']) < 3){
			$valided = false;
			$err_tab['password'] = PASSWORD_TOO_SHORT;
			$_POST['password'] = '';
		}
		//6 : le password est-il trop grand?
		else if (strlen($user['password']) > 15){
			$valided = false;
			$err_tab['password'] = PASSWORD_TOO_LONG;
			$_POST['password'] = '';
		}
		
		//7 : le confirmpassword est-il le m�me que le password?
		if ($user['password'] != $user['passwordconfirm']){
			$valided = false;
			$err_tab['passwordconfirm'] = CONFIRM_PASSWORD_UNMATCH;
			$_POST['password'] = '';
			$_POST['passwordconfirm'] = '';
		}
				
		//8 : le email est-il vide?
		if ( empty($user['email'])){ 
			$valided = false;
			$err_tab['email'] = EMAIL_EMPTY;
		}		
		//9 : le email est-il en bon format?
		else if(! filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
			$valided = false;
			$err_tab['email'] = EMAIL_FORMAT_INVALID; 
			$_POST['email'] = '';
		}
		//9 bis : le email est-il trop long?
		else if (strlen($user['password']) > 50){
			$valided = false;
			$err_tab['email'] = EMAIL_TOO_LONG; 
			$_POST['email'] = '';
		}
		//10 : l'�mail est d�j� pris
		/*
		 * TO-DO
		 */	 		
		
		//on met en "post" la valeur de $valided
		$_POST['valided'] = $valided;

	}	
		 
		/*
		 * traitement
		 */
 	//si le formulaire est valid�
	if(isset($_POST['valided']) && $_POST['valided']){
		//on enregistre les data dans la base de donn�e
		mt_srand((float) microtime()*1000000);
		$code = mt_rand(1000000000, 9999999999);
		
		// note : si le formulaire est valid�, on assume que le tableau user est bien initalis�				
		$user['code'] = $code;
		$password = $user['password'];
		$user['password'] = md5($user['password']);
		
		$db = Forum_Mysql::get_Forum_Mysql();
		$db->register_user($user);
		
		//on envoi un mail de registration
		
		//g�n�ration du code
		 
		mt_srand((float) microtime()*1000000);
		$code = mt_rand(1000000000, 9999999999);
						
		Email::registerConfirmMail($user['email'],$user['login'],$password,$code);
	} 
	 
	/**
	 * �criture de la vue
	 */
	$display = '';
	
	//si le formulaire n'a pas d�j� �t� envoyer correctement
	if(! isset($_POST['valided']) || $_POST['valided'] == false){
		$display =  forumHeader()."\n".						
		      registerForm($err_tab)."\n".
		      forumFooter()."\n";
	}
	//si le formulaire a bien �t� envoy�
	else{
		$display =  forumHeader()."\n".						
		  	m_register_form_sent()."\n".
		  	forumFooter()."\n";		
	}
					
	/**
	 * affichage de la vue; 
	 */
	echo $display;
	
?>
