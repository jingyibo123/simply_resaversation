<?php

class Offre {

	private $sDescriptif; 
 

	public $aError;


   	function Offre($aOffre=''){
   		if(!empty($aTableau)){
   			foreach($aTableau as $k=>$v){
   				switch ($k){
   					
   					case 'descriptif':
   						$this->sDescriptif = $v;
   					break;
   					
   				}
   			}
   		}
   	}

   	//Getter


	public function getDescriptif(){
		return $this->sDescriptif;
	}
	
	

	
	//Setter

	
	public function setDescriptif($sNewDescriptif){
		$this->sDescriptif = $sNewDescriptif;
	}
	


	public function validation(){

		$this->aError = array();

		
		if($this->sDescriptif == ''){
			$this->aError['descriptif'] = 'error_vide';
		}elseif(strlen($this->sDescriptif) > 1000){
			$this->aError['descriptif'] = 'error_trop_long';
		}
	}
}

?>