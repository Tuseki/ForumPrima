
<?php
	
	/**
	 * import
	 */	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ForumDataTools.php');
	require(RELATIVEAPPROOT.'/model/tools/ConnexionTools.php');
	
    			
			
	/**
	 * controller
	 */
	session_start();	
	
	//on initalise la list des catégorie 	  	 	 	
	$forumDataTools = new ForumDataTools();
	$cat_list = $forumDataTools->get_cat_list();								
	$ariane = $forumDataTools->get_ariane(ForumDataTools::ARIANE_INDEX);	
	
	/**
	 * écriture de la vue
	 */
	 $display = forumHeader().	
	 cat_list_display($cat_list->getCatList(),$ariane).
	 ForumFooter();
	
	
	
	/**
	 * affichage de la vue 
	 */	 
	echo $display;
?>