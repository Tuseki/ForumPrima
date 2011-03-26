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
	$forum_id = null;	
	$ariane = null;
	$topic_list = null;
	$pagination = null;
	$forum = null;
		
	/**
	 * controller
	 */		
			
	//si on recoit un forum id 
	if(isset($_GET['id'])){
		$forum_id = htmlEntities($_GET['id']);
		$page = isset($_GET['page'])? htmlEntities($_GET['page']):1;
		
		if (is_numeric($forum_id) && is_numeric($page)){// on s'assure que c'est bien un nombre
			//si l'utilisateur est connecté
			if( $isConnected)
			{	
				$forumDataTools = new ForumDataTools();					
												
				$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_FORUM,$forum_id);
															
				$forum = $forumDataTools->get_forum($forum_id,$ariane[2]['name']);
																								
				//on va chercher les infos de pagination				
				$pagination = $forumDataTools->get_pagination($forum->getTopicList(),$page,NBRTOPICBYPAGE);
				//on va chercher la liste de topics à afficher											
				$topic_list = $forumDataTools->get_page($forum->getTopicList(),$page,NBRTOPICBYPAGE);	
																
				
			}	    			
		}				
	}			
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	//si on recoit les bons params
	if($forum!= null && $ariane != null){	
		//si l'utilisateur est connecté
		if($isConnected){
			$display =  forumHeader()."\n".						
			  	forum_display($forum->getForumId(),$forum->getForumName(),$topic_list,$ariane,$pagination)."\n".
			  	forumFooter()."\n";	
		}		
		//si l'utilisateur n'est pas connecté
		else{
			$display =  forumHeader()."\n".						
			  	m_user_not_connected()."\n".
			  	forumFooter()."\n";		
		}
	}
	//si on ne recoit pas de forum id
	else{		    
		    header('Location: ./index.php');
	}
		
	/**
	 * affichage de la vue; 
	 */
	echo $display;
	
?>
