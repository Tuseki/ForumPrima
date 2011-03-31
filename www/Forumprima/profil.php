<?php
/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');	
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ProfilTools.php');
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/model/class/user.php');
	require(RELATIVEAPPROOT.'/model/tools/ProfileTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');
	
	/**
	 * init param
	 */
	session_start();
	$isConnected = User_Connexion::is_already_Connected();	 
	$profile = null;
	$changingpassword = false;
	$err_message = null;
		
	/**
	 * controller
	 */		
	 if( $isConnected)
	 {	
	 		 		 
 		$user_id = User_Connexion::get_user_id();	 	
 		$profileTools = new ProfileTools(); 
 		$profile = $profileTools->get_user($user_id);
	 	
	 	if (isset($_POST['changingpassword']) && $_POST['changingpassword'] == "true"){
	 		if(isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmoldpassword'])){
		 		$oldpassword = htmlEntities($_POST['oldpassword']);
		 		$newpassword = htmlEntities($_POST['newpassword']);
		 		$confirmoldpassword = htmlEntities($_POST['confirmoldpassword']);
		 		
		 		$profileTools = new ProfileTools();
		 		
		 		$changingpassword = $profileTools->validate_new_password($oldpassword,$newpassword,$confirmoldpassword,$err_message);
		 		if($changingpassword){
		 			$profileTools->set_user_password($user_id,$newpassword);
		 		}
	 		}
	 	}
	 		 		 
	 } 
	 
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	if($isConnected){
		if($changingpassword == false)
		{
			if ($profile != null){
				$css_list[0] = "style_profile.css";
				$display =  forumHeader(true,$css_list)."\n".						
				  	profil_display($profile,$err_message)."\n".			  	
				  	forumFooter()."\n";	
			}
			else{
				erreur("impossible de trouver le profil de l'utilisateur");
			} 	
		}
		else {
			
			$display =  forumHeader()."\n".						
				  	m_passwordchanged()."\n".			  	
				  	forumFooter()."\n";	
		}
	}
	else{					
		$display =  forumHeader()."\n".						
		  	m_user_not_connected()."\n".			  	
		  	forumFooter()."\n";			
	}
	
	/**
	 * affichage de la vue; 
	 */
	echo $display;
?>
