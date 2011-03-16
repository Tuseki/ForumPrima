<?php
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
	$postText = null;
	$action = null;
	$topic_id = null;
	
	/**
	 * controller
	 */
	 
	//on vérifie qu'on arrive sur cette page parce qu'il y a eu un "post"
	if(isset($_POST['topic_id']) && isset($_POST['topic_id'])){				
		//s'il y a une action 
		if(isset($_GET['action']) ){
			$action = htmlEntities($_GET['action']);
			if(is_string($action)){
				//si l'utilisateur est connecté
				if( $isConnected)
				{
					//si l'action est reply
					if($action == "reply")
					{	
						$post_text = utf8_decode(htmlspecialchars($_POST['text']));
						
						$topic_id = $_POST['topic_id'];						
						$post_creator = User_Connexion::get_user_name();
																							
						$forumDataTools = new ForumDataTools();
						$forumDataTools->write_post($topic_id,$post_creator,$post_text);
																		
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
	}
	/**
	 * affichage de la vue
	 */
	 
	$_SESSION['topic_id'] = $topic_id;
	$_SESSION['action'] = $action;
	
	// l'action est fini, on se redirige vers la page "vue" 
	header('Location: ./postSent.php');

	
?>
