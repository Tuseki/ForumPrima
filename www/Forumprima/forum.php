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
	$forum_id = null;
		
	/**
	 * controller
	 */		
			
	//si on recoit un forum id
	if(isset($_GET['id'])){
		$forum_id = htmlEntities($_GET['id']);
		if (is_numeric($forum_id)){// on s'assure que c'est bien un nombre
			//si l'utilisateur est connecté
			if( $isConnected)
			{	
				$forumDataTools = new ForumDataTools();					
												
				$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_FORUM,$forum_id);
				$forum = $forumDataTools->get_forum($forum_id,$ariane[2]['name']);
			}	    			
		}	
		else $forum_id = null;		
	}			
	
	/**
	 * écriture de la vue
	 */
	$display = '';
	
	//si on recoit un forum id
	if($forum_id != null){	
		//si l'utilisateur est connecté
		if($isConnected){
			$display =  forumHeader()."\n".						
			  	forum_display($forum,$ariane)."\n".
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
