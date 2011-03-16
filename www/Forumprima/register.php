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
	
	//si on a déjà tenté d'envoyer une fois un formulaire, sinon, on s'en fou
	if( isset($_POST['isSubmitted']) && $_POST['isSubmitted'] == "true"){
		$registerTools = new RegisterTools();
		//formatage des données 
		$user['login'] = utf8_decode(htmlspecialchars($_POST['login']));
		$user['password'] = utf8_decode(htmlspecialchars($_POST['password']));
		$user['passwordconfirm'] = utf8_decode(htmlspecialchars($_POST['passwordconfirm']));
		$user['email'] = utf8_decode(htmlspecialchars($_POST['email']));
		
		
		
				
		$_POST['valided'] = $registerTools->validation($user);
		$err_tab = $registerTools->get_err_tab();
		
		$user = $registerTools->getUser();		
		
				 		
	}			
 	//si le formulaire est validé
 		/*
	 	 * resitration
 		 */
	if(isset($_POST['valided']) && $_POST['valided']){
		//on enregistre les data dans la base de donnée
		//$registerTools->registration($user);		
	}
	 
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	//si le formulaire n'a pas déjà été envoyé correctement
	if(! isset($_POST['valided']) || $_POST['valided'] == false){
		$display =  forumHeader()."\n".						
		      registerForm($err_tab)."\n".
		      forumFooter()."\n";
	}
	//si le formulaire a bien été envoyé
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
