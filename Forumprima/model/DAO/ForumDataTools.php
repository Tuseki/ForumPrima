<?php
  class ForumDataTools{
  	
  	 private $db; 
  	 
  	 public function __construct()
     {
        $this->db = Forum_Mysql::get_Forum_Mysql(); 
     }  	 
  	 
  	 /*  
  	  * retourne un objet de type CategorieList
  	  */ 
  	 public function get_cat_list(){
  	 	
  	 	$catListArray = '';
  	 	  	 	
  	 	$catResult= $this->db->get_cat_list();
  	 	
  	 	//pour toutes les catégories
  	 	$i = 0;
  	 	foreach($catResult as $cat){
  	 		$catListArray[$i] = new Categorie();
  	 		$catListArray[$i]->setCatName($cat['cat_name']);
  	 		
  	 		//on cherche tous les forums
  	 		$forumlist = $this->get_forum_list($cat['cat_id']);
  	 				  	 		
  	 		$catListArray[$i]->setForumList($forumlist);
  	 		  	 			    		    	    	    	
  	 		$i++;
  	 	}
  	 	  	 	  	 	
  	 	$catList = new CategorieList();
  	 	$catList->setCatList($catListArray);
  	 	return $catList;
  	 }
  	 private function get_forum_list($cat_id){
  	 	$forumResult = $this->db->get_forum_list($cat_id);
  	 	
  	 	$forumlist = array();
  	 	
  	 	$i = 0;	
	    foreach($forumResult as $forum){
	    	
	    	$forumtmp = new forum();
    		$forumtmp->setForumId($forum['forum_id']);
    		$forumtmp->setForumName($forum['forum_name']);
    		  	 
    		$forumlist[$i] = $forumtmp;
    		$i++;
	    }
	    return $forumlist;
  	 }
  	 public function get_topic_list($forum_id){
  	 		$topicResult = $this->db->get_topic_list($forum_id);
  	 		
  	 		
  	 		$forum = new forum();
  	 		$topiclist = array();
  	 		  	 		
  	 		$i = 0;
  	 		foreach($topicResult as $topic){  
  	 				 		
  	 			$topiclist[$i] = new Topic();
				$topiclist[$i]->setTopicName($topic['topic_name']);
				$topiclist[$i]->setTopicId($topic['topic_id']);
				$i++;
  	 		}
  	 		$forumNameResult = $this->db->get_forum_name($forum_id);
  	 		$forumName = $forumNameResult[0]['forum_name'];
  	 		
  	 		$forum->setForumId($forum_id);
    		$forum->setForumName($forumName);
    		$forum->setTopicList($topiclist);
    		    	
  	 		return $forum;
  	 	
  	 }
  }
?>
