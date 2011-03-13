<?php
/*
 * Created on 1 déc. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class ForumSession{
 	private $isConnected;
 	
 	public function isConnected(){
 		return $this->isConnected;
 	}
 	public function connexion(){
 		$this->setConnected(true);
 	} 	
 	public function deconnexion(){
 		$this->setConnected(false);
 	}
 	private function setConnected($bool){
 		if(is_bool($bool)){
 			$this->isConnected = $bool;
 		}
 		// si le parametre est pas un boolean, on se connecte pas
 		else $this->isConnected = false; 
 		
 	}
 	
 	
 }
?>
