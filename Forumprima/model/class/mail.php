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
					    Vu que votre mot de passe est crypt� dans notre base de donn�e. Veuillez conserver pr�cieusement ce mail<br> 
					    <br>
					    Votre compte est pour le moment inactif. Afin de compl�ter votre inscription, veuillez cliquer sur ce lien :<br>	
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
		
		static function email_Password_Forgotten($email,$login,$password){
			//Message
			$message = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
						<head>
							<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />						
						</head>								
						<body>
						Bonjour ".$login."<br>
						<br>		
						Vous recevez ce message suite � une proc�dure de mot de passe oubli�<br>
						<br>
					    Voici votre nouveau mot de passe temporaire : ".$password." 
					    <br>
					    Pour choisir un nouveau mot de passe, allez dans votre profil et choissez un nouveau mot de passe					    
					    </body><html>";
					
			//Titre
			$titre = "Forum de Prima Luce : r�cup�ration de mot de passe";
			
			//From			
			$From  = "From: Forum Prima Luce \n";
			$From .= "MIME-version: 1.0\n";
			$From .= "Content-type: text/html; charset= iso-8859-1\n";
									
			mail($email, $titre, $message,$From);						
		}
	}
?>
