<?php
		/**
	 	 * import
	 	 */  
		require('../../Forumprima/config/Conf.php');
		require(RELATIVEAPPROOT.'/model/tools/connexionTools.php');
  		require(RELATIVEAPPROOT.'/view/templates/PageBody.php'); 
  		require(RELATIVEAPPROOT.'/view/templates/Messages.php');
  		require(RELATIVEAPPROOT.'/view/templates/ConnexionForms.php');
 		require(RELATIVEAPPROOT.'/model/DAO/mysql.php');
  		
  		
  		/**
		 * controller
	 	*/
	 	
	 	Define("WRONG_LOGIN",htmlentities("Nom d'utilisateur inconnu où mot de passe incorrecte")); 
	 	
	 	session_start();
	 	$err_message ='';	 		 		 
	    check_user_connexion();	 		 	
	    	    
	 	/**
	 	 * écriture de la vue
	 	 */ 
	 	 //si l'utilisateur n'est pas deja connecté
		 if( !isset($_SESSION['usersession']) || !$_SESSION['usersession']->isConnected())
		 { 
		 	 // si c'est la première tentative de connection
		 	 if(!isset($_POST['connexionvalided'])){
		 	 	$display = forumHeader()."\n".	
	  		 		connexionForm($err_message)."\n".
	  		    	forumFooter()."\n";	  		
		 	 }//si ce n'est pas le bon login/mdp 
		 	 else if ($_POST['connexionvalided'] == false){
		 	 	  $err_message = WRONG_LOGIN;
	  			$display = forumHeader()."\n".	
	  		 		connexionForm($err_message)."\n".
	  		    	forumFooter()."\n";	  		    		  		    
		 	 }
		 	 //si la demande de connexion est valide
		 	 else{		 	 			 	 
				forum_user_connexion();
																		
				header('Location: index.php');
		 	 }
		 }
		 //si l'utilisateur est déjà connecté
		 else {
			$display =  forumHeader()."\n".						
				  m_user_already_connected()."\n".
				  forumFooter()."\n";		
		 }
		 
  		/**
		 * affichage de la vue
		 */  
		 echo $display;
?>