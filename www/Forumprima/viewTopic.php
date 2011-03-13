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
				//Debugg test
				
				$text1 = htmlEntities("ceci est un message du topic");
				$text2 = htmlEntities("ceci est un autremessage du topic");
				$text3 = htmlEntities("Non mais vous arrêter de flooder bande de boulz? C'est pas possible d'avoir des gens aussi con sur un forum bordel! on se croirait sur les fofo blizzard");
				$text4 = htmlEntities("Non mais tg toi!");
				
				$post_list[0] = new Post();
				$post_list[0]->setPostId("1");
				$post_list[0]->setPostText($text1);
				$post_list[1] = new Post();
				$post_list[1]->setPostId("2");
				$post_list[1]->setPostText($text2);
				$post_list[2] = new Post();
				$post_list[2]->setPostId("3");
				$post_list[2]->setPostText($text3);
				$post_list[3] = new Post();
				$post_list[3]->setPostId("4");
				$post_list[3]->setPostText($text4);
				
				
				$topic= new topic();
				$topic->setTopicName("Nom du topic");
				$topic->setPostList($post_list);
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
			  	topic_display($topic)."\n".
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
