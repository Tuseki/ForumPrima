<?php


function forgottenPassword($err){
	$data = '';	
	$data = '<br><p>' .
			"Vous avez oublié votre mot de passe?<br>Introduisez votre email et un nouveau mot de passe vous sera envoyé par mail<br><br>".
			'</p>';
	$data .= '<FORM METHOD="POST" ACTION = "./forgottenPassword.php">' ."\n".
			'<div><table style="margin:auto">' ."\n".
			'<tr>' ."\n".
			'	<td>Email</td>'."\n".
			'   <td><input type="text" name="email"></td>' ."\n".
			'</tr>'."\n";
    $data .= $err != null ?'<tr><td colspan=2><p style="font-size:0.9em;color:#FF0000;">'.$err.'</p></td></tr>'."\n" :'';
    $data .= '<tr>' ."\n";
    
	$data.= '   <td style="padding-top:10px" colspan=2><input type="submit" value="envoyer nouveau mot de passe"</td>'."\n".
			'</tr>'."\n".
			'</table></div>'."\n".
			'</FORM>'."\n";
		 	
 	return utf8_encode($data);
}
?>
