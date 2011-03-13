<?php
	/**
	 * import
	 */	
	require('../../Forumprima/config/Conf.php');	  	
	require(RELATIVEAPPROOT.'/model/class/ForumTreeClasses.php');
	require(RELATIVEAPPROOT.'/view/templates/PageBody.php');
	require(RELATIVEAPPROOT.'/view/templates/ForumDisplayTools.php');
	require(RELATIVEAPPROOT.'/view/templates/Messages.php'); 
	require(RELATIVEAPPROOT.'/model/tools/Registertools.php');
	
		/**
		 * init param
	 	 */
	 	session_start();	 		 	 
	 	$isValided = false;		 		 
	 		    
	    /**
		 * controller
	 	 */	
	    //si les param sont bien initialisé ... 	 		 	
	    if (isset($_GET['code']) &&  isset($_GET['login'])){
	 	 	$code = htmlentities($_GET['code']);
	 	 	$login = htmlentities($_GET['login']);
	 	 	$registerTools = new RegisterTools();
	 	 	$isValided = $registerTools->activate_user($login,$code);	 	 	
	 	 }	
	    	    
	 	/**
	 	 * écriture de la vue
	 	 */ 
	 	 //si on a pu valider le code
	 	 if ($isValided){
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
