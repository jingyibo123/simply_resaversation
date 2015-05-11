<?php

class Offre {

	private $iId_resto;
	private $sDescriptif;
	private $iActif;
 

	public $aError;


   	function Offre($aOffre=''){
   		if(!empty($aTableau)){
   			foreach($aTableau as $k=>$v){
   				switch ($k){
   					
   					case 'descriptif':
   						$this->sDescriptif = $v;
   					break;
   					case 'id_resto':
   						$this->iId_resto = $v;
   					break;
   					case 'actif':
   						$this->iActif = $v;
   					break;
   				}
   			}
   		}
   	}

   	//Getter


	public function getDescriptif(){
		return $this->sDescriptif;
	}
	public function getId_resto(){
		return $this->iId_resto;
	}
	public function getActif(){
		return $this->iActif;
	}
	

	
	//Setter

	
	public function setDescriptif($sNewDescriptif){
		$this->sDescriptif = $sNewDescriptif;
	}
	public function setId_resto($iNouveauId_resto){
		$this->iId_resto = $iNouveauId_resto;
	}
	public function setActif($bNouveauActif){
		$this->iActif = $bNouveauActif;
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
