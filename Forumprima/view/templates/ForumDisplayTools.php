<?php

  function titleCanvas($title){
 	$data  = '<div class="titre">'."\n".
			 '	<h2 style="font-size:1em">'.$title.'</h2>'."\n".
  			 '</div>'."\n";
 	
 	return $data; 	       
 }
 function subjectCanvas($topicName,$topic_id,$type='forum'){
 	$data  ='<div class="cadre">'."\n".
   		    '	<p style="font-size:0.9em;text-align:left;"><a href="'.$type.'.php?id='.$topic_id.'">'.$topicName.'</a></p>'."\n".
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

 	$data ='';
 	$data .=			 '   <div><div class="avatar" >'.
                    			$post->getPoster().
						    '</div>
            			     <div class="post" >
                    		 	<div class="postmenu"><p>
									<span class = "posttitle">posté le XXXX</span>
		                            <span style="float:right">';
	if($mustShowMenu){		
		$data .= User_Connexion::get_user_name() == $post->getPoster() ?'<a href ="./post.php?action=edit&topic_id='.$post->getTopicId().'&post_id='.$post->getPostId().'" class="topicbutton">Editer</a>' : '';
		$data .= '<a href ="./post.php?action=reply&topic_id='.$post->getTopicId().'&post_id='.$post->getPostId().'" class="topicbutton">Répondre</a></span>';
	}	                            		                	              
    $data .=        		   '</p></div>
		                        <div class="postcontent"><p class="topictext">';
    $data .= $post->getPostText();                                       
    $data .=           '		</p></div>
        		            </div></div>
						';
 
 	
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
 function forum_display($forum,$ariane){
 	$data = '';
	
	$data  .= '<div>'."\n". 
			  forum_menu($forum->getForumId())."\n".
			  ariane($ariane)."\n".
	          titleCanvas($forum->getForumName());      		     
	foreach($forum->getTopicList() AS $topic_index => $topic){		    		
		$data .= subjectCanvas($topic->getTopicName(),$topic->getTopicId(),'viewTopic');	
	}    
		$data .= '</div>'."\n";		 		    		    			 
 	return utf8_encode($data);
 }
 function topic_display($topic,$ariane){
 	$data = '';
 	
 	$data  .= '<div>'."\n". 
 			ariane($ariane)."\n".
 			topicTitleCanvas($topic->getTopicName())."\n". 			
 			'		<div style="margin-left:15px">'."\n";
 			           
 	foreach($topic->getPostList() AS $post_index => $post){		    		
		$data .= postCanvas($post);	
	}		
	$data .='		</div>'."\n".
            '</div>'."\n".
            '<div style="clear:both"/>'."\n";	
 	
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
 	$data .= $action != "new" ? topicTitleCanvas($post->getTopicName())."\n" : ''; 			
 	$data .='<div style="margin-left:15px">'."\n"; 			 	
 	$data .= $action == "reply" ? postCanvas($post,false) : '';	
 	$data .='		<div style="clear:both"/>                      	
                   	<FORM action="posting.php?action='.$action.'" method="post">';                            
    $data .='         	<div align="center" style="padding-top:50px;padding-bottom:25px">' .
    				   '  	 <div  style="width:606px;">';
    $data .= $action == "new" ? '<div style="float:left;"><div><p style="float:left"> Titre du sujet  :  <input style="border:#900 solid 3px;width:350px" type="text" name="topic_name"/></p></div>' .
    		'					<div style="clear:both;"></div><div style="height:25px"></div>' : '';
	$data .='         		 	<textarea name="text" style="margin:auto;width:600px;height:300px;overflow:hidden;border:#900 solid 3px" >'.($action=="edit"?$post->getPostText():'').'</textarea>' .
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

?>
