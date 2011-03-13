<?php
  
 class CategorieList{
 	/**
     * Contient des objets de type Categorie;
     */
 	private $cat_list;
 
 	/**
 	 * Constructor
 	 */
 	public function __construct()
    {
        $this->initCat();
    }
    
    public function getCatList(){
    	return $this->cat_list;
    }
    public function setCatList($cat_list){
    	$this->cat_list = $cat_list;
    }
    
    /**
     * debugg function
     */
    private function initCat(){
    	$forum1 = new forum();
    	$forum1->setForumId(1);
    	$forum1->setForumName("forum 1");
    	
    	$forum2 = new forum();
    	$forum2->setForumId(2);
    	$forum2->setForumName("forum 2");
    	
    	$forum3 = new forum();
    	$forum3->setForumId(3);
    	$forum3->setForumName("forum 3");
    	
    	$forum4 = new forum();
    	$forum4->setForumId(4);
    	$forum4->setForumName("forum 4");
    	    	
    	$forumlist1[0] = $forum1;
    	$forumlist1[1] = $forum2;
    	$forumlist1[2] = $forum3;
    	
    	$forumlist2[0] = $forum4;
    	
    	
    	    	
    	$cat_list[0] = new Categorie();
    	$cat_list[0]->setCatName("Categorie une");
    	$cat_list[0]->setForumList($forumlist1);
    	$cat_list[1] = new Categorie();
    	$cat_list[1]->setCatName("Categorie deux");
    	$cat_list[1]->setForumList($forumlist2);
    	
    	$this->setCatList($cat_list);    	
    }
 }
 //END OF CLASS
 
 /**
  * Un objet de type catégorie est un objet contenant
  * un nom et une liste de forum  
  */
 class Categorie{
 	private $cat_name;
 	private $cat_id;
 	private $cat_order; // ordre d'affichage
 	private $forum_list; 
 	
 	public function getCatName(){
 		return $this->cat_name;	
 	}
 	public function setCatName($cat_name){
 		$this->cat_name = $cat_name;
 	}
 	
 	public function getCatId(){
 		return $this->cat_id;
 	}
 	public function setCatId($cat_id){
 		$this->cat_id = $cat_id;
 	}
 	
 	public function getCatOrder(){
 		return $this->cat_order;
 	} 
 	public function setCatOrder($cat_order){
 		$this->cat_order = $cat_order;
 	} 	 
 	
 	public function getForumList(){
 		return $this->forum_list;
 	}
 	public function setForumList($forum_list = array()){
 		$this->forum_list = $forum_list;
 	}
 }
 //END OF CLASS
 
 /**
  * Un objet forum est un objet contenant un nom et un tableau 
  * Représentant une liste de sujet de forum
  */
 class Forum{
 	private $forum_id; 	
 	private $cat_id;
 	private $forum_name;
 	private $topic_list;
 	 	 	 	
 	/**
 	 * Constructors 
 	 */
    public function __construct()
    {
    	$num=func_num_args();
 
   		switch($num)
   		{
   			
   			case 0:
		     	//pas de paramètre passé
	         	$this->construct1();
         	break;
      		case 1:
		     	//un seul paramètre passé
	         	$this->construct2(func_get_arg(0));
         	break;
      		case 2:
      			try{
	            	//deux paramètres passés
       		    	$this->construct3(func_get_arg(0),func_get_arg(1));
      			}
      			catch(Exception $e){ print 'Forum class constructor init error : '.$e->getMessage().'\n';}
         	break;
      		default:
      			print 'Error, illegal args number for Forum class constructor ';
   		}
   }       	

    private function construct1(){
    	$title ="";
    	/**
    	 * contient des objets de type Topic;
    	 */
    	$this->topicList = array();    	
    	
    }
    private function construct2($title)
    {    	    	
    	if(is_string($title))
    		$this->title = $title;
    	else throw new Exception("param is not a string");
    	
    	/**
    	 * contient des objets de type Topic;
    	 */
    	$this->topicList = array();    	   
    }
    private function construct3 ($title,$topicList)
    {    	
    	if(is_string($title))
    		$this->title = $title;
    	else throw new Exception("first param is not a string");
    	
    	if (is_array($topicList))
    		/**
	    	 * contient des objets de type Topic;
    	 	 */    
    		$this->topicList = $topicList;      
    	else throw new Exception("second param is not an array");    	    	    		    	    
    }
      
  
    public function getForumId(){
    	return $this->forum_id;
    }
    public function setForumId($forum_id){
    	$this->forum_id = $forum_id;
    }
    public function getCatId(){
    	return $this->cat_id;    	
    }
    public function setCatId($cat_id){
    	$this->cat_id = $cat_id;
    }
    
    public function getForumName(){
    	return $this->forum_name;	
    }
    public function setForumName($forum_name){
    	$this->forum_name = $forum_name;
    }
    
    public function getTopicList(){
    	return $this->topic_list;
    }
    public function setTopicList($topic_list){
    	$this->topic_list = $topic_list;
    }            
    
 }
 //END OF CLASS
 
 /**
  * un objet de type topic contient des infos sur un topic de forum
  */
 class Topic{
 	private $topic_id;
 	private $topic_name;
 	private $topic_original_poster;
 	private $topic_last_poster;
 	private $topic_seen_number;
 	private $topic_creation_date;
 	private $topic_order;
 	private $forum_id;
 	private $post_list; 
 	
 	/**
 	 * Constructor 
 	 */
    public function __construct()
    {
    
    }
      
 	public function getTopicId(){
 		return $this->topic_id;
 	}
 	public function setTopicId($topic_id){
 		$this->topic_id = $topic_id;
 	}
 	
 	public function getTopicName(){
 		return $this->topic_name;
 	}
 	public function setTopicName($topic_name){
 		$this->topic_name = $topic_name;
 	}
 	
 	public function getTopicOriginalPoster(){
 		return $this->topic_original_poster;
 	}
 	public function setTopicOriginalPoster($topic_original_poster){
 		$this->topic_original_poster = $topic_original_poster;
 	}
 	
 	public function getLastPoster(){ 
	 	return $this->topic_last_poster; 
 	}
 	public function setLastPoster($topic_last_poster){
 		$this->topic_last_poster = $topic_last_poster;
 	}
 	
 	public function getTopicSeenNumber(){
 		return $this->topic_last_poster;
 	}
 	public function setTopicSeenNumber($topic_seen_number){
 		$this->topic_last_poster = $topic_last_poster;
 	}
 	
 	public function getTopicCreationDate(){
 		return $this->topic_creation_date;
 	}
 	public function setTopicCreationDate($topic_creation_date){
 		$this->topic_creation_date = $topic_creation_date;
 	} 
 	
 	public function getForumId(){
 		return $this->forum_id;
 	}
 	public function setForumId($forum_id){
 		$this->forum_id = $forum_id;
 	}
 	
 	public function getPostList(){
		return $this->post_list;
	}
 	public function setPostList($post_list){
 		$this->post_list = $post_list;
	}
	
 }
 
 /**
  * Un objet de type post est un objet contenant toutes les informations 
  * sur un post d'un topic
  */
 class Post{
 	 private $post_id;
	 private $poster;
	 private $post_text;
	 private $post_date; //date de création
	 private $topic_id;
	 private $topic_name;
	 
	 public function getPostId(){
	 	return $this->post_id;
	 }
	 public function setPostId($post_id){
	 	$this->post_id = $post_id;
	 }
	 public function getPoster(){
		return $this->poster;
	 }
	 public function setPoster($poster){
		$this->poster = $poster;
	 }
	 
	 public function getPostText(){
	 	return $this->post_text;
	 }
	 public function setPostText($post_text){
	 	$this->post_text = $post_text;
	 }
	 
	 public function getPostDate(){
	 	return $this->post_date;
	 }
	 public function setPostDate($post_date){
	 	$this->post_date = $post_date; 
	 }
	 
	 public function getTopicId(){
	 	return $this->topic_id;
	 }
	 public function setTopicId($topic_id){
	 	$this->topic_id = $topic_id;
	 }	 	
	  public function getTopicName(){
	 	return $this->topic_name;
	 }
	 public function setTopicName($topic_name){
	 	$this->topic_name = $topic_name;
	 }	 
 }
 //END OF CLASS
 
 /**
  * Contient des infos sur le chemin ou l'utilisateur se trouve
  */
 class Ariane{
 	private $cat_name;
 	private $forum_name;
 	private $topic_name;
 	
 	public function getCatName(){
 		return $this->cat_name;
 	}
 	public function setCatName($cat_name){
 		$this->cat_name = $cat_name;
 	}
 	
 	public function getForumName(){
 		return $this->forum_name;
 	}
 	public function setForumName($forum_name){
 		$this->forum_name = $forum_name;
 	}
 	
 	public function getTopicName(){
 		return $this->topic_name;
 	}
 	public function setTopicName($topic_name){
 		$this->topic_name = topic_name;
 	}
 }
 //END OF CLASS
?>
