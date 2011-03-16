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
	 
					
		//s'il y a une action 
		if(isset($_GET['action']) ){
			$action = htmlEntities($_GET['action']);
			if(is_string($action)){
				//si l'utilisateur est connecté
				if( $isConnected)
				{
					//si l'action est reply
					if($action == "reply")
					{	//on vérifie qu'on arrive sur cette page parce qu'il y a eu un "post"
						if(isset($_POST['id']) && isset($_POST['id'])){
							$post_text = utf8_decode(htmlspecialchars($_POST['text']));
							
							$topic_id = $_POST['id'];						
							$post_creator = User_Connexion::get_user_name();
																								
							$forumDataTools = new ForumDataTools();
							$forumDataTools->write_post($topic_id,$post_creator,$post_text);
							
							$_SESSION['topic_id'] = $topic_id;
							$_SESSION['action'] = $action;
						}
					}
					//si l'action est new
					if($action == "new")
					{
						//on vérifie qu'on arrive sur cette page parce qu'il y a eu un "post"
						if(isset($_POST['id']) && isset($_POST['topic_name']) && isset($_POST['text'])){
							$post_text = utf8_decode(htmlspecialchars($_POST['text']));
							$topic_name = utf8_decode(htmlspecialchars($_POST['topic_name']));
							$forum_id = $_POST['id'];
							
							$topic_creator = User_Connexion::get_user_name();
																		
							$forumDataTools = new ForumDataTools();
							$topic_id = $forumDataTools->write_topic($topic_name,$forum_id,$post_text,$topic_creator);														
							
							$_SESSION['forum_id'] = $forum_id;
							$_SESSION['topic_id'] = $topic_id;
							$_SESSION['action'] = $action;
						}																	
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
	 * affichage de la vue
	 */
	 
	// l'action est fini, on se redirige vers la page "vue" 
	header('Location: ./postSent.php');

	
?>
