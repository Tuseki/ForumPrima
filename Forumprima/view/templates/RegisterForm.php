<?php
/*
 * Cette fonction affiche un formulaire de registration 
 * 
 * Le parametre est un tableau contenant les erreurs d'une éventuelle
 * tentative d'inscription echouée
 * 
 */
 function registerForm($err_tab){ 	
 	//on vérifie si des champs n'ont pas déjà été rempli
 	
 	if(!isset ($_POST['login'])) $_POST['login'] = ''; 
 	if(!isset ($_POST['password'])) $_POST['password'] = '';
 	if(!isset ($_POST['passwordconfirm'])) $_POST['passwordconfirm'] = '';
 	if(!isset ($_POST['email'])) $_POST['email'] = '';
 	
 	if(isset($err_tab) && 
 			isset($err_tab['login'])
 			& isset($err_tab['password'])
 			& isset($err_tab['passwordconfirm'])
 			& isset($err_tab['email']) ){ //on vérifie que le params a bien été initalisé		 	 		 		 	
	 	$data =
	 	'<br>
	 	<FORM ACTION="./register.php" METHOD="post">
	    	<div>
		        	<p class="forms"><table style="margin:auto">
		            	<tr>
		                   <td style="float:left">Login</td>
		                   <td><input type="text" name="login" value = '.$_POST['login'].'></td>		 		                  
		               </tr>'."\n";
		$data .= '     <tr><td colspan="2"><span class="error">'.$err_tab['login'].'</span></td></tr>';		               
		$data .= ' 	   <tr>
			               <td style="float:left">Mot de passe</td>
		                   <td><input type="password" name="password" value = '.$_POST['password'].'></td>
		     			</tr>'."\n";
		$data .= '     <tr><td colspan="2"><span class="error">'.$err_tab['password'].'</span></td></tr>';		     			
	    $data .= '      <tr>
			               <td style="float:left">Confirmer le mot de passe</td>
		                   <td><input type="password" name="passwordconfirm" value = '.$_POST['passwordconfirm'].'></td>
		 				</tr>'."\n";
	    $data .= '     <tr><td colspan="2"><span class="error">'.$err_tab['passwordconfirm'].'</span></td></tr>';
	    $data .= '       <tr>
			               <td style="float:left">Email</td>
		                   <td><input type="text" name="email" value = '.$_POST['email'].'></td>
		               </tr>
					 </table>'."\n";
		$data .= '     <tr><td colspan="2"><span class="error">'.$err_tab['email'].'</span></td></tr>';			 
		$data .= '</p> 
			  <br>		
	       	  <input type="hidden" name="isSubmitted" value="true">
	       	  <input type="submit" value="S\'enregister">
	    	</div>
	    </FORM>'."\n";
	 	 	 	 	
	 	return $data;	 	
 	}
 	else erreur(INVALID_PARAM);
 }
?>
