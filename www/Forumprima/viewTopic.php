<?php
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');	
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/model/class/Pagination.php');
	require(RELATIVEAPPROOT.'/model/tools/ForumDataTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');
	
	
	/**
	 * init param
	 */
	 
	session_start();
	$isConnected = User_Connexion::is_already_Connected();	 
	$topic_id = null;
	$post_list = null; //contient les posts d'un topic
	$pagination = null;
	$ariane = null;
	$topic = null;
	/**
	 * controller
	 */
	//si on recoit un topic id 
	if(isset($_GET['id'])){
		$topic_id = htmlEntities($_GET['id']);
		$page = isset($_GET['page'])? htmlEntities($_GET['page']):1;
		if (is_numeric($topic_id) && is_numeric($page)){// on s'assure que ce sont bien un nombre		
			//si l'utilisateur est connecté
			if( $isConnected)
			{					
				$forumDataTools = new ForumDataTools();				
				$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_TOPIC,$topic_id);
				
												
				$topic = $forumDataTools->get_topic($topic_id,$ariane[3]["name"]);
				
				//on va chercher les infos de pagination				
				$pagination = $forumDataTools->get_pagination($topic->getPostList(),$page,NBRPOSTBYPAGE);
				//on va chercher la liste de posts à afficher											
				$post_list = $forumDataTools->get_page($topic->getPostList(),$page,NBRPOSTBYPAGE);	
				
				
				
			
			}
		}		
	}		
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	
	if ($topic == null) echo "topic <br>";
	if ($post_list == null) echo "post_list <br>";
	if ($pagination == null) echo "pagination <br>";
	if ($ariane == null) echo "ariane <br>";
	
	
	//si on recoit les bons params
	if($topic!= null && $ariane != null){	
		//si l'utilisateur est connecté		
		if($isConnected){
			$css_list[0] = "style_topic.css";
			$display =  forumHeader(true,$css_list)."\n".						
			  	topic_display($topic->getTopicId(),$topic->getTopicName(),$post_list,$ariane,$pagination)."\n".
			  	forumFooter()."\n";	
		}		
		//si l'utilisateur n'est pas connecté
		else{
			$display =  forumHeader()."\n".						
			  	m_user_not_connected()."\n".
			  	forumFooter()."\n";		
		}
	}
	//si on a pas de topic id
	else{		    
		 //   header('Location: ./index.php');
	}
	/**
	 * affichage de la vue; 
	 */
	echo $display;
?>
