<?php

  function titleCanvas($title){
 	$data  = '<div class="titre">'."\n".
			 '	<h2 style="font-size:1em">'.$title.'</h2>'."\n".
  			 '</div>'."\n";
 	
 	return utf8_encode($data); 	       
 }
 function subjectCanvas($topicName,$topic_id,$type='forum'){
 	$data  ='<div class="cadre">'."\n".
   		    '	<p style="font-size:0.9em;text-align:left;"><a href="'.$type.'.php?id='.$topic_id.'">'.$topicName.'</a></p>'."\n".
    	    '</div>'."\n";
    
    return utf8_encode($data);
 }
 function topicTitleCanvas($title){
  $data = '
  		<div class="topictitre" style="margin-left:15px">
            	<h2 style="font-size:1em">'.$title.'</h2>
         </div>';
         		    
  return utf8_encode($data);
 }
 function postCanvas($post,$mustShowMenu=true){
 	$data ='';
 	 	
 	
 	$data .=			 '   <div><div class="avatar" >
                    			avatar
						     </div>
            			     <div class="post" >
                    		 	<div class="postmenu"><p>
									<span class = "posttitle">posté par XXX le XXXX</span>
		                            <span style="float:right">';
	$data .= $mustShowMenu? '<a href ="" class="topicbutton">Citer</a>
        		             <a href ="./post.php?action=reply&id='.$post->getPostId().'" class="topicbutton">Répondre</a></span>': '';	                	               
    $data .=        		   '</p></div>
		                        <div class="postcontent"><p class="topictext">';
    $data .= $post->getPostText();                                       
    $data .=           '		</p></div>
        		            </div></div>
						';
 
 	
 	return utf8_encode($data);
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
 	return $data;
 }
 function forum_display($forum,$ariane){
 	$data = '';
	
	$data  .= '<div>'."\n". 
			  forum_menu()."\n".
			  ariane($ariane)."\n".
	          titleCanvas($forum->getForumName());      		     
	foreach($forum->getTopicList() AS $topic_index => $topic){		    		
		$data .= subjectCanvas($topic->getTopicName(),$topic->getTopicId(),'viewTopic');	
	}    
		$data .= '</div>'."\n";		 		    		    			 
 	return $data;
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
 	
 	return $data;
 }
 function post_display($post){
 	$data = '';
 	
 	$data  .=  
 			topicTitleCanvas($post->getTopicName())."\n". 			
 			'		<div style="margin-left:15px">'."\n"; 			
 	$data .= postCanvas($post,false);	
 	$data .='<div style="clear:both"/>                      	
                   	<FORM action="" method="poster">                        
                       	<div style="padding-top:50px;padding-bottom:25px">
                       		<textarea style="margin:auto;width:600px;height:300px;overflow:hidden;border:#900 solid 3px"></textarea>   
                               <div style="height:25px"></div>      
                               <input type="submit" value="Envoyer"/>
               			</div>
                    </FORM>
             </div>';
 	return utf8_encode($data);
 	
 }
 function forum_menu(){
 	$data = '';
 	
 	$data =' 
 			<div style="margin-left:15px"> 				
 				<div class="button">Nouveau</div>
 				<div class="button">Répondre</div>
 			</div>
 			<div style="clear:both"/>			
 			';
 	return utf8_encode($data);
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
 	return utf8_encode($data);
 }

?>
