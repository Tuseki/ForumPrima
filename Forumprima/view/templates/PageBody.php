<?php
	require('UserMenu.php');
	function forumHeader($usermenu=true,$css_list=null){
		$data = 
			'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Forum Prima Luce</title>
				<link href="ressources/css/style_index.css" rel="stylesheet" type="text/css" />';
		if ($css_list != null) foreach($css_list AS $index => $css_file){
			$data .= ' <link href="ressources/css/'.$css_file.'" rel="stylesheet" type="text/css" />';
		}	
		$data .='
		    </head>
			<body>						
				<div id="content">
				   <div id="banner"></div>		
	        	   <div id="welcome">
			           <h1 style="font-size:1.5em;">Forum de la guilde Prima Luce (Serveur EU-Garona)</h1>
			       </div>';
		if($usermenu == true){			       
			$data .=' 	<div style="margin:auto">'."\n".
		     			   usermenu()."\n".
		           '  	</div>'."\n";
		}
	    return $data;
	}

	function forumFooter(){
		$data = 
			'	</div>
			</body>
			</html>';
		return $data;			
	}
?>