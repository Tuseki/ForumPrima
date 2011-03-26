<?php
/*
 * Cette classe est un conteneur pour des informations concernant la pagination 
 */
 class Pagination{
 	private $currentPage;
 	private $nbrPage;
 	
 	public function __construct(){
 		$this->currentPage = null;
 		$this->nbrPage = null;
 	}
 	
 	public function setCurrentPage($currentPage){
 		$this->currentPage = $currentPage;
 	}
 	public function getCurrentPage(){
 		return $this->currentPage;
 	}
 	public function setNbrPage($nbrPage){
 		$this->nbrPage = $nbrPage;
 	}
 	public function getNbrPage(){
 		return $this->nbrPage;
 	}

 }
?>
