<?php
	/**
	 * import
	 */	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/view/templates/Messages.php'); 
	require(RELATIVEAPPROOT.'/model/DAO/mysql.php');
	
		/*
		 * controller
	 	 */
	 	session_start();
	 	$err_message ='';	 
	 	
	 	$is_valided = false;		 		 
	    	
	    //si les param sont bien initialisé ... 	 		 	
	    if (isset($_GET['code']) &&  isset($_GET['login'])){
	 	 	$code = htmlentities($_GET['code']);
	 	 	$login = htmlentities($_GET['login']);
	 	 	
	 	 	// ... on vérifie si le code est correct avec celui dans la DB
	 	  	$db = Forum_Mysql::get_Forum_Mysql();
	 	  	$db->compare_user_code($login,$code);
	 	 	// si c'est le cas, on active le compte
	 	 	$db->set_user_active($login,true);
	 	 	$is_valided = true;
	 	 }	
	    	    
	 	/**
	 	 * écriture de la vue
	 	 */ 
	 	 //si on a pu valider le code
	 	 if ($is_valided){
	 	    $display = forumHeader()."\n".	
	  		m_register_confirm()."\n".
	  		forumFooter()."\n";	 	 
	 	 }
	 	 //sinon on a rien a faire la.
	 	 else {
	 	 	$display = forumHeader()."\n".	
	  		m_illegal_action()."\n".
	  		forumFooter()."\n";	
	 	 } 	 	 	 	 	 
		 
  		/**
		 * affichage de la vue
		 */  
		 echo $display;		
?>
