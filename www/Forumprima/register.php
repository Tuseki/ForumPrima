<?php
	
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');
	require(RELATIVEAPPROOT.'/view/templates/RegisterForm.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');	
	require(RELATIVEAPPROOT.'/model/tools/registerTools.php');
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
	
		/*
		 * 	Validation  
		 */
	
	//si on a d�j� tent� d'envoyer une fois un formulaire, sinon, on s'en fou
	if( isset($_POST['isSubmitted']) && $_POST['isSubmitted'] == "true"){
		$registerTools = new RegisterTools();
		//formatage des donn�es 
		$user['login'] = htmlentities($_POST['login']);
		$user['password'] = htmlentities($_POST['password']);
		$user['passwordconfirm'] = htmlentities($_POST['passwordconfirm']);
		$user['email'] = htmlentities($_POST['email']);
				
		$_POST['valided'] = $registerTools->validation($user);
		$err_tab = $registerTools->get_err_tab();
		$user = $registerTools->getUser();				 		
	}			
 	//si le formulaire est valid�
 		/*
	 	 * resitration
 		 */
	if(isset($_POST['valided']) && $_POST['valided']){
		//on enregistre les data dans la base de donn�e
		$registerTools->registration($user);		
	}
	 
	/**
	 * �criture de la vue
	 */
	$display = '';
	
	//si le formulaire n'a pas d�j� �t� envoy� correctement
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
