<?php
	class Email{
		static function registerConfirmMail($email,$login,$password,$code){
			//Message
			$message = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
						<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />						
						</head>								
						<body>
						Bienvenue sur le forum de prima luce !<br>
						<br>
					    Pour rappel, voici votre login et mot de passe.<br> 
					    <br>
					    Votre login : ".$login."<br>
					    Votre mot de passe : ".$password."<br> 
					    <br>
					    Vu que votre mot de passe est crypté dans notre base de donnée. Veuillez conserver précieusement ce mail<br> 
					    <br>
					    Votre compte est pour le moment inactif. Afin de compléter votre inscription, veuillez cliquer sur ce lien :<br>	
					    <a href = '".WEBADRESSROOT."/registration_confirmation.php?code=".$code."&login=".$login."'>".WEBADRESSROOT."/registration_confirmation.php?code=".$code."&login=".$login."</a>"
					    ."</body><html>";
					
			//Titre
			$titre = "Votre inscription au forum de Prima Luce !";
			
			//From			
			$From  = "From: Forum Prima Luce \n";
			$From .= "MIME-version: 1.0\n";
			$From .= "Content-type: text/html; charset= iso-8859-1\n";
									
			mail($email, $titre, $message,$From);						
		}
	}
?>
