<?php
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');	
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');	
	require(RELATIVEAPPROOT.'/model/tools/ForumDataTools.php');
	
	
	/**
	 * init param
	 */	
 	session_start();
 	
 	$action = null;
 	$topic_id = null;
	$isConnected = User_Connexion::is_already_Connected();
	if (isset($_SESSION['action']) && isset($_SESSION['topic_id'])){	
		$action = $_SESSION['action'];
		$topic_id = $_SESSION['topic_id'];		
		unset($_SESSION['action']);
		unset($_SESSION['topic_id']);				
	}	
		
	
	/**
	 * Pas de controller car il ne s'agit ici que d'envoyer un message 
	 */
	
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	

	//si le user est connecté
	if($isConnected){
		//si l'action est reply
		if($action == "reply")
		{
			//si on recoit bien un topic_id en post
			if($topic_id != null){						
				$css_list[0] = "style_topic.css";
				$display =  forumHeader(true,$css_list)."\n".															
		  		m_post_sent($topic_id)."\n".
		  		forumFooter()."\n";
			}	
			//sinon, on a rien à faire la
			else {				
				$display =  forumHeader()."\n".						
		  		m_illegal_action()."\n".
		  		forumFooter()."\n";
			}	
		}
		//si l'action est new
		else if($action == "new")
		{
		
		}
		//si l'action est edit
		else if($action == "edit")
		{
			
		}	
		else {			
			$display =  forumHeader()."\n".						
		  	m_illegal_action()."\n".
		  	forumFooter()."\n";		
		}
	}
	//si l'utilisateur n'est pas connecté		
	else {
		$display =  forumHeader()."\n".						
		m_user_not_connected()."\n".
		forumFooter()."\n";	
	} 

		
	/**
	 * affichage de la vue; 
	 */
	echo $display;
?>

