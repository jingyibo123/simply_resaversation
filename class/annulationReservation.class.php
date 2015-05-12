<?php

class Annulation {

   	private $sMotif; 

	public $aError;


   	function Annulation($aTableau=''){
   		if(!empty($aTableau)){
   			foreach($aTableau as $k=>$v){
   				switch ($k){
   					case 'motif':
   						$this->sMotif = $v;
   					break;
   				}
   			}
   		}
   	}

   	//Getter

	public function getMotif(){
		return $this->sMotif;
	}

	
	//Setter

	public function setMotif($sNewMotif) {
		$this->sMotif = $sNewMotif;	
	}


	public function validation(){

		$this->aError = array();

		if($this->sMotif == ''){
			$this->aError['motif'] = 'error_vide';
		}elseif(strlen($this->sMotif) > 1000){
			$this->aError['motif'] = 'error_trop_long';
		}
	}
}

?>