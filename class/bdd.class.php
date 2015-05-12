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
		
		$req = $bdd->prepare('SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE ACTIF = 1');
		$aListe = $req->execute(array());
		
		echo "Liste des restaurants </br></br>";
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM_RESTO'].' ' ?> <a href="index.php?category=9&&id=<?php echo $donnees['ID_RESTO']; ?>"> Détails </a><?php
			echo ' ';?>
						<a href="index.php?category=20&&id=<?php echo $donnees['ID_RESTO']; ?>"> Offres </a><?php

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
			echo  $donnees['NOM'].' '.$donnees['PRENOM'] ?> <a href="index.php?category=8&&id=<?php echo $donnees['ID_USER'];?>">Restaurants</a> <?php
			echo'<br />'; 
		}
		
		$req->closeCursor();
	}
	
	//Ajouter une offre
	public function ajoutOffre($oOffre) {
		$bdd = $this->bdd;


		$req = $bdd->prepare('INSERT INTO OFFRE(ID_RESTO, DESCRIPTIF, ACTIF) VALUES (:id_resto, :descriptif, 1) ');
		
		$req->bindValue(':id_resto',$oOffre->getId_resto(), PDO::PARAM_STR);
	    $req->bindValue(':descriptif',$oOffre->getDescriptif(), PDO::PARAM_STR);
	    
	    

	    $bReturn = $req->execute();
	    $req->CloseCursor();
		
		return $bReturn;
	}

	public function offre_getData($iId){
		$bdd = $this->bdd;

		$req=$bdd->prepare("SELECT * FROM OFFRE WHERE ID_OFFRE = $iId");

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

	
	//Liste des offres vu par le restaurateur
	public function getOffresParRestaurateur($iId){
		$bdd1 = $this->bdd;

		$req1 = $bdd1->prepare("SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE RESTAURANT.ID_USER = :id_user AND RESTAURANT.ACTIF=1");
		$aListe1 = $req1->execute(array('id_user' => $iId));
		

		
		while ($donnees1 = $req1->fetch()) {
			echo 'Liste des offres du restaurant '.$donnees1['NOM_RESTO'].' : <br /><br />'; 
			
			$bdd2 = $this->bdd;
			$req2 = $bdd2->prepare("SELECT ID_OFFRE, DESCRIPTIF FROM OFFRE WHERE OFFRE.ID_RESTO = :id AND ACTIF=1");
			$aListe2 = $req2->execute(array('id' => $donnees1['ID_RESTO'] ));
		
			while ($donnees2 = $req2->fetch()) {
				echo $donnees2['DESCRIPTIF'];
				if ($_SESSION['droit']==1) {
					?> <a href="index.php?category=21&&id=<?php echo $donnees2['ID_OFFRE'];?>">Modifier Offre</a><?php }
				echo '<br/>';
			}
			echo '<br /><br />';
			
			$req2->closeCursor();
		}
	
		$req1->closeCursor();
		
	}
	
	
	public function getOffresParRestaurant($iId) {
		$bdd = $this->bdd;
		
		$req = $bdd->prepare("SELECT * FROM OFFRE WHERE ID_RESTO = $iId");
		$aListe = $req->execute(array());
		
		echo "Liste des offres <br/><br/>";
		while ($donnees = $req->fetch()) {
			echo $donnees['DESCRIPTIF']; 
			if ($_SESSION['droit']==1) {
				?> <a href="index.php?category=21&&id=<?php echo $donnees['ID_OFFRE'];?>">Modifier Offre</a>
				<a href="index.php?category=27&&id=<?php echo $donnees['ID_OFFRE'];?>" onclick="return confirm('Voulez-vous vraiment suprimer cette offre ?');">Supprimer Offre</a>
				<?php }
			echo '<br/>';
		}
	}
	
	
	//Liste des offres vu par l'administrateur
	public function getOffresParAdministrateur(){
		$bdd1 = $this->bdd;
		
		$req1 = $bdd1->prepare("SELECT NOM_RESTO, ID_RESTO, ID_USER FROM RESTAURANT WHERE RESTAURANT.ACTIF=1");
		$aListe1 = $req1->execute(array());
		
		while ($donnees1 = $req1->fetch()) {
			
			$bdd = $this->bdd;
			$req = $bdd->prepare("SELECT PRENOM, NOM FROM MEMBRE WHERE MEMBRE.ID_USER= :id");
			$aListe = $req->execute(array('id' => $donnees1['ID_USER']));
				
				
				while ($donnees = $req->fetch()) {
			
					echo 'Liste des offres du restaurant '.$donnees1['NOM_RESTO'].' dont le propriétaire est '.$donnees['PRENOM'].' '.$donnees['NOM'].' : <br /><br />'; 
			
					$bdd2 = $this->bdd;
					$req2 = $bdd2->prepare("SELECT ID_OFFRE, DESCRIPTIF FROM OFFRE WHERE OFFRE.ID_RESTO = :id AND ACTIF=1");
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
	public function calendrier_initialise($iIresto, $tJours_dispos, $tHoraires_dispos, $iNbtables) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("INSERT INTO `CALENDRIER_HEBDO`(`ID_RESTO`, `JOUR`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES (?,?,?,?,1)");
		foreach($tJours_dispos as $jour){
			foreach($tHoraires_dispos as $horaire){
				$req->execute(array($iIresto, $jour, $horaire, $iNbtables));
			}
		}
		$req->closeCursor();
		
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

		$req2 = $bdd2->prepare("SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE RESTAURANT.ID_USER = $iId AND ACTIF=1");
		$aListe2 = $req2->execute(array());

		
		while ($donnees2 = $req2->fetch()) {
			echo  $donnees2['NOM_RESTO'].' '?> <a href="index.php?category=9&&id=<?php echo $donnees2['ID_RESTO'];?>">Details</a>
												<a href="index.php?category=20&&id=<?php echo $donnees2['ID_RESTO'];?>">Offres</a> <?php
			echo '<br/>';
		}
		
		
		$req2->closeCursor();
	
	}
	//vérifier si l'offre a déjà été réservé
	public function if_offre_reserved($iIdoffre) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("SELECT ID_RESA FROM `RESERVATION` WHERE ID_OFFRE = $iIdoffre");
		$aListe = $req->execute(array());
		if($donnees = $req->fetch()){
			return true; 
		}
		else{
			return false;
		}
		$req->closeCursor();
	}
	//chercher idresto par idoffre 
	public function getIdrestoParIdoffre($iIdoffre) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("SELECT ID_RESTO FROM `OFFRE` WHERE ID_OFFRE = $iIdoffre");
		$aListe = $req->execute(array());
		
		if($donnees = $req->fetch()){
			return $donnees['ID_RESTO']; 
		}
		else{
			return 0;
		}
		$req->closeCursor();
	}
	
	// Détails d'un restaurants
	public function getDetailRestaurant($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM RESTAURANT WHERE RESTAURANT.ID_RESTO = $iId AND ACTIF=1");
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

		$req = $bdd->prepare("SELECT * FROM RESERVATION INNER JOIN OFFRE ON RESERVATION.ID_OFFRE = OFFRE.ID_OFFRE INNER JOIN RESTAURANT ON OFFRE.ID_RESTO = RESTAURANT.ID_RESTO WHERE RESTAURANT.ID_USER = $iId GROUP BY DATE_RESA");
		$aListe = $req->execute(array());
		
		echo "La liste de mes reservations : <br/><br/>";
		
		while ($donnees = $req->fetch()) {
		
			$dDateCurrent = date('Y-m-d H:i:s');

			if ($dDateCurrent < $donnees['DATE_RESA']) {
				echo  'Le '.$donnees['DATE_RESA'].' : '.$donnees['NB_TABLES'].' table(s) pour '.$donnees['NB_PRS'].' personne(s) au nom de ';
				echo $donnees['PRENOM'].' '.$donnees['NOM'].' (Email : '.$donnees['EMAIL_CLIENT'].')';
				echo '<br/><br/>';
			}
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
	
	
	// Ajouter un restaurant
	public function insertRestaurant($oRestaurant){
		$bdd = $this->bdd;
		$iId = $_GET['id'];
		
		$req=$bdd->prepare("INSERT INTO RESTAURANT (ID_USER, NOM_RESTO, ADRESSE, TELEPHONE, DESCRIPTIF, IMAGE, ACTIF) VALUES ('$iId', :nom, :adresse, :telephone, :descriptif, ' ', 1)");

	    $req->bindValue(':nom',$oRestaurant->getNom(), PDO::PARAM_STR);
	    $req->bindValue(':adresse',$oRestaurant->getAdresse(), PDO::PARAM_STR);
	    $req->bindValue(':telephone',$oRestaurant->getTelephone(), PDO::PARAM_STR);
	    $req->bindValue(':descriptif',$oRestaurant->getDescriptif(), PDO::PARAM_STR);

	    $bReturn = $req->execute();
	    $req->CloseCursor();

    	return $bReturn;
	}
	
	
	// Modification restaurant
	public function updateRestaurant($iId, $sTelephone, $sDescriptif) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("UPDATE RESTAURANT SET TELEPHONE = '$sTelephone', DESCRIPTIF = '$sDescriptif' WHERE ID_RESTO = '$iId'");

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
	public function reservation_putdata($iIdoffre, $sEmail, $sNom, $sPrenom, $sDate_resa, $iNbtables, $iNbPrs ){
		$bdd = $this->bdd;
		$req=$bdd->prepare('INSERT INTO `reservation`(`ID_RESA`, `ID_OFFRE`, `EMAIL_CLIENT`, `NOM`, `PRENOM`, `DATE_RESA`, `NB_TABLES`, `NB_PRS`, `DATE_CREER`, `ACTIF`) VALUES (\'\',?,?,?,?,?,?,?,?,1)');


	    if($bReturn = $req->execute(array($iIdoffre,$sEmail,$sNom,$sPrenom,$sDate_resa,$iNbtables,$iNbPrs,date("Y-m-d H:i:s")))){
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
		
		// eliminer les créneaux déjà réservé par différents offres d'un restaurants
		$req = $bdd->prepare('SELECT `ID_OFFRE` FROM `OFFRE`   WHERE `ID_RESTO` = ?');
		if($bReturn = $req->execute(array($iIdresto))){
			while($row = $req -> fetch()){
				$req2 = $bdd->prepare('SELECT `DATE_RESA`,`NB_TABLES` FROM `reservation`   WHERE `ID_OFFRE` = ? and `DATE_RESA` Between ? And ?');
				if($bReturn = $req2->execute(array($row['ID_OFFRE'],$sStartDate,$sEndDate))){
					while($row2 = $req2 -> fetch()){
						$calendrier[substr($row2['DATE_RESA'],0,10)][substr($row2['DATE_RESA'],11,8)] -= $row2['NB_TABLES'];
						if($calendrier[substr($row2['DATE_RESA'],0,10)][substr($row2['DATE_RESA'],11,8)] <=0){
							unset($calendrier[substr($row2['DATE_RESA'],0,10)][substr($row2['DATE_RESA'],11,8)]);
						}
					}
					$req2->CloseCursor();
				}else{
					$req2->CloseCursor();
					return $bReturn;
				}
			}
			$req->CloseCursor();
		}else{
			$req->CloseCursor();
			return $bReturn;
		}
		foreach ($calendrier as $date => $calendrier_jour){
			if(empty($calendrier[$date]))
				unset($calendrier[$date]);
		}
		$db = null;
		return $calendrier;
	}
	/* public function reservation_get_by_month($iIdoffre, $sStartDate, $sEndDate){
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
	} */
}
?>
