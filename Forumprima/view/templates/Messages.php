<?php
/*
 * Created on 3 d�c. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 function m_user_already_connected(){
 	$data = 
 		'<div>
			<br>
			Vous �tes d�j� connect� sur ce forum.
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
  function m_user_not_connected(){
 	$data = 
 		'<div>
			<br>
			Vous ne pouvez pas acc�der � cette page car vous n\'�tes pas connect�			
			<br>
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.				
		</div>';
			 
	return utf8_encode($data);
 }
 function m_register_form_sent(){
 	$data = 
 		'<div>
			<br>F�licitation! Vous �tes d�sormais registr� sur le forum de prima luce<br>
			Vous recevrez bient�t un mail de confirmation contenant vos donn�es dans votre boite mail<br>
			Conservez le pr�scieusement car il nous sera impossible de vous les renvoyer<br>
			<br>			    
			Cliquez <a href="./index.php">ici</a> pour revenir sur la page d\'accueil.<br>										
		</div>';
			 
	return  utf8_encode($data);
 }
 function m_register_confirm(){
 	$data = 
 		'<div>
			<br>F�licitation! Votre compte est d�sormais actif<br>
			Cliquez <a href="./connexion.php">ici</a> pour vous connecter<br> 
			Pour revenir sur la page d\'accueil, cliquez <a href="./index.php">ici</a><br>
		</div>';
			 
	return  utf8_encode($data);
 }
 function m_post_sent($topic_id){
 		$data = 
 		'<div>
			<br>
			Votre r�ponse a �t� enregistr�e
			<br>
			Cliquez <a href="./viewTopic.php?id='.$topic_id.'">ici</a> pour revenir sur le sujet				
		</div>';
			 
	return utf8_encode($data);
 }
 function m_topic_created($topic_id){
 	$data = 
 		'<div>
			<br>
			Votre sujet a �t� cr�e
			<br>
			Cliquez <a href="./viewTopic.php?id='.$topic_id.'">ici</a> pour revenir sur le sujet				
		</div>';
			 
	return utf8_encode($data);
 }

  function m_user_deconnexion(){
 	$data = 
 		'<div>
			<br>
			Vous avez �t� d�connect�.
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
