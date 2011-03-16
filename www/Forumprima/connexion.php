<?php
		/**
	 	 * import
	 	 */  
		require('../../Forumprima/config/Conf.php');		
  		require(RELATIVEAPPROOT.'/view/templates/PageBody.php'); 
  		require(RELATIVEAPPROOT.'/view/templates/Messages.php');
  		require(RELATIVEAPPROOT.'/view/templates/ConnexionForms.php'); 		 		
 		require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');
 		
  		DEFINE ("WRONG_LOGIN",htmlentities("Nom d'utilisateur inconnu o� mot de passe incorrecte"));
  		
  		/**
		 * controller
	     */	 		 	 	 	
	 	session_start();
	 	
	 	$isConnected = User_Connexion::is_already_Connected();	 	
	 	
	 	//si l'utilisateur n'est pas deja connect�
		if( $isConnected == false)
		{
		 	$err = '';
		 	
		 	//valide la connexion	 		 
		 	if(isset($_POST['login']) && isset($_POST['password'])){
				$login = htmlEntities($_POST['login']);
	 			$password = htmlEntities($_POST['password']);
		    	$_POST['connexionvalided'] = User_Connexion::user_connexion_attempt($login,$password);	 		 	
		    }    
		      
		    	    
		    //si la demande connexion est invalide 
		    if (isset($_POST['connexionvalided']) && $_POST['connexionvalided'] == false)    
		    	$err = WRONG_LOGIN;	    
		    //	sinon 
		    else if (isset($_POST['connexionvalided']) && $_POST['connexionvalided'] == true) 
		    	//si la connexion est valide, le login est forc�ment bon, donc on ne v�rifie pas sa valeur
		    	User_Connexion::forum_user_connexion($login);
		 }
	    
	    
	 	/**
	 	 * �criture de la vue
	 	 */ 
	 	 //si l'utilisateur n'est pas deja connect�
		 if( $isConnected == false)
		 {
		 	//si la connexion est invalide
		 	if(!isset($_POST['connexionvalided']) || ($_POST['connexionvalided'] == false)){
		 					 				 		
		 		$display = forumHeader()."\n".
	  			connexionForm($err)."\n".
	  			forumFooter()."\n";	
		 	}		 	
	  		//si la demande de connexion est valide
		 	 else{ 	 			 	 																						
				header('Location: index.php');
		 	 }
		 }
		 //si l'utilisateur est d�j� connect�
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