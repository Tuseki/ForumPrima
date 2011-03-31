<?php

	function titleCanvas($title){
	 	$data  = '<div class="titre">'."\n".
				 '	<h2 style="font-size:1em">'.$title.'</h2>'."\n".
	  			 '</div>'."\n";
	 	
	 	return $data; 	       
	 }
	 function containerCanvas($innerData){
	 	$data  ='<div class="cadre">'."\n".	   		    
	   		    	$innerData."\n".			
	    	    '</div>'."\n"."\n";
	    
	    return $data;	
 	 } 
	 function table_lign($cell1,$cell2){
	 	$data = '';
 	 	$data = '<tr> '."\n".
 				'<td class="left" >'.$cell1.' : </td><td class="right">'.$cell2.'</td>'."\n".
 				'</tr>'."\n";
 				
	 	return $data;
	 }
	  function table_err($err_message){
	 	$data = '';
 	 	$data = '<tr> ' . 	 		 	
 				'	<td class="left" colspan=2>'."\n".
 				'	<p style="font-size:0.9em;color:#FF0000;">' ."\n".
 						$err_message."\n".
				'	</p></td >'."\n".
 				'</tr>'."\n";
 				
	 	return $data;
	 }
	 function table_title($title){
	 	$data = '';
 	 	$data = '<tr> ' .
 	 		 	
 				'	<td class="title" colspan=2>'."\n".
 				'	<p style="font-size:1.1em;">' ."\n".
 						$title.' : '."\n".
				'	</p></td >'."\n".
 				'</tr>'."\n";
 				
	 	return $data;
	 }
	
	 function profil_display($user,$err_message,$option = null){
	 		
	 	$data = '';
	 	$data .= titleCanvas("Profil")."\n";	 	
	 			
	 	$innerData ="<table cellspacing=0>"."\n";
	 	$innerData .= table_title("Informations"); 
	 	$innerData .= table_lign("Pseudo",$user->get_user_name())."\n";
	 	$innerData .= table_lign("Email",$user->get_email())."\n";
	 	
	 	if($option == null){
		 	$innerData .= table_title("Changement de mot de passe")."\n";
		 	$innerData .= '<FORM METHOD="POST" ACTION ="./profil.php" >'."\n"; 
		 	$innerData .= table_lign('Ancien mot de passe','<input name="oldpassword" type="password">')."\n";
		 	$innerData .= table_lign('Nouveau mot de passe','<input name="newpassword" type="password">')."\n";
		 	$innerData .= table_lign('Confirmation nouveau mot de passe','<input name="confirmoldpassword" type="password">')."\n";
		 	$innerData .= $err_message != null ? table_err($err_message): '';
		 	$innerData .= '<tr><td style="text-align:center;padding-top:5px;padding-bottom:5px;border-left:1px #FFFF00 SOLID;border-bottom:1px #FFFF00 SOLID;border-right:1px #FFFF00 SOLID" colspan=2><input type="submit" value="confirmer"></td></tr>'."\n";
		 	$innerData .='<input type ="hidden" name="changingpassword" value="true">'."\n";
		 	$innerData .='</FORM>'."\n";
	 	}
	 	$innerData .="</table>"."\n"; 	 		 
	 		 		 
	 	$data .= containerCanvas($innerData);
	 	
	 	return utf8_encode($data);
	 }	
?>
