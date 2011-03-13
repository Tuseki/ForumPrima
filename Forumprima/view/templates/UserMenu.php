<?php

 require(APPPATH.'/model/class/Session.php');  	

 function userMenu(){ 	 	 	
 	if(isset($_SESSION['usersession']) 
 			&& $_SESSION['usersession']->isConnected()){
 		return menuConnected();
 	}
 	else{
 		return menuDisconnected();
 	}
 }
 function menuConnected(){
 	$data =		
 		menuLink('Accueil','index.php').
 		'	&nbsp -  &nbsp'."\n". 
 		menuLink('Deconnexion','./deconnexion.php');
 		
 	return $data;		
 }
 function menuDisconnected(){
 	$data =				
 		menuLink('Accueil','index.php').
 		'	&nbsp -  &nbsp'."\n".
 		menuLink('Connexion','connexion.php'). 
 		'	&nbsp -  &nbsp'."\n". 
 		menuLink('S\'inscrire','register.php');  
 		
 	return $data;
 }
 function menuLink($texte,$href){
 	$data = 
 		'	<img src="ressources/image/puces/square.gif" style="vertical-align: middle;"/>'."\n".
 		'	<a class="menu" href="'.$href.'">'.$texte.'</a>'."\n";
 	return $data; 	
 } 
 
?>
