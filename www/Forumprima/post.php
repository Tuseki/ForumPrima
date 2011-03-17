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
	$isConnected = User_Connexion::is_already_Connected();
	$post = null;
	$post_id = null;
	$topic_id = null;
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
						$post_id = htmlEntities($_GET['post_id']);
						$topic_id = htmlEntities($_GET['topic_id']);
						if(isset($post_id) && is_numeric($post_id)){
							if(isset($topic_id) && is_numeric($topic_id)){
								$forumDataTools = new ForumDataTools();
								$post = $forumDataTools->get_post($post_id);																																								
								$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_TOPIC,$topic_id);								
								//data pour l'affichage du post auquel l'utilisateur répond
								$post->setPostId($post->getPostId());
								$post->setTopicId($topic_id);
								$post->setPostText($post->getPostText());
								$post->setTopicName($post->getTopicName());		
							}
						}				
					}
					//si l'action est new
					if($action == "new")
					{						
						if(isset($_GET['id']) && is_numeric($_GET['id'])){
							$forum_id = htmlEntities($_GET['id']);
							$forumDataTools = new ForumDataTools();
							$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_FORUM,$forum_id);
						}														
					}
					//si l'action est edit
					if($action == "edit")
					{
						$post_id = htmlEntities($_GET['post_id']);
						$topic_id = htmlEntities($_GET['topic_id']);
						if(isset($post_id) && is_numeric($post_id)){
							if(isset($topic_id) && is_numeric($topic_id)){
								$forumDataTools = new ForumDataTools();
								$post = $forumDataTools->get_post_foredit($post_id);																																								
								$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_TOPIC,$topic_id);								
								//data pour le post que l'utilisateur edit
								$post->setPostId($post->getPostId());
								$post->setTopicId($topic_id);
								$post->setPostText($post->getPostText());
								$post->setTopicName($post->getTopicName());								
							}
						}	
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
				//si l'objet post a été initalisé
				if($post!= null){
  					$css_list[0] = "style_topic.css";
					$display =  forumHeader(true,$css_list)."\n".															
			  		post_display($post,$action,$ariane,$post->getTopicId())."\n".
			  		forumFooter()."\n";
				}
				//sinon, on a rien à faire la
				else{
					$display =  forumHeader()."\n".						
			  		m_illegal_action()."\n".
			  		forumFooter()."\n";		
				}
			}
			//si l'action est new
			else if($action == "new")
			{
				//si on recoit bien un forum_id
				if($forum_id != null){
					$css_list[0] = "style_topic.css";
					$display =  forumHeader(true,$css_list)."\n".															
			  		post_display(null,$action,$ariane,$forum_id)."\n".
			  		forumFooter()."\n";
				}
				//sinon, on a rien à faire la
				else{
					
					$display =  forumHeader()."\n".						
			  		m_illegal_action()."\n".
			  		forumFooter()."\n";		
				}
			}
			//si l'action est edit
			else if($action == "edit")
			{
				$css_list[0] = "style_topic.css";
				$display =  forumHeader(true,$css_list)."\n".															
			  	post_display($post,$action,$ariane,$post->getPostId())."\n".
			  	forumFooter()."\n";
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
