<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est la seule classe qui à l'authorisation de communiquer
    à la base de données. Elle ne contient que des fonctions de requêtages.  

/ ------------------------------------------------------------------------- */

class Bdd{	
	//variables
	//private
	private $sHost = BDD_HOST;
	private $sDbname = BDD_NAME;
	private $sUtilisateur = BDD_USER;
	private $sMdp = BDD_MDP;
	private $bdd = '';
	//public
	public $aError;

	//Constructeur
	//Si aucun paramètre ne lui est passé, il charge la base de données à partir des constantes
	//contenu dans le fichier parametres. Sinon il charge la base de données passée en argument.
	function bdd($sHost='', $sDbname='', $sUtilisateur='', $sMdp=''){
		
		$sHost = $sHost != '' ? $sHost : $this->sHost;
		$sDbname = $sDbname != '' ? $sDbname : $this->sDbname;
		$sUtilisateur = $sUtilisateur != '' ? $sUtilisateur : $this->sUtilisateur;
		$sMdp = $sMdp != '' ? $sMdp : $this->sMdp;

		try{
			$this->bdd = new PDO('mysql:host=' . $sHost . ';dbname=' . $sDbname . ';charset=utf8', $sUtilisateur, $sMdp);
		}catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
	}

	public function user_getData($iId){
		$bdd = $this->bdd;

		$req=$bdd->prepare('SELECT * FROM user WHERE id=?');

	    $bReturn = $req->execute(array($iId));

	    if($bReturn == true){
	    	$aRetour = $req->fetch();
	    	$req->CloseCursor();
	    	
	    	return $aRetour;
	    }else{
	    	$req->CloseCursor();
	    	return $bReturn;
	    }
	}

	public function user_insert($oUser){
		$bdd = $this->bdd;

		$req=$bdd->prepare('INSERT INTO MEMBRE (email, nom, prenom, mdp, droit, actif) VALUES (:email, :nom, :prenom, :mdp, :droit, 1)');

	    $req->bindValue(':email',$oUser->getEmail(), PDO::PARAM_STR);
	    $req->bindValue(':nom',$oUser->getNom(), PDO::PARAM_STR);
	    $req->bindValue(':prenom',$oUser->getPrenom(), PDO::PARAM_STR);
	    $req->bindValue(':mdp',md5($oUser->getMdp()), PDO::PARAM_STR);
	    $req->bindValue(':droit',$oUser->getDroit(), PDO::PARAM_STR);

	    $bReturn = $req->execute();
	    $req->CloseCursor();

	    if($bReturn == true){
	    	return $bdd->lastInsertId();
	    }else{
	    	return $bReturn;
	    }
	}

	public function user_update($oUser){

	}

	public function user_delete($oUser){

	}
	
	public function user_checkData ($sEmail, $sMdp) {
		// Vérification des identifiants
		$bdd = $this->bdd;
			$req = $bdd->prepare('SELECT id_user, prenom, nom, droit FROM MEMBRE WHERE email = :email AND mdp = :mdp');
				
			$req->execute(array(
				'email' => $sEmail,
				'mdp' => $sMdp));

			$resultat = $req->fetch();	
			return $resultat;
	}

	public function user_getId($sEmail) {
		$bdd = $this->bdd;

		$req = $bdd->prepare('SELECT ID_USER FROM MEMBRE WHERE MEMBRE.EMAIL = :email');
		$response = $req1->execute(array('email' => $sEmail));
		$iId = $response->fetch();
		$response->closeCursor();
		
		//Techniquement une adresse email est associée à un unique ID. A vérifier !
		return $iId;
	}
	
	// RESTAURATEURS 
	public function user_getListeRestaurants($iId_user) {
		$bdd = $this->bdd;
		//On vérifie qu'il s'agit bien d'un restaurateur !
		$req1 = $bdd->prepare('SELECT DROIT FROM MEMBRE WHERE MEMBRE.ID_USER = :id');
		$iDroit = $req1->execute(array('id' => $iId_user));
		
			if ($iDroit == 2) {
				$req2 = $bdd->prepare('SELECT DISTINCT * FROM RESTAURANT, MEMBRE WHERE RESTAURANT.ID_USER = MEMBRE.ID_USER AND MEMBRE.ID_USER = ?'); 
				$response = $req2->execute(array($iId));
				while($aListeResto = $response->fetch()) {
					//Est-ce bien utile ?
				}
				$response->closeCursor();
				return $aListeResto;
			}
			else {
				$this->aError = array();
				$this->aError['Droit'] = 'Droit vaut ' . $iDroit . ' alors qu\'il devrait valloir 2 !';
				return $iDroit;
			}
	}
	
		// A vérifier : forme du tableau retourné
	public function user_getListeResa($iId_Resto) {
		$bdd = $this->bdd;
		$req = $bdd->prepare('SELECT DISTINCT * WHERE OFFRE.ID_RESTO = ? AND OFFRE.ID_OFFRE = RESERVATION.ID_OFFRE');
		$response = $req->execute(array($iId_Resto));
		while($aListeResa = $response->fetch()) {
					//Est-ce bien utile ?
		}
		$response->closeCursor();
		return $aListeResa;
	}
	
	public function reservation_getData($iId){
		$bdd = $this->bdd;

		$req=$bdd->prepare('SELECT * FROM reservation WHERE id=?');

	    $bReturn = $req->execute(array($iId));

	    if($bReturn == true){
	    	$aRetour = $req->fetch();
	    	$req->CloseCursor();
	    	return $aRetour;
	    }else{
	    	$req->CloseCursor();
	    	return $bReturn;
	    }
	}
}
?>
