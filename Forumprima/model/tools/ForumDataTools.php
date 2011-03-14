<?php
require_once(APPPATH.'/model/DAO/ForumDAO.php');
class ForumDataTools{
	
	private $forumDAO;
	
	const ARIANE_TOPIC = 0;
	const ARIANE_FORUM = 1;
    const ARIANE_INDEX = 3;
	
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
  	 /*
  	  * param : $id => id du forum/topic sur lequel on se trouve actuellement 
  	  */
  	 public function get_Ariane($type,$id = null){  	 	
  	 	//base de tout fil d'ariane
  	 	$ariane[0]['name']= "Forum Prima luce";
	    $ariane[0]['link']= WEBADRESSROOT."index.php";
	    
	    //si je suis sur une page de vision de topic
	    if($type == ForumDataTools::ARIANE_TOPIC){
	      $this->forumDAO->get_topic_ariane($ariane,$id);	
	    }
	    //si je suis sur une page de vision de forum
	    else if($type == ForumDataTools::ARIANE_FORUM){
	      $this->forumDAO->get_forum_ariane($ariane,$id);	
	    }		
		
		return $ariane ;
  	 }
}
?>
