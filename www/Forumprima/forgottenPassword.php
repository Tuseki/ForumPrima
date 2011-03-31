<?php
	
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');
	require(RELATIVEAPPROOT.'/view/templates/ForgottenPasswordForm.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/model/tools/ForgottenPasswordTools.php');		
	require(RELATIVEAPPROOT.'/model/class/mail.php');
	require(RELATIVEAPPROOT.'/model/class/user.php');
	
	/**
	 * controller
	 */  
	session_start();
	$done = false;
	$err = null;
	
	if(isset($_POST['email'])){
		$email = htmlentities($_POST['email']);
		$forgottenTools = new ForgottenPasswordTools();
		$done = $forgottenTools->forgotten_password($email,$err);
			
	}
		
	/**
	 * écriture de la vue
	 */
	$display = '';
	if($done == false){
		
		$display =  forumHeader()."\n".						
			  	forgottenPassword($err)."\n".
			  	forumFooter()."\n";	
	}
	else{
		$display =  forumHeader()."\n".						
			  	m_new_password_sent()."\n".
			  	forumFooter()."\n";	
	}
					
	/**
	 * affichage de la vue; 
	 */
	echo $display;
	
?>
