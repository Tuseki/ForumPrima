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
	
	/**
	 * init param
	 */	
	session_start();
	$isConnected = User_Connexion::is_already_Connected();
	$post = null;
	$action = null;
	$forum_id = null;
	
	/**
	 * controller
	 */		
			
		//s'il y a une action
		if(isset($_GET['action'])){
			$action = htmlEntities($_GET['action']);
			if(is_string($action)){
				//si l'utilisateur est connecté
				if( $isConnected)
				{
					//si l'action est reply
					if($action == "reply")
					{	
						$post_id = htmlEntities($_GET['id']);
						if(isset($post_id) && is_numeric($post_id)){
							//Debugg test			
							$text = htmlEntities("ceci est un message du topic");				
							$post = new Post();
							$post->setPostText($text);
							$post->setTopicName("re : topic");
						}				
					}
					//si l'action est new
					if($action == "new")
					{
						//debugg test
						$forum_id = 1;
						
						
					}
					//si l'action est edit
					if($action == "edit")
					{
						
					}	
				}		
			}
			else $action = null;
		}
	
			
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	//s'il y a une action
	if($action!= null){
		//si le user est connecté
		if($isConnected){
			//si l'action est reply
			if($action == "reply")
			{
  				$css_list[0] = "style_topic.css";
				$display =  forumHeader(true,$css_list)."\n".															
			  		post_display($post)."\n".
			  		forumFooter()."\n";		
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
	}
	//s'il y a pas d'action
	else {		    
		   echo $action;// header('Location: ./index.php');
	}
		
	/**
	 * affichage de la vue; 
	 */
	echo $display;
?>
