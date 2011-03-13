<?php
 //root pour le chemin absolut
  function get_parsed_ini_file(){
 	return parse_ini_file('settings.ini',TRUE);
 } 
 
 //Constante de configuration
 if ($settings = get_parsed_ini_file()) { 	
 	
 	//db constant
 	define ("DB_HOST",$settings['database']['host']); 
 	define ("DB_USER",$settings['database']['username']);
 	define ("DB_PASSWORD",$settings['database']['password']);
 	 		
 	//path constant
 	define ("APPNAME",$settings['path']['appname']);
 	define ("RELATIVEAPPROOT",$settings['path']['relativeapproot'].APPNAME); // special : pour les require
 	define ("WEBPATH", $_SERVER['DOCUMENT_ROOT'].'/'.APPNAME);
 	define ("APPPATH", $_SERVER['DOCUMENT_ROOT'].'/../'.APPNAME);
 	
 	//web
 	define ("WEBADRESSROOT",$settings['web']['webadressroot']); 	 	
 }
 	else echo 'Unable to open ' . $file . '.'; 
 
 //Message d'erreur
 define('ERR_IS_NOT_CO',utf8_encode('Vous ne pouvez pas accéder à cette page si vous n\'êtes pas connecté'));
 define('ERR_IS_CO',utf8_encode('Vous ne pouvez pas accéder à cette page ca vous êtes déjà connecté'));
 define('INVALID_PARAM',utf8_encode('Erreur interne : Les paramètres pour l\'appel de ce script n\'ont pas été correctement initialisé'));
 
 //fonction d'erreur 
 function erreur($err='')
 {
   $mess=($err!='')? $err:'Une erreur inconnue s\'est produite';
   exit('<p>'.$mess.'</p>
   <p>Cliquez <a href="./index.php">ici</a> pour revenir à la page d\'accueil</p></div></body></html>');
 } 
 
?>
