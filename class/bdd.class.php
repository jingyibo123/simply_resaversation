<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est la seule classe qui a l'authorisation de communiquer
    a la base de donnees. Elle ne contient que des fonctions de requetages.  

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
	//Si aucun parametre ne lui est passe, il charge la base de donnees a partir des constantes
	//contenu dans le fichier parametres. Sinon il charge la base de donnees passee en argument.
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
	
	public function user_getDetails($iId){
		$bdd = $this->bdd;
		
		$req=$bdd->prepare("SELECT * FROM MEMBRE WHERE ID_USER = $iId");

	    $aListe = $req->execute(array());

		$donnees = $req->fetch();
		echo 'Vos informations personnelles :<br /><br />';
		echo 'Nom : '.$donnees['NOM'].'<br />'; 
		echo 'Prenom : '.$donnees['PRENOM'].'<br/>';
		echo 'Adresse e-mail : '.$donnees['EMAIL'].'<br/>'; 
		$req->closeCursor();
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

    	return $bReturn;
	    
	}

	public function modifierMdp($iId, $sNvMdp){
		$bdd = $this->bdd;

		$req = $bdd->prepare('UPDATE MEMBRE SET MDP = :nv_mdp WHERE ID_USER = :id_user ');
		$req->bindValue(':nv_mdp',$sNvMdp, PDO::PARAM_STR);
		$req->bindValue(':id_user',$iId, PDO::PARAM_STR);
	    $bReturn = $req->execute();
	    $req->CloseCursor();
	}

	public function user_delete($iId){
		$bdd = $this->bdd;

		$req1 = $bdd->prepare('UPDATE MEMBRE SET ACTIF = 0 WHERE ID_USER = :id_user ');
		$req1->bindValue(':id_user',$iId, PDO::PARAM_STR);
	    $bReturn = $req1->execute();
	    $req1->CloseCursor();
		
		$req2 = $bdd->prepare('UPDATE RESTAURANT SET ACTIF = 0 WHERE ID_USER = :id_user ');
		$req2->bindValue(':id_user',$iId, PDO::PARAM_STR);
	    $bReturn = $req2->execute();
	    $req2->CloseCursor();
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
		
		//Techniquement une adresse email est associe a un unique ID. A verifier !
		return $iId;
	}
	
	public function getRestaurants(){
		$bdd = $this->bdd;
		
		$req = $bdd->prepare('SELECT NOM_RESTO, ID_RESTO FROM RESTAURANT WHERE ACTIF = 1');
		$aListe = $req->execute(array());
		
		echo "Liste des restaurants </br></br>";
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM_RESTO'].' ' ?> <a href="index.php?category=9&&id=<?php echo $donnees['ID_RESTO']; ?>">Details</a><?php
			echo '  ';?>
			<a href="index.php?category=20&&id=<?php echo $donnees['ID_RESTO']; ?>">Offres</a>
			<a href="index.php?category=46&&id=<?php echo $donnees['ID_RESTO'];?>" onclick="return confirm('Voulez-vous vraiment suprimer ce restaurant ?');">Supprimer Restaurant</a><?php
			echo'<br />';  
		}
		
		$req->closeCursor();
		
	}
	
	// Liste des restaurateurs
	public function getRestaurateurs() {
		$bdd = $this->bdd;
		
		$req = $bdd->prepare('SELECT ID_USER, NOM, PRENOM FROM MEMBRE WHERE MEMBRE.DROIT = 2 GROUP BY NOM');
		$aListe = $req->execute(array());
		
		echo "Liste des restaurateurs </br></br></br>";
		while ($donnees = $req->fetch()) {
			echo  $donnees['NOM'].' '.$donnees['PRENOM'] ?> <a href="index.php?category=8&&id=<?php echo $donnees['ID_USER'];?>">Restaurants</a> <?php
			?>
			<a href="index.php?category=42&&id=<?php echo $donnees['ID_USER']; ?>"> Supprimer le compte </a>
			<?php
			echo'<br/>';
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
	
	//Supprimer une offre
	public function supprimerOffre($iId_offre) {
		$bdd = $this->bdd;


		$req = $bdd->prepare('UPDATE OFFRE SET ACTIF = 0 WHERE ID_OFFRE = :id_offre ');
		
		$req->bindValue(':id_offre',$iId_offre, PDO::PARAM_STR);
	    
	    
	    

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
			
					echo 'Liste des offres du restaurant '.$donnees1['NOM_RESTO'].' dont le proprietaire est '.$donnees['PRENOM'].' '.$donnees['NOM'].' : <br /><br />'; 
			
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
	
	
	public function put_connextion_client($iIdoffre, $sIp, $sUrl, $sDate) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("INSERT INTO `CONNEXION_CLIENT`(`ID_OFFRE`, `IP`, `URL`, `VISITE`) VALUES (?,?,?,?)");
		if($bReturn = $req->execute(array($iIdoffre, $sIp, $sUrl, $sDate))){
		}
		else{
			$req->closeCursor();
			break;
		}
		return $req->errorInfo();
		$req->closeCursor();
	}
	
	
	public function put_connextion_erronee($sIp, $sUrl, $sDate) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("INSERT INTO `CONNEXION_ERRONEE`(`IP`, `URL`, `VISITE`) VALUES (?,?,?)");
		if($bReturn = $req->execute(array($sIp, $sUrl, $sDate))){
		}
		else{
			$req->closeCursor();
			break;
		}
		return $req->errorInfo();
		$req->closeCursor();
	}
	
	
	public function calendrier_initialise($iIresto, $tJours_dispos, $tHoraires_dispos, $iNbtables) {
		$bdd = $this->bdd;
		$req = $bdd->prepare("INSERT INTO `CALENDRIER_HEBDO`(`ID_REGLE_HEBDO`, `ID_RESTO`, `JOUR`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES ('',?,?,?,?,1)");
		$bReturn = true;
		foreach($tJours_dispos as $jour){
			foreach($tHoraires_dispos as $horaire){
				if($bReturn = $req->execute(array($iIresto, $jour, $horaire, $iNbtables))){
					
				}
				else{
					$req->closeCursor();
					break;
				}
			}
			if(!$bReturn){break;}
		}
		return $req->errorInfo();
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
	
	
	// Liste des restaurants par restaurateurs (lorsque l'on est connecte en tant qu'admin)
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
			echo  $donnees2['NOM_RESTO'].' '?> <a href="index.php?category=9&&id=<?php echo $donnees2['ID_RESTO'];?>">Details</a> <?php
			echo '  ';?>
			<a href="index.php?category=20&&id=<?php echo $donnees2['ID_RESTO'];?>">Offres</a>
				<a href="index.php?category=46&&id=<?php echo $donnees2['ID_RESTO'];?>" onclick="return confirm('Voulez-vous vraiment suprimer ce restaurant ?');">Supprimer Restaurant</a><?php
			echo '<br/>';
		}
		
		
		$req2->closeCursor();
	
	}
	//vérifier si l'offre a deja ete reservee
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
	
	// Details d'un restaurants
	public function getDetailRestaurant($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM RESTAURANT, MEMBRE WHERE RESTAURANT.ID_RESTO = $iId AND RESTAURANT.ACTIF=1 AND RESTAURANT.ID_USER = MEMBRE.ID_USER");
		$aListe = $req->execute(array());
		
		$donnees = $req->fetch();
		echo 'Restaurant : '.$donnees['NOM_RESTO'].' <br /><br />'; 
		if ($_SESSION['droit'] == 1) {
			echo 'Propriétaire : '.$donnees['PRENOM'].' '.$donnees['NOM'].'<br/>';
		}
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
	
	//Supprimer un Restaurant
	public function supprimerRestaurant($iId_resto) {
		$bdd = $this->bdd;


		$req = $bdd->prepare('UPDATE RESTAURANT SET ACTIF = 0 WHERE ID_RESTO = :id_resto ');
		
		$req->bindValue(':id_resto',$iId_resto, PDO::PARAM_STR);
	    

	    $bReturn = $req->execute();
	    $req->CloseCursor();
		
		return $bReturn;
	}
	
	
	// Liste des réservations par restaurateur
	public function getReservations($iId) {
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM RESERVATION INNER JOIN OFFRE ON RESERVATION.ID_OFFRE = OFFRE.ID_OFFRE INNER JOIN RESTAURANT ON OFFRE.ID_RESTO = RESTAURANT.ID_RESTO WHERE RESERVATION.ACTIF=1 AND RESTAURANT.ID_USER = $iId GROUP BY DATE_RESA");
		$aListe = $req->execute(array());
		
		echo "La liste de mes reservations : <br/><br/>";
		
		while ($donnees = $req->fetch()) {
		
			$dDateCurrent = date('Y-m-d H:i:s');

			if ($dDateCurrent < $donnees['DATE_RESA']) {
				
					echo  'Le '.$donnees['DATE_RESA'].' : '.$donnees['NB_TABLES'].' table(s) pour '.$donnees['NB_PRS'].' personne(s) au nom de ';
					echo $donnees['PRENOM'].' '.$donnees['NOM'].' (Email : '.$donnees['EMAIL_CLIENT'].')'?>
					<a href="index.php?category=44&&id=<?php echo $donnees['ID_RESA']; ?>">Annuler la reservation</a><?php
					echo '<br/><br/>';
				
			}
		}
		
		$req->closeCursor();
	}
	
		// Annuler une reservation

	public function annulerReservation($oAnnulation, $dDateAnnulation) {
		$bdd = $this->bdd;
		$iId = $_GET['id'];
		
		$req2 = $bdd->prepare("UPDATE RESERVATION SET ACTIF = 0 WHERE ID_RESA = '$iId'");
		$bReturn2 = $req2->execute();
		$req2->CloseCursor();

		$req1 = $bdd->prepare("INSERT INTO ANNULATION_RESA (`ID_RESA`, `MOTIF`, `DATE_ANNULATION`) VALUES ('$iId', :motif, '$dDateAnnulation')");
	    $req1->bindValue(':motif',$oAnnulation->getMotif(), PDO::PARAM_STR);
	    $bReturn1 = $req1->execute();
	    $req1->CloseCursor();

		return $bReturn2;
	}
	
	
	// Notifications administrateur pour annulation reservation
	public function notifAnnulationResa($dCurrentDate) {
		$iDateExpiration = 864000; // Correspond a?10 jours
		$dDateCurrent1 = strtotime($dCurrentDate);
		
		$bdd = $this->bdd;

		$req = $bdd->prepare("SELECT * FROM ANNULATION_RESA INNER JOIN RESERVATION ON ANNULATION_RESA.ID_RESA = RESERVATION.ID_RESA 
							INNER JOIN OFFRE ON RESERVATION.ID_OFFRE = OFFRE.ID_OFFRE INNER JOIN RESTAURANT ON OFFRE.ID_RESTO = RESTAURANT.ID_RESTO 
							INNER JOIN MEMBRE ON RESTAURANT.ID_USER = MEMBRE.ID_USER ORDER BY DATE_ANNULATION DESC");
		$aListe = $req->execute(array());
		while ($donnees = $req->fetch()) {
			$dDateAnnulation = strtotime($donnees['DATE_ANNULATION']);
			if (($dDateCurrent1-$dDateAnnulation)<$iDateExpiration) {
				echo 'Le '.$donnees['DATE_ANNULATION'].' :<br/>';
				echo $donnees['PRENOM'].' '.$donnees['NOM'].' a annule sa reservation du '.$donnees['DATE_RESA'].' pour '.$donnees['NB_PRS'].' personne(s).<br/>';
				echo 'Motif : '.$donnees['MOTIF'].'<br/>';
				echo 'Cliquez '?> <a href="index.php?category=28&&id=<?php echo $donnees['ID_USER'];?>">ici</a><?php 
				echo ' pour acceder profil du restaurateur.<br/>';
			}
		}
		
		$req->closeCursor();		
	}

	
	
	// Donnees restaurant
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
		if($bReturn == true){
	    	return $bdd->lastInsertId();
	    }else{
	    	return 0;
		}
	    $req->CloseCursor();

    	return $bReturn;
	}
	
	
	// Modification restaurant
	public function updateRestaurant($iId, $sTelephone, $sDescriptif, $dDateModif) {
		$bdd = $this->bdd;

		$req1 = $bdd->prepare("UPDATE RESTAURANT SET TELEPHONE = '$sTelephone', DESCRIPTIF = '$sDescriptif', DATE_DERNIERE_MODIF = '$dDateModif' WHERE ID_RESTO = '$iId'");
	    $bReturn1 = $req1->execute();
	    $req1->CloseCursor();

		if ($_SESSION['droit'] == 2) {
			$req2 = $bdd->prepare("INSERT INTO NOTIFICATIONS_RESTO (ID_RESTO, DATE_MODIF) VALUES ('$iId', '$dDateModif')");
			$bReturn2 = $req2->execute();
			$req2->CloseCursor();
		}
		
		return $bReturn1;
	}


	// Notifications administrateur pour modification restaurant
	public function notifUpdateRestaurant($dCurrentDate) {
		$iDateExpiration = 864000; // Correspond a 10 jours
		$dDateCurrent1 = strtotime($dCurrentDate);
		
		$bdd = $this->bdd;
		
		$req = $bdd->prepare("SELECT * FROM NOTIFICATIONS_RESTO INNER JOIN RESTAURANT ON NOTIFICATIONS_RESTO.ID_RESTO = RESTAURANT.ID_RESTO INNER JOIN MEMBRE ON RESTAURANT.ID_USER = MEMBRE.ID_USER ORDER BY DATE_MODIF DESC");
		$aListe = $req->execute(array());
		while ($donnees = $req->fetch()) {
			$dDateModif = strtotime($donnees['DATE_MODIF']);
			if (($dDateCurrent1-$dDateModif)<$iDateExpiration) {
				echo 'Le '.$donnees['DATE_MODIF'].' :<br/>';
				echo 'Le restaurant '.$donnees['NOM_RESTO'].' a ete modifie par '.$donnees['PRENOM'].' '.$donnees['NOM'].'<br/>';
				echo 'Cliquez '?> <a href="index.php?category=9&&id=<?php echo $donnees['ID_RESTO'];?>">ici</a><?php 
				echo ' pour acceder aux modifications<br/><br/>';
			}
		}
		
		$req->closeCursor();		
	}
	
	
	// Modification image restaurant
	public function updateImage($iId, $sNomImage, $dDateModif) {
		$bdd = $this->bdd;
		
		$req1 = $bdd->prepare("UPDATE RESTAURANT SET IMAGE = '$sNomImage', DATE_DERNIERE_MODIF = '$dDateModif' WHERE ID_RESTO = '$iId'");
		$bReturn1 = $req1->execute();
		$req1->CloseCursor();
		
		if ($_SESSION['droit'] == 2) {
			$req2 = $bdd->prepare("INSERT INTO NOTIFICATIONS_RESTO (ID_RESTO, DATE_MODIF) VALUES ('$iId', '$dDateModif')");
			$bReturn2 = $req2->execute();
			$req2->CloseCursor();
		}
		
		return $bReturn1;
	}
	
	
	// RESTAURATEURS 
	public function user_getListeRestaurants($iId_user) {
		$bdd = $this->bdd;
		//On verifie qu'il s'agit bien d'un restaurateur !
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
	
		// A verifier : forme du tableau retourne
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
	public function get_calendar_weeklyrules($iIdresto){
		$bdd = $this->bdd;
		$weeklyrules = Array ();
		$req = $bdd->prepare('SELECT ID_REGLE_HEBDO,JOUR,HORAIRE,NB_TABLES FROM `calendrier_hebdo`  WHERE `ID_RESTO` = ? and `ACTIF` = 1 ORDER BY JOUR, HORAIRE');
		if($bReturn = $req->execute(array($iIdresto))){
			while($row = $req -> fetch(PDO::FETCH_ASSOC)){
				array_push($weeklyrules,$row);
			}
			for($i = 0;$i < count($weeklyrules); $i++){
				switch ($weeklyrules[$i]['JOUR']){
				case 1:
					$weeklyrules[$i]['JOUR'] = 'Lundi';
				break;
				case 2:
					$weeklyrules[$i]['JOUR'] = 'Mardi';
				break;
				case 3:
					$weeklyrules[$i]['JOUR'] = 'Mercredi';
				break;
				case 4:
					$weeklyrules[$i]['JOUR'] = 'Jeudi';
				break;
				case 5:
					$weeklyrules[$i]['JOUR'] = 'Vendredi';
				break;
				case 6:
					$weeklyrules[$i]['JOUR'] = 'Samedi';
				break;
				case 7:
					$weeklyrules[$i]['JOUR'] = 'Dimanche';
				break;
				}
			}
			$req->CloseCursor();
			return $weeklyrules;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function get_calendar_specialrules($iIdresto){
		$bdd = $this->bdd;
		$specialrules = Array ();
		$req = $bdd->prepare('SELECT ID_REGLE_EXCEP,DATE_EXCEPTION,HORAIRE,NB_TABLES FROM `calendrier_exception`  WHERE `ID_RESTO` = ? and `ACTIF` = 1 ORDER BY DATE_EXCEPTION, HORAIRE');
		if($bReturn = $req->execute(array($iIdresto))){
			while($row = $req -> fetch(PDO::FETCH_ASSOC)){
				array_push($specialrules,$row);
			}
			$req->CloseCursor();
			return $specialrules;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function delete_calendar_weeklyrules($iIdregle){
		$bdd = $this->bdd;
		$req = $bdd->prepare('DELETE FROM `calendrier_hebdo` WHERE `ID_REGLE_HEBDO` = ?');
		if($bReturn = $req->execute(array($iIdregle))){
			$req->CloseCursor();
			return 0;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function delete_calendar_specialrules($iIdregle){
		$bdd = $this->bdd;
		$req = $bdd->prepare('DELETE FROM `calendrier_exception` WHERE `ID_REGLE_EXCEP` = ?');
		if($bReturn = $req->execute(array($iIdregle))){
			$req->CloseCursor();
			return 0;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function put_calendar_weeklyrules($iIdresto,$iJour,$sHoraire,$iNbtables){
		$bdd = $this->bdd;
		$req = $bdd->prepare('INSERT INTO `calendrier_hebdo`(`ID_REGLE_HEBDO`, `ID_RESTO`, `JOUR`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES (\'\',?,?,?,?,1)');
		if($bReturn = $req->execute(array($iIdresto,$iJour,$sHoraire,$iNbtables))){
			$req->CloseCursor();
			return 0;
		}else{
			if($req->errorInfo()[1] == 1062){
				$_SESSION['msg_alert'] = 'Cette regle est deja definie, veuillez verifier';
			}
			$req->CloseCursor();
			return 1;
		}
	}
	public function put_calendar_specialrules($iIdresto,$sDate,$sHoraire,$iNbtables){
		$bdd = $this->bdd;
		$req = $bdd->prepare('INSERT INTO `calendrier_exception`(`ID_REGLE_EXCEP`, `ID_RESTO`, `DATE_EXCEPTION`, `HORAIRE`, `NB_TABLES`, `ACTIF`) VALUES (\'\',?,?,?,?,1)');
		if($bReturn = $req->execute(array($iIdresto,$sDate,$sHoraire,$iNbtables))){
			$req->CloseCursor();
			return 0;
		}else{
			if($req->errorInfo()[1] == 1062){
				$_SESSION['msg_alert'] = 'Cette regle est deja definie, veuillez verifier';
			}
			$req->CloseCursor();
			return 1;
		}
	}
	public function update_calendar_weeklyrules($iIdregle,$iNbtables){
		$bdd = $this->bdd;
		$req = $bdd->prepare('UPDATE `calendrier_hebdo` SET `NB_TABLES`= ? WHERE `ID_REGLE_HEBDO` = ?');
		if($bReturn = $req->execute(array($iNbtables,$iIdregle))){
			$req->CloseCursor();
			return 0;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function update_calendar_specialrules($iIdregle,$iNbtables){
		$bdd = $this->bdd;
		$req = $bdd->prepare('UPDATE `calendrier_exception` SET `NB_TABLES`= ? WHERE `ID_REGLE_EXCEP` = ?');
		if($bReturn = $req->execute(array($iNbtables,$iIdregle))){
			$req->CloseCursor();
			return 0;
		}else{
			$req->CloseCursor();
			return 0;
		}
	}
	public function get_calendar_defined($iIdresto, $sStartDate, $sEndDate){
		$bdd = $this->bdd;
		$calendrier = Array ();
		for($date = strtotime($sStartDate); $date <= strtotime($sEndDate); $date = strtotime("+1days",$date)){
			$req = $bdd->prepare('SELECT * FROM `calendrier_hebdo`  WHERE `id_resto` = ? and `jour` = ?');
			$jour = date("w",$date);
			if($bReturn = $req->execute(array($iIdresto,$jour))){
				while($row = $req -> fetch(PDO::FETCH_ASSOC)){
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
			while($row = $req -> fetch(PDO::FETCH_ASSOC)){
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
		foreach ($calendrier as $date => $calendrier_jour){
			if(empty($calendrier[$date]))
				unset($calendrier[$date]);
		}
		return $calendrier;
	}
	public function get_calendar_available($iIdresto, $sStartDate, $sEndDate){
		// eliminer les creneaux deja reserves par differentes offres d'un restaurant
		$bdd = $this->bdd;
		$calendrier = $this->get_calendar_defined($iIdresto, $sStartDate, $sEndDate);
		$req = $bdd->prepare('SELECT `ID_OFFRE` FROM `OFFRE`   WHERE `ID_RESTO` = ?');
		if($bReturn = $req->execute(array($iIdresto))){
			while($row = $req -> fetch()){
				$req2 = $bdd->prepare('SELECT `DATE_RESA`,`NB_TABLES` FROM `reservation`   WHERE `ID_OFFRE` = ? and `DATE_RESA` Between ? And ?');
				if($bReturn = $req2->execute(array($row['ID_OFFRE'],$sStartDate,$sEndDate))){
					while($row2 = $req2 -> fetch(PDO::FETCH_ASSOC)){
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