
<?php
	
	/**
	 * import
	 */	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ForumDataTools.php');
	
    			
			
	/**
	 * controller
	 */
	session_start();	
	
	//on initalise la list des cat�gorie 	  	 	 	
	$forumDataTools = new ForumDataTools();
	$cat_list = $forumDataTools->get_cat_list();
				
	
	/**
	 * �criture de la vue
	 */
	 $display = forumHeader().	
	 cat_list_display($cat_list->getCatList()).
	 ForumFooter();
	
	
	
	/**
	 * affichage de la vue 
	 */	 
	echo $display;
?>