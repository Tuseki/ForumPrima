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
  	 	return $this->forumDAO->get_cat_list();
  	 }
  	 
  	 public function get_forum($forum_id,$forum_name){
  	 	return $this->forumDAO->get_forum($forum_id,$forum_name);  	 	
  	 }
  	 public function get_topic($topic_id,$topic_name = null){
  	 	$topic = $this->forumDAO->get_topic($topic_id,$topic_name);
  	 	  	 	  	 	
  	 	if(!empty($topic)){
	  	 	//on recherche et assigne le post id du post original de ce topic
	  	 	$post_list = $topic->getPostList();
	  	 	if(!empty($post_list)){  	
	  	 		$post_list[0]->setOriginalPost(true); 	
	  	 		$topic->setOriginalPostId($post_list[0]->getPostId());
	  	 	}  	 		  	 	
  	 	}
  	 	return $topic;
  	 }
  	 /*
  	  * parmi un tabeau de donnée ($data) (list de post, de forum, ou autre, peu importe)
  	  * retourne les éléments de la "page" demandée
  	  * 
  	  * Le nombre d'élément par page est défini en configuration
  	  */
  	 public function get_page($data,$page,$nbrByPage){		
  	 	$originIndex = $page * $nbrByPage - $nbrByPage; // e.g : 1 * 15 -15 => on commence au premier index
  		
  		$endIndex = $originIndex + $nbrByPage;
  		  		  		  		  	
		if(array_key_exists($originIndex,$data)){					
  	 		if ($originIndex != $endIndex) $returnData = array_slice($data,$originIndex,$endIndex);
  	 		else $returnData = array($data[$originIndex]);
  	 		  	 				
  	 		return $returnData;
		}
		else return null;
  	 }
  	 /*
  	  * Cette fonction renvoi un objet pagination initialisé en fonction des $data envoyé
  	  * 
  	  */
  	 public function get_pagination($data,$currentPage,$nbrByPage){
  	 	
  	 	$nbrPage = count($data) / $nbrByPage;  	 	
  	 	if((count($data) % $nbrByPage) != 0) $nbrPage ++; // s'il y a un reste à cette division, c'est qu'il y a une page en plus
  	 	
  	 	if($nbrPage > 0){ 
  	 		$pagination = new Pagination();
  	 		$pagination->setNbrPage($nbrPage);
  	 		$pagination->setCurrentPage($currentPage); 
  	 	}
  	 	else $pagination = null;
  	 	
  	 	return $pagination;
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
  	 public function get_post($post_id){  	 	  	
  	 	return $this->forumDAO->get_post($post_id);
  	 } 
  	 public function get_post_foredit($post_id){
  	 	$post = $this->forumDAO->get_post($post_id);
  	 	$post->setPostText(str_replace("<br>","\n",$post->getPostText()));
  	 	return $post;
  	 }
  	 /*
  	  * encodage du texte pour la db
  	  */
  	  public function encode($post_text){
  	  	$text = '';
  	  	/*
  	  	 * TO-DO
  	  	 */ 
  	    $text = str_replace("\n","<br>",$post_text);
  	    return $text;
  	  }
  	 /*
  	  * écriture
  	  */
  	  public function write_post($topic_id,$post_creator,$post_text){
  	  	
  	  	//vérification et formatage du texte du post 
  	  	$post_text = $this->encode($post_text);
  	  	  	  	  	  
  	  	//sauvegarde des données
  	  	$post = new post();
  	  	$post->setTopicId($topic_id);
  	  	$post->setPoster($post_creator);
  	  	$post->setPostText($post_text);
  	  	
  	  	$this->forumDAO->write_post($post,time());
  	  	  	  	
  	  	
  	  }
  	  public function write_topic($topic_name,$forum_id,$post_text,$topic_creator,$topic_creation_time){
  	  	$post = new Post();
  	  	$post->setPoster($topic_creator);
  	  	$post->setPostText($post_text);  
  	  		  	
  	  	$topic = new topic();  	  	
  	  	$topic->setTopicName($topic_name);
  	  	$topic->setForumId($forum_id);  	  	
  	  	$topic->setTopicOriginalPoster($topic_creator);
  	  	
  	  	return $this->forumDAO->write_topic($topic,$post_text,$topic_creation_time);  	  	
  	  }
  	  public function update_post($post_id,$post_text,$topic_last_post_time){
  	  	
  	  	//vérification et formatage du texte du post 
  	  	$post_text = $this->encode($post_text);
  	  	
  	  	$this->forumDAO->update_post($post_id,$post_text,$topic_last_post_time);
  	  }
  	  public function delete_post($post_id){
  	  	  	  	
  	  	$this->forumDAO->delete_post($post_id);
  	  }
  	  
  	 
  	    	  
  	  
}
?>
