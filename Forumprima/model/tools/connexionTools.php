<?php
 function forum_user_connexion(){
 	$_SESSION['usersession'] = new ForumSession();
	$_SESSION['usersession']->connexion();
 }
 function check_user_connexion(){
 	if(isset($_POST['login']) && isset($_POST['password'])){ 	
 		$login = htmlEntities($_POST['login']);
 		$password = md5(htmlEntities($_POST['password']));
 		
 		$db = Forum_Mysql::get_Forum_Mysql();
 		if($db->check_user_password($login,$password)){
     	  		$_POST['connexionvalided'] = true;
 		}
 		else $_POST['connexionvalided'] = false;
 	}
 }
 function user_deconnexion(){ 	
	if(isset($_SESSION['usersession']) && $_SESSION['usersession']->isConnected()){
		session_destroy();		
	}	
 }
?>
