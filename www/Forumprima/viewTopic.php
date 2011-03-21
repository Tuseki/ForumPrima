<?php
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');	
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/model/tools/ForumDataTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');
	
	
	
	/**
	 * init param
	 */
	 
	session_start();
	$isConnected = User_Connexion::is_already_Connected();	 
	$topic_id = null;
	/**
	 * controller
	 */
			
	//si on recoit un topic id
	if(isset($_GET['id'])){
		$topic_id = htmlEntities($_GET['id']);
		if (is_numeric($topic_id)){// on s'assure que c'est bien un nombre		
			//si l'utilisateur est connecté
			if( $isConnected)
			{					
				$forumDataTools = new ForumDataTools();				
				$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_TOPIC,$topic_id);
								
				$topic = $forumDataTools->get_topic($topic_id,$ariane[3]["name"]);								
			}
		}
		else $topic_id = null;
	}		
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	//si on recoit un topic id
	if($topic_id != null){	
		//si l'utilisateur est connecté		
		if($isConnected){
			$css_list[0] = "style_topic.css";
			$display =  forumHeader(true,$css_list)."\n".						
			  	topic_display($topic,$ariane)."\n".
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
		    header('Location: ./index.php');
	}
	/**
	 * affichage de la vue; 
	 */
	echo $display;
?>
