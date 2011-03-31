<?php

 function connexionForm($err_message){
	 	
 	$data = 
 		'<br>'."\n".
 		'<FORM ACTION="./connexion.php" METHOD="POST"><br>'."\n".
 		'	<div><p>'."\n".
 		'	<span class="error">'.$err_message.'</span>'."\n".
	    '    	<table style="margin:auto">'."\n".
	    '        	<tr>'."\n".
	    '            	<td style="float:left">Login</td>'."\n".
	    '               <td><input type="text" name="login"></td>'."\n".
	    '           </tr>'."\n".
	    '			<tr>'."\n".
		'               <td style="float:left">Mot de passe</td>'."\n".
	    '               <td><input type="password" name="password"></td>'."\n". 	   
		'           </tr>'."\n".	               	               
		'		</table>'."\n".
		'		<br>'."\n".			
	    '      	<input type="submit" value="Connexion">'."\n".	    
	    '	<br>' .
		'	Pas encore inscrit? Inscrivez-vous <a href="./register.php">ici</a><br>' .			
		'	Mot de passe oublié? Cliquez ici <a href="./forgottenPassword.php">ici</a>' .
		'</p></div>'."\n".
 		'</FORM>'."\n";  			 	 
 	return utf8_encode($data);
 }
?>
