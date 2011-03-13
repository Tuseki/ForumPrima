<?php
		/**
	 	 * import
	 	 */  
		require('../../Forumprima/config/Conf.php');
		require(RELATIVEAPPROOT.'/model/tools/connexionTools.php');
		require(RELATIVEAPPROOT.'/view/templates/Messages.php');
  		require(RELATIVEAPPROOT.'/view/templates/PageBody.php'); 
  		require(RELATIVEAPPROOT.'/view/templates/ConnexionForms.php');  		  		 		 		
 		
  		/**
		 * controller
	 	 */
	 	session_start();
	 	
	 	$isConnected = User_Connexion::is_already_Connected();	 	
	 	
	 	//si l'utilisateur est deja connect�
		if( $isConnected)
		{ 	
	 		User_Connexion::user_deconnexion();
		}	 			 	
	 	/**
	 	 * �criture de la vue
	 	 */ 
	 	 
	 	//si l'utilisateur n'est pas connect�
 	    if($isConnected == false){
 	    		$display = forumHeader()."\n".	
	  	 		m_user_not_connected()."\n".
	  	    	forumFooter()."\n";
 	    } 
	 	//si l'utilisateur est connect�
		else{	 	 
	 	$display = forumHeader(false)."\n".	
	  	 		m_user_deconnexion()."\n".
	  	    	forumFooter()."\n";	  	
		}	
  		/**
		 * affichage de la vue
		 */  
		echo $display;
?>
