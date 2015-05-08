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

		$req=$bdd->prepare("SELECT * FROM MEMBRE WHERE ID_USER = $iId");

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

	    // if($bReturn == true){
	    	// return $bdd->lastInsertId();
	    // }else{
	    	return $bReturn;
	    
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
	
	public function user_checkEmail ($sEmail){
		$bdd = $this->bdd;
		$req = $bdd->prepare('SELECT id_user FROM MEMBRE WHERE MEMBRE.EMAIL = :email');
		$req->execute(array(
				'email' => $sEmail));
				
			$resultat = $req->fetch();
			$req->closeCursor();
			
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
	
	public function getRestaurants(){
		$bdd = $this->bdd;
		
		$req = $bdd->prepare('SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE ACTIF = 2');
		$aListe = $req->execute(array());
		
		echo "Liste des restaurants </br></br>";
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM_RESTO'].' ' ?> <a href="index.php?category=9&&id=<?php echo $donnees['ID_RESTO']; ?>">Détails</a><?php 
												?><a href="index.php?category=18&&id=<?php echo $donnees['ID_RESTO']; ?>">Ajouter une offre</a><?php
			echo'<br />'; 
		}
		
		$req->closeCursor();
		
	}
	
	// Liste des restaurateurs
	public function getRestaurateurs() {
		$bdd = $this->bdd;
		
		$req = $bdd->prepare('SELECT ID_USER, NOM, PRENOM FROM MEMBRE WHERE MEMBRE.DROIT = 2 GROUP BY NOM');
		$aListe = $req->execute(array());
		
		echo "Liste des restaurateurs </br></br>";
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM'].' '.$donnees['PRENOM'] ?> <a href="index.php?category=8&&id=<?php echo $donnees['ID_USER'];?>">Restaurants</a><?php 
			echo'<br />'; 
		}
		
		$req->closeCursor();

	}
	

	
	//Liste des offres vu par le restaurateur
	public function getOffresParRestaurateur($iId){
		$bdd1 = $this->bdd;

		$req1 = $bdd1->prepare("SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE RESTAURANT.ID_USER = :id_user AND RESTAURANT.ACTIF=2");
		$aListe1 = $req1->execute(array(
					'id_user' => $iId));
		

		
		while ($donnees1 = $req1->fetch()) {
			echo 'Liste des offres du restaurant '.$donnees1['NOM_RESTO'].' : <br /><br />'; 
			
			$bdd2 = $this->bdd;
			$req2 = $bdd2->prepare("SELECT ID_OFFRE, DESCRIPTIF FROM OFFRE WHERE OFFRE.ID_RESTO = :id AND ACTIF=2");
			$aListe2 = $req2->execute(array(
					'id' => $donnees1['ID_RESTO'] ));
		
			while ($donnees2 = $req2->fetch()) {
				echo $donnees2['DESCRIPTIF'];
				echo '<br/>';
			}
			echo '<br /><br />';
			
			$req2->closeCursor();
		}
	
		$req1->closeCursor();
		
	}
	
	//Liste des offres vu par l'administrateur
	public function getOffresParAdministrateur(){
		$bdd1 = $this->bdd;
		

		$req1 = $bdd1->prepare("SELECT NOM_RESTO, ID_RESTO, ID_USER FROM RESTAURANT WHERE RESTAURANT.ACTIF=2");
		$aListe1 = $req1->execute(array());
		
		
		
		while ($donnees1 = $req1->fetch()) {
			
			$bdd = $this->bdd;
			$req = $bdd->prepare("SELECT PRENOM, NOM FROM MEMBRE WHERE MEMBRE.ID_USER= :id");
			$aListe = $req->execute(array(
				'id' => $donnees1['ID_USER']));
				
				
				while ($donnees = $req->fetch()) {
			
					echo 'Liste des offres du restaurant '.$donnees1['NOM_RESTO'].' dont le propriétaire est '.$donnees['PRENOM'].' '.$donnees['NOM'].' : <br /><br />'; 
			
					$bdd2 = $this->bdd;
					$req2 = $bdd2->prepare("SELECT ID_OFFRE, DESCRIPTIF FROM OFFRE WHERE OFFRE.ID_RESTO = :id AND ACTIF=2");
					$aListe2 = $req2->execute(array(
							'id' => $donnees1['ID_RESTO'] ));
		
					while ($donnees2 = $req2->fetch()) {
						echo $donnees2['DESCRIPTIF'];
						echo '<br/>';
					}
					
					echo '<br /><br />';
			
					
					$req2->closeCursor();
				}
				$req->closeCursor();				
		}
	
		$req1->closeCursor();
	}
	
	
	// Modification offre
	public function updateOffre($iId, $sDescriptif) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("UPDATE OFFRE SET DESCRIPTIF = '$sDescriptif' WHERE ID_OFFRE = '$iId'");

	    $bReturn = $req->execute();
	    $req->CloseCursor();
		
		return $bReturn;
	}

	
	// Liste des restaurants par restaurateurs
	public function getRestaurantParRestaurateur($iId) {
		$bdd1 = $this->bdd;

		$req1 = $bdd1->prepare("SELECT NOM, PRENOM FROM MEMBRE WHERE MEMBRE.ID_USER = $iId");
		$aListe1 = $req1->execute(array());
		
		$donnees1 = $req1->fetch();
		echo 'Liste des restaurants de '.$donnees1['PRENOM'].' '.$donnees1['NOM'].' : <br /><br />'; 

		$req1->closeCursor();
		
		$bdd2 = $this->bdd;

		$req2 = $bdd2->prepare("SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE RESTAURANT.ID_USER = $iId AND ACTIF=2");
		$aListe2 = $req2->execute(array());

		
		while ($donnees2 = $req2->fetch()) {
			echo  $donnees2['NOM_RESTO'].' '?> <a href="index.php?category=9&&id=<?php echo $donnees2['ID_RESTO'];?>">Details</a><?php
			echo '<br/>';
		}
		
		
		$req2->closeCursor();
	
	}
	
	
	// Détails d'un restaurants
	public function getDetailRestaurant($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM RESTAURANT WHERE RESTAURANT.ID_RESTO = $iId AND ACTIF=2");
		$aListe = $req->execute(array());
		
		$donnees = $req->fetch();
		echo 'Restaurant : '.$donnees['NOM_RESTO'].' <br /><br />'; 
		echo 'ADRESSE : '.$donnees['ADRESSE'].'<br/>';
		echo 'TELEPHONE : '.$donnees['TELEPHONE'].'<br/>';
		echo 'DESCRIPTIF : '.$donnees['DESCRIPTIF'].'<br/><br/>';
		?> 
		<a href="index.php?category=13&&id=<?php echo $donnees['ID_RESTO'];?>">Modifier</a>
		<br><br>
		<img src="images/<?php echo $donnees['IMAGE'];?>">
		<a href="index.php?category=15&&id=<?php echo $donnees['ID_RESTO'];?>">Modifier Image</a>
		<?php
		echo '<br/><br/>'; 

		$req->closeCursor();
	
	}
	
	
	// Liste des restaurants d'un restaurateur
	public function getRestaurantsRestaurateur($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE RESTAURANT.ID_USER = $iId");
		$aListe = $req->execute(array());
		
		echo "La liste de mes restaurants <br/><br/>";
		
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM_RESTO'].' '?> <a href="index.php?category=9&&id=<?php echo $donnees['ID_RESTO'];?>">Details</a><?php
			echo '<br/>';
		}
		
		$req->closeCursor();
	
	}
	
	
	// Liste des réservations par restaurateur
	public function getReservations($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM RESERVATION INNER JOIN OFFRE ON RESERVATION.ID_OFFRE = OFFRE.ID_OFFRE INNER JOIN RESTAURANT ON OFFRE.ID_RESTO = RESTAURANT.ID_RESTO WHERE RESTAURANT.ID_USER = $iId");
		$aListe = $req->execute(array());
		
		echo "La liste de mes reservations : <br/><br/>";
		
		while ($donnees = $req->fetch()) {
			echo  'Le '.$donnees['DATE_RESA'].' : '.$donnees['NB_TABLES'].' table(s) pour '.$donnees['NB_PRS'].' personne(s) au nom de ';
			echo $donnees['PRENOM'].' '.$donnees['NOM'].' (Email : '.$donnees['EMAIL_CLIENT'].')';
			echo '<br/><br/>';
		}
		
		$req->closeCursor();
	
	}
	
	
	// Données restaurant
	public function restaurant_getData($iId) {
		$bdd = $this->bdd;
		
		$req = $bdd->prepare("SELECT * FROM RESTAURANT WHERE RESTAURANT.ID_RESTO = $iId");
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
	
	
	// Modification restaurant
	public function updateRestaurant($iId, $sNom, $sAdresse, $sTelephone, $sDescriptif, $sImage) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("UPDATE RESTAURANT SET NOM_RESTO = '$sNom', ADRESSE = '$sAdresse', TELEPHONE = '$sTelephone', DESCRIPTIF = '$sDescriptif' WHERE ID_RESTO = '$iId'");

	    $bReturn = $req->execute();
	    $req->CloseCursor();
		
		return $bReturn;
	}
	
	
	// Modification image restaurant
	public function updateImage($iId, $sNomImage) {
		$bdd = $this->bdd;
		
		$req = $bdd->prepare("UPDATE RESTAURANT SET IMAGE = '$sNomImage' WHERE ID_RESTO = '$iId'");
		
		$bReturn = $req->execute();
		$req->CloseCursor();
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

		$req=$bdd->prepare('SELECT * FROM RESERVATION WHERE id=?');

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
	public function reservation_putdata($iIdoffre, $sEmail, $sNom, $sPrenom, $dDate_resa, $iNbtables, $iNbPrs ){
		$bdd = $this->bdd;
		//$dDate_cree = 
		$req=$bdd->prepare('SELECT * FROM RESERVATION WHERE id=?');

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
	public function calendar_getAvailability($iIdresto, $sStartDate, $sEndDate){
		$bdd = $this->bdd;
		$calendrier = Array ();
		for($date = strtotime($sStartDate); $date <= strtotime($sEndDate); $date = strtotime("+1days",$date)){
			$req = $bdd->prepare('SELECT * FROM `calendrier_hebdo`  WHERE `id_resto` = ? and `jour` = ?');
			$jour = date("w",$date);
			if($bReturn = $req->execute(array($iIdresto,$jour))){
				while($row = $req -> fetch()){
					$calendrier[date("Y-m-d",$date)][$row['HORAIRE']] = $row['NB_TABLES'];
				}
				$req->CloseCursor();
			}else{
				$req->CloseCursor();
				return $bReturn;
			}
		}
		$req = $bdd->prepare('SELECT * FROM `calendrier_exception`  WHERE `id_resto` = ?');
		if($bReturn = $req->execute(array($iIdresto))){
			while($row = $req -> fetch()){
				if(strtotime($sStartDate) <= strtotime($row['DATE_EXCEPTION']) && strtotime($row['DATE_EXCEPTION']) <= strtotime($sEndDate)){
					if($row['NB_TABLES']!=0)
						$calendrier[$row['DATE_EXCEPTION']][$row['HORAIRE']] = $row['NB_TABLES'];
					else
						unset($calendrier[$row['DATE_EXCEPTION']][$row['HORAIRE']]);
				}
			}
		}else{
			$req->CloseCursor();
			return $bReturn;
		}
		
		//定义空闲时间减去已订数量
		// $req = $bdd->prepare('SELECT * FROM `reservation`   WHERE `ID_OFFRE` = ? and `DATE_RESA` Between ? And ?');
		// if($bReturn = $req->execute(array($iIdoffre,$sStartDate,$sEndDate))){
			// while($row = $req -> fetch()){
				// array_push($calendrier, $row);
			// }
			// $req->CloseCursor();
		// }else{
			// $req->CloseCursor();
			// return $bReturn;
		// }
		
		
		foreach ($calendrier as $date => $calendrier_jour){
			if(empty($calendrier[$date]))
				unset($calendrier[$date]);
		}
		$db = null;
		return $calendrier;
	}
	public function reservation_get_month($iIdoffre, $sStartDate, $sEndDate){
		$bdd = $this->bdd;
		$calendrier = Array ();
		$req = $bdd->prepare('SELECT * FROM `reservation`   WHERE `ID_OFFRE` = ? and `DATE_RESA` Between ? And ?');
		if($bReturn = $req->execute(array($iIdoffre,$sStartDate,$sEndDate))){
			while($row = $req -> fetch()){
				array_push($calendrier, $row);
			}
			$req->CloseCursor();
		}else{
			$req->CloseCursor();
			return $bReturn;
		}
		
		
		$db = null;
		return $calendrier;
	}
}
?>