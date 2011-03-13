<?php
	/**
	 * import
	 */  	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/view/templates/Messages.php');	
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/model/DAO/ForumDataTools.php');
	require(RELATIVEAPPROOT.'/model/DAO/Mysql.php');
	
	/**
	 * controller
	 */  
	session_start();
	
	$forum_id = null;
	
	//si on recoit un forum id
	if(isset($_GET['id'])){
		$forum_id = htmlEntities($_GET['id']);
		if (is_numeric($forum_id)){// on s'assure que c'est bien un nombre
			$forumDataTools = new ForumDataTools();
						
			$forum = $forumDataTools->get_topic_list($forum_id);
				    			
		}
		else $forum_id = null;
	}				
	/**
	 * �criture de la vue
	 */
	$display = '';
	
	//si on recoit un forum id
	if($forum_id != null){	
		//si l'utilisateur est connect�
		if(isset($_SESSION['usersession']) && $_SESSION['usersession']->isConnected()){
			$display =  forumHeader()."\n".						
			  	forum_display($forum)."\n".
			  	forumFooter()."\n";	
		}		
		//si l'utilisateur n'est pas connect�
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
