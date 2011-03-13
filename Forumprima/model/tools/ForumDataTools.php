<?php
require_once(APPPATH.'/model/DAO/ForumDAO.php');
class ForumDataTools{
	
	private $forumDAO;
	
	public function __construct(){
		$this->forumDAO = new ForumDAO();
	}
     /*  
  	  * retourne un objet de type CategorieList
  	  */ 
  	 public function get_cat_list(){  	 	
  	 	return $this->forumDAO->get_cat_list();;
  	 }
  	 private function get_forum_list($cat_id){
  	 	return $this->forumDAO->get_forum_list($cat_id);  	
  	 }
  	 public function get_topic_list($forum_id){
  	 	return $this->forumDAO->get_topic_list($forum_id);;  	 	
  	 }
}
?>
