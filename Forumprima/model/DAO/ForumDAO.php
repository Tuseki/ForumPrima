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
  	 	
  	 	//pour toutes les cat�gories  	 	
  	 	foreach($catResult as $key => $cat){
  	 		$catListArray[$key] = new Categorie();
  	 		$catListArray[$key]->setCatName($cat['cat_name']);
  	 		
  	 		//on cherche tous les forums
  	 		$forumlist = $this->get_cat($cat['cat_id']);
  	 				  	 		
  	 		$catListArray[$key]->setForumList($forumlist);
  	 		  	 			    		    	    	    	  	 		
  	 	}
  	 	  	 	  	 	
  	 	$catList = new CategorieList();
  	 	$catList->setCatList($catListArray);
  	 	return $catList;
  	 }
  	 private function get_cat($cat_id){
  	 	$forumResult = $this->db->get_cat($cat_id);
  	 	
  	 	$forumlist = array();
  	 	  	 	
	    foreach($forumResult as $key => $forum){
	    	
	    	$forumtmp = new forum();
    		$forumtmp->setForumId($forum['forum_id']);
    		$forumtmp->setForumName($forum['forum_name']);
    		  	 
    		$forumlist[$key] = $forumtmp;    		
	    }
	    return $forumlist;
  	 }
  	 public function get_forum($forum_id,$forum_name){
  	 		$topicResult = $this->db->get_forum($forum_id);
  	 		  	 		
  	 		$forum = new forum();
  	 		$forum->setForumId($forum_id);
	    	$forum->setForumName($forum_name);
	    	
  	 		if (!empty($topicResult)){  	 			
	  	 		$topiclist = array();
	  	 		  	 			  	 		
	  	 		foreach($topicResult as $key => $topic){  
	  	 				 		
	  	 			$topiclist[$key] = new Topic();
					$topiclist[$key]->setTopicName($topic['topic_name']);
					$topiclist[$key]->setTopicId($topic['topic_id']);					
	  	 		}  	 		
	  	 		
	    		$forum->setTopicList($topiclist);
  	 		}
  	 		return $forum;
  	 	
  	 }
  	 public function get_topic($topic_id,$topic_name){  	 
  	 	$postResult = $this->db->get_topic($topic_id);
  	 	$topic = new topic();
  	 	$topic->setTopicName($topic_name);
  	 	$topic->setTopicId($topic_id);
		if(!empty($postResult)){	
	  	 		  	 		  	 	
	  	 	$postList = array();
	  	 	
	  	 	foreach($postResult as $key => $postDB){
	  	 		$post = new Post();
	  	 		
	  	 		$post->setPostId($postDB['post_id']);
	  	 		$post->setPoster($postDB['post_creator']);
	  	 		$post->setPostText($postDB['post_text']);
	  	 		$post->setTopicId($topic_id);
	  	 		
	  	 		$postList[$key] = $post;
	  	 	}
	  	 	
	  	 	$topic->setPostList($postList);  	 	
	  	 		  	 	
		}  	 
  	 	return $topic; 
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
  	 public function get_post($post_id){
  	 	 $result = $this->db->get_post($post_id);
  	 	 $post = new Post();
  	 	 $post->setPoster($result['post_creator']);
  	 	 $post->setPostText($result['post_text']);
  	 	 $post->setPostId($result['post_id']);
  	 	 $post->setTopicName(utf8_encode($result['topic_name']));
  	 	 
  	 	 
  	 	 return $post;
  	 } 
  	 /*
  	  * �criture 
  	  */  	 
  	 public function write_post($post){
  	 	$post_text = $post->getPostText();
  	 	$post_creator = $post->getPoster();
  	 	$topic_id = $post->getTopicId();
  	 	$this->db->write_post($post_text,$post_creator,$topic_id);
  	 } 
  	 public function write_topic($topic,$post_text){
  	 	$topic_name = $topic->getTopicName();
  	 	$forum_id = $topic->getForumId();
  	 	$topic_creator = $topic->getTopicOriginalPoster();
  	 	  	 	  	 	
  	 	return $this->db->write_topic($topic_name,$forum_id,$post_text,$topic_creator);
  	 }
  	 
  }
?>
