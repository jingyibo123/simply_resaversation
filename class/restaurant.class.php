<?php

class Restaurant {

	private $sNom;
    private $sAdresse;
	private $sTelephone;
	private $sDescriptif; 
   	private $sImage; 

	public $aError;


   	function Restaurant($aTableau=''){
   		if(!empty($aTableau)){
   			foreach($aTableau as $k=>$v){
   				switch ($k){
   					case 'nom':
   						$this->sNom = $v;
   					break;
   					case 'adresse':
   						$this->sAdresse = $v;
   					break;
   					case 'telephone':
   						$this->sTelephone = $v;
   					break;
   					case 'descriptif':
   						$this->sDescriptif = $v;
   					break;
   					case 'image':
   						$this->sImage = $v;
   					break;
   				}
   			}
   		}
   	}

   	//Getter

	public function getNom(){
		return $this->sNom;
	}

	public function getAdresse(){
		return $this->sAdresse;
	}

	public function getTelephone(){
		return $this->sTelephone;
	}

	public function getDescriptif(){
		return $this->sDescriptif;
	}
	
	public function getImage(){
		return $this->sImage;
	}

	
	//Setter

	public function setNom($sNewNom) {
		$this->sNom = $sNewNom;	
	}
	
	public function setAdresse($sNewAdresse) {
		$this->sAdresse = $sNewAdresse;	
	}
	
	public function setTelephone($sNewTelephone){
		$this->sTelephone = $sNewTelephone;
	}
	
	public function setDescriptif($sNewDescriptif){
		$this->sDescriptif = $sNewDescriptif;
	}
	
	public function setImage($sNewImage){
		$this->sImage = $sNewImage;
	}


	public function validation(){

		$this->aError = array();

		if($this->sNom == ''){
			$this->aError['nom'] = 'error_vide';
		}elseif(strlen($this->sNom) > 100){
			$this->aError['nom'] = 'error_trop_long';
		}

		if($this->sAdresse == ''){
			$this->aError['adresse'] = 'error_vide';
		}elseif(strlen($this->sAdresse) > 100){
			$this->aError['adresse'] = 'error_trop_long';
		}

		if($this->sTelephone == ''){
			$this->aError['telephone'] = 'error_vide';
		}elseif(strlen($this->sTelephone) > 20){
			$this->aError['telephone'] = 'error_trop_long';
		}
		
		if($this->sDescriptif == ''){
			$this->aError['descriptif'] = 'error_vide';
		}elseif(strlen($this->sDescriptif) > 1000){
			$this->aError['descriptif'] = 'error_trop_long';
		}
	}
}

?>