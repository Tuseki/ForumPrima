<?php
/*
 * Created on 3 déc. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 function m_user_already_connected(){
 	$data = 
 		'<div>
			<br>
			Vous êtes déjà connecté sur ce forum.
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
  function m_user_not_connected(){
 	$data = 
 		'<div>
			<br>
			Vous ne pouvez pas accéder à cette page car vous n\'êtes pas connecté			
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
 function m_register_form_sent(){
 	$data = 
 		'<div>
			<br>Félicitation! Vous êtes désormais registré sur le forum de prima luce<br>
			Vous recevrez bientôt un mail de confirmation contenant vos données dans votre boite mail<br>
			Conservez le préscieusement car il nous sera impossible de vous les renvoyer<br>
			<br>			    
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.<br>										
		</div>';
			 
	return  utf8_encode($data);
 }
 function m_register_confirm(){
 	$data = 
 		'<div>
			<br>Félicitation! Votre compte est désormais actif<br>
			Cliquez <a href="./connexion.php">ici</a> pour vous connecter<br> 
			Pour revenir sur la page d\'accueil, cliquez <a href="./index.php">ici</a><br>
		</div>';
			 
	return  utf8_encode($data);
 }
 function m_post_sent($topic_id){
 		$data = 
 		'<div>
			<br>
			Votre réponse a été enregistrée
			<br>
			Cliquez <a href="./viewTopic.php?id='.$topic_id.'">ici</a> pour revenir sur le sujet				
		</div>';
			 
	return utf8_encode($data);
 }
 function m_topic_created($topic_id){
 	$data = 
 		'<div>
			<br>
			Votre sujet a été crée
			<br>
			Cliquez <a href="./viewTopic.php?id='.$topic_id.'">ici</a> pour revenir sur le sujet				
		</div>';
			 
	return utf8_encode($data);
 }

  function m_user_deconnexion(){
 	$data = 
 		'<div>
			<br>
			Vous avez été déconnecté.
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
 function m_illegal_action(){
 		$data = 
 		'<div>
			<br>
			Action invalide
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
 
?>
