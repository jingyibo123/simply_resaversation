<?php

class Fonctions {

	// Fonction récupération de l'ip du visiteur
	public static function get_ip() { 
		// IP derrière un proxy
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
			$sIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 
		else {
			// IP si internet partagé
			if(isset($_SERVER['HTTP_CLIENT_IP'])) { 
				$sIp = $_SERVER['HTTP_CLIENT_IP'];
			} 
			// IP normal
			else { 
				$sIp = $_SERVER['REMOTE_ADDR'];
			}
		}
		return $sIp;
	}
	
	
	// Fonction récupération de l'url de la page requise
	public static function get_url() {
		$sUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		return $sUrl;
	}
	
	
	


}

?>