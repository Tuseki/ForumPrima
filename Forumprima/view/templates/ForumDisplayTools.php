<?php

  function titleCanvas($title){
 	$data  = '<div class="titre">'."\n".
			 '	<h2 style="font-size:1em">'.$title.'</h2>'."\n".
  			 '</div>'."\n";
 	
 	return $data; 	       
 }
 function subjectCanvas($topicName,$topic_id,$type='forum'){
 	$data  ='<div class="cadre">'."\n".
   		    '	<p style="font-size:0.9em;text-align:left;"><a href="'.$type.'.php?id='.$topic_id.'&page=1">'.$topicName.'</a></p>'."\n".
    	    '</div>'."\n";
    
    return $data;
 }
 function topicTitleCanvas($title){
  $data = '
  		<div class="topictitre" style="margin-left:15px">
            	<h2 style="font-size:1em">'.$title.'</h2>
         </div>';
         		    
  return $data;
 }
 function postCanvas($post,$mustShowMenu=true){
	$data = '';

 	$data .= '   <div><table cellspacing=0 cellpadding=0><tr>
 					<td class="avatar"><div style="text-align:center;min-height:125px;">'.
                  			$post->getPoster().
				   '</div></td>
            	    <td class="post"><div class="poster">
                    	 	<div class="postmenu"><p >
									<span class = "posttitle">posté le '.date('d M y, à H\hi ',$post->getPostDate()).'</span>';
if($mustShowMenu){		
		$data .= '					<span style="float:right">';
		$data .= User_Connexion::get_user_name() == $post->getPoster() && !$post->isOriginalPost() ?'<a href ="./post.php?action=delete&topic_id='.$post->getTopicId().'&post_id='.$post->getPostId().'" class="topicbutton">Supprimer</a>' : '';
		$data .= User_Connexion::get_user_name() == $post->getPoster() ?'<a href ="./post.php?action=edit&topic_id='.$post->getTopicId().'&post_id='.$post->getPostId().'" class="topicbutton">Editer</a>' : '';
		$data .= '<a href ="./post.php?action=reply&topic_id='.$post->getTopicId().'&post_id='.$post->getPostId().'" class="topicbutton">Répondre</a></span>';
	}	                            		                	              
    $data .=              '</p></div>
		                   <div class="postcontent"><p class="topictext">';
    $data .= $post->getPostText();                                       
    $data .=           '   </p></div>
        		   </div></td>
        		</tr></table></div>';
 
 	
 	return $data;
 }

 function cat_list_display($cat_list,$ariane){
 	$data = '';
	$data .= ariane($ariane)."\n";
	foreach($cat_list AS $index => $cat){
		$data  .= '<div>'."\n".				   
		           titleCanvas($cat->getCatName());      		     
		foreach($cat->getForumList() AS $forum_index => $forum){
			    			
			$data .= subjectCanvas($forum->getForumName(),$forum->getForumId());	
		}    
		$data .= '</div>'."\n";		 		    		    		
	}	 	
 	return utf8_encode($data);
 }
 function forum_display($forum_id,$forum_name,$topic_list,$ariane,$pagination){
 	$data = '';
	
	$data  .= '<div>'."\n". 
			  forum_menu($forum_id)."\n".
			  ariane($ariane)."\n".
	          titleCanvas($forum_name);      		     
	if($topic_list != null) foreach($topic_list AS $topic_index => $topic){		    		
		$data .= subjectCanvas($topic->getTopicName(),$topic->getTopicId(),'viewTopic');	
	}    
		$data .= '</div>'."\n";	
    $data .= $pagination != null?pagination($forum_id,$pagination->getNbrPage(),$pagination->getCurrentPage(),"forum")."\n":'';			 		    		    			 
 	return utf8_encode($data);
 }
 function topic_display($topic_id,$topic_name,$post_list,$ariane,$pagination){
 	$data = '';
 	
 	$data  .= '<div>'."\n".  			
 			ariane($ariane)."\n".
 			topicTitleCanvas($topic_name)."\n". 			
 			'		<div style="margin-left:15px">'."\n";
 			           
 	if($post_list != null) foreach($post_list AS $post_index => $post){		    		
		$data .= postCanvas($post);	
	}		
	$data .='		</div>'."\n".
            '</div>'."\n".
            '<div style="clear:both"/>'."\n";	
 	$data .= $pagination != null?pagination($topic_id,$pagination->getNbrPage(),$pagination->getCurrentPage(),"viewTopic")."\n":'';
 	
 	return utf8_encode($data);
 }
 /*
  * PARAM : 
  *  $post = le post a afficher en cas de reply, sinon, on se fou de la valeur du param
  *  $action = "new" "reply" ou "edit"
  *  $id = id qu'on transmet en hidden, peut-être celui d'un topic (si reply) ou d'un forum (si new) ou d'un post (si un edit) 
  */
 function post_display($post,$action,$ariane,$id){	
 	
 	$data = ''; 	
 	$data .= ariane($ariane)."\n"; 
 	$data .= $action != "new"  ? topicTitleCanvas($post->getTopicName())."\n" : ''; 			
 	$data .='<div style="margin-left:15px">'."\n"; 			 	
 	$data .= $action == "reply" ? postCanvas($post,false) : '';	
 	$data .='		<div style="clear:both"/>                      	
                   	<FORM action="posting.php?action='.$action.'" method="post">';                            
    $data .='         	<div align="center" style="padding-top:50px;padding-bottom:25px">' .
    				   '  	 <div  style="width:606px;">';
    $data .= $action == "new" ? '<div style="float:left;"><div><p style="float:left"> Titre du sujet  :  <input style="border:#900 solid 3px;width:350px" type="text" name="topic_name"/></p></div>' .
    		'					<div style="clear:both;"></div><div style="height:25px"></div>' : '';
	$data .='         		 	<textarea name="text" style="margin:auto;width:600px;height:300px;overflow:autog;border:#900 solid 3px" >'.($action=="edit"?$post->getPostText():'').'</textarea>' .
			'				</div>   
                             <div style="height:25px"></div>      
                             <input type="submit" value="Envoyer"/> 
    						 <input type="hidden" name="id" value="'.$id.'"/>';                               
	$data .= $action== "edit"? '<input type="hidden" name="topic_id" value="'.$post->getTopicId().'"/>':'';
	$data .='  			</div>
                    </FORM>
             </div>';    
 	
 	return utf8_encode($data);
 	
 }
 
 function delete_post_display($post,$action,$ariane){
 	$data = ''; 	
 	$data .= ariane($ariane)."\n"; 
 	$data .= topicTitleCanvas($post->getTopicName())."\n"; 			
 	$data .= '<div style="margin-left:15px">'."\n"; 			 	
 	$data .= postCanvas($post,false) ;	
 	$data .='		<div style="clear:both"/>';                            
    $data .='         	<div align="center" style="padding-top:50px;padding-bottom:25px">                               
                             <p>Etes-vous sur de vouloir supprimer ce message ?</p>
                             <div style="height:5px"></div> 		  
    						 <FORM style="display:inline" action="posting.php?action='.$action.'" method="post">
    		                 <input type="submit" value="oui"/>
                             
                             <input type="hidden" name= "id" value="'.$post->getPostId().'"/> 
                             <input type="hidden" name= "topic_id" value="'.$post->getTopicId().'"/>
							 </FORM>
							 <FORM style="display:inline" action="viewTopic.php?id='.$post->getTopicId().'" method="post">
							 	<input type="submit" value="non"/>
							 </FORM>';
	$data .='			</div>		 		
		             </div>';
             
    return utf8_encode($data);    
 }
 
 function forum_menu($forum_id = null){
 	$data = '';
 	
 	$data =' 
 			<div style="margin-left:15px"> 				 				
 				<a href="post.php?action=new&id='.$forum_id.'"><div class="button">Nouveau</div></a>
 			</div>
 			<div style="clear:both"/>			
 			';
 	return $data;
 }
  
 function ariane($arianeData){
 	$data = '';
 	$data ='<br><div style="margin-left:15px;float:left">'; 		 			   
 	foreach($arianeData as $key => $ariane){
 		$data .= '<a href="'.$ariane['link'].'">'.$ariane['name'].'</a> ';
 		if (isset($arianeData[$key+1])) $data .= ' > ';	// si il y en a un encore après 		
 	}
 	$data .='</div>
 			<div style="clear:both"/>';	
 	return $data;
 }
 function pagination($topic_id,$nbrPage,$currentPage,$type){
 	$data = '';
 	$data .= $currentPage-1 > 0 ?' <a href="'.$type.'.php?id='.$topic_id.'&page='.($currentPage-1).'"> << </a>&nbsp ':'';
 	for($i=1;$i<=$nbrPage;$i++){ 	
 		$data .=' <a href="'.$type.'.php?id='.$topic_id.'&page='.$i.'">'.$i.'</a>&nbsp '; 		  
 	}
 	$data .= $currentPage+1 <= $nbrPage?' <a href="'.$type.'.php?id='.$topic_id.'&page='.($currentPage+1).'"> >> </a> ':'';
 	return $data;
 }

?>
