<?php
  require_once(APPPATH.'/model/DAO/mysql.php');
  class ForumDAO{
  	
  	 private $db; 
  	 
  	 public function __construct()
     {
        $this->db = Forum_Mysql::getInstance(); 
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
  	 public function get_topic_ariane(&$ariane,$topic_id){
  	 	$result = $this->db->get_topic_path($topic_id);
  	 	
  	 	$ariane[1]['name']= $result['cat_name'];
		$ariane[1]['link']= WEBADRESSROOT."index.php";
  	 	$ariane[2]['name']= $result['forum_name'];
		$ariane[2]['link']= WEBADRESSROOT."forum.php?id=".$result['forum_id'];
		$ariane[3]['name']= $result['topic_name'];
		$ariane[3]['link']= WEBADRESSROOT."viewTopic.php?id=".$result['topic_id'];
				
  	 }
  	 public function get_forum_ariane(&$ariane,$forum_id){
  	 	$result= $this->db->get_forum_path($forum_id);
  	 	  	 	
  	 	$ariane[1]['name']= $result['cat_name'];
		$ariane[1]['link']= WEBADRESSROOT."index.php";
		$ariane[2]['name']= $result['forum_name'];
		$ariane[2]['link']= WEBADRESSROOT."forum.php?id=".$result['forum_id'];;
  	 }
  }
?>
