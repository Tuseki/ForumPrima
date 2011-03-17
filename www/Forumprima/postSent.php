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
 	$forum_id = null;
	$isConnected = User_Connexion::is_already_Connected();
	
	/**
	 * Controller 
	 */
	 // on vérifie qu'on est bien la suite à un post'
	if (isset($_SESSION['action'])){
		
		$action = $_SESSION['action'];
		if(is_string($action)){
			//si c'est une réponse de post
			if($action == "reply"){
				$topic_id = $_SESSION['topic_id'];		
				echo "topic id ".$topic_id;			
				unset($_SESSION['topic_id']);	
			}
			//si c'est la création d'un nouveau topic
			if($action == "new"){
				$forum_id = $_SESSION['forum_id'];
				$topic_id = $_SESSION['topic_id'];
				unset($_SESSION['forum_id']);						
				unset($_SESSION['topic_id']);
			}	
			if($action == "edit"){
				$topic_id = $_SESSION['topic_id'];								
				unset($_SESSION['topic_id']);	
			}
			unset($_SESSION['action']);
		} else $action = null;						
	}	
	
	
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
			//si on recoit bien un forum_id en post
			if($forum_id != null)
			{
				$css_list[0] = "style_topic.css";
				$display =  forumHeader(true,$css_list)."\n".															
		  		m_topic_created($topic_id)."\n".
		  		
		  		forumFooter()."\n";
			}
			//sinon, on a rien à faire la
			else {				
				$display =  forumHeader()."\n".						
		  		m_illegal_action()."\n".
		  		forumFooter()."\n";
			}
		}
		//si l'action est edit
		else if($action == "edit")
		{
			//si on recoit bien un post_id en post
			if($topic_id != null)
			{
				$css_list[0] = "style_topic.css";
				$display =  forumHeader(true,$css_list)."\n".															
		  		m_post_edited($topic_id)."\n".		  		
		  		forumFooter()."\n";
			}
			//sinon, on a rien à faire la
			else {				
				$display =  forumHeader()."\n".						
		  		m_illegal_action()."\n".
		  		forumFooter()."\n";
			}
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

