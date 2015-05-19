<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à diriger l'utilisateur et à traiter les informations
	dynamiques. C'est le controller, c'est lui qui appel les classes et les
	vues.

/ ------------------------------------------------------------------------- */

	$iCategory = isset($_GET['offre']) ? 31 : 0;
	if($iCategory!=31){$iCategory = isset($_GET['category']) && $_GET['category'] > 0 ? $_GET['category'] : 0;}


	switch($iCategory){
		
		case 1:
			if($_SESSION['droit']==1){
			define('ROOTING', 'view/inscription.view.php');

			if(isset($_POST['inscription']) && !empty($_POST['inscription'])){

				require_once 'class/user.class.php';

				$oUser = new User();

				$oUser->setNom($_POST['inscription']['nom']);
				$oUser->setPrenom($_POST['inscription']['prenom']);
				$oUser->setMdp($_POST['inscription']['mdp']);
				$oUser->setEmail($_POST['inscription']['email']);
				$oUser->setDroit($_POST['inscription']['droit']);

				$oUser->validation();
				
				require_once 'class/bdd.class.php';

					$oBdd = new Bdd();
				
				// si les deux mots de passes ne sont pas identiques
				if($_POST['inscription']['confirm'] != $oUser->getMdp() ){?>
					<script>alert("<?php echo htmlspecialchars('Les mots de passe indiqués ne sont pas les mêmes, veuillez remplir le formulaire à nouveau', ENT_QUOTES); ?>")</script>
					<?php
				}
				
				
				//Si l'email n'existe pas déjà dans la base de donnée
				elseif($oBdd->user_checkEmail($oUser->getEmail())>0){
					?>
					<script>alert("<?php echo htmlspecialchars('L adresse email indiquée est déjà associée à un compte existant', ENT_QUOTES); ?>")</script>
					<?php 
					
				}
				//S'il n'y a aucun retour d'erreur
				elseif(empty($oUser->aError)){

					

					$iReturnIdent = $oBdd->user_insert($oUser);

					if($iReturnIdent ){
						//$_SESSION['id_user'] = $iReturnIdent;
						header('Location: index.php?category=6');
					}
					else{
						echo 'erreur inscription';
						header('Location: index.php?category=1');
					}	
				}
			}
			}
		break;
		
		case 0:
			define('ROOTING', 'view/connexion.view.php');
			
			if (isset($_POST['connexion']) && !empty($_POST['connexion'])){
				
				
				$sEmail = $_POST['connexion']['email'];
				$sMdp = md5($_POST['connexion']['mdp']);
				
				if(empty($oUser->aError)){
					require_once 'class/bdd.class.php';
					
					
					$oBdd = new Bdd();
					$aUserdata = $oBdd->user_checkData($sEmail,$sMdp);
					
					if (!empty($aUserdata)){
						$_SESSION['id_user'] = $aUserdata['id_user'];
						$_SESSION['prenom'] = $aUserdata['prenom'];
						$_SESSION['nom'] = $aUserdata['nom'];
						$_SESSION['droit'] = $aUserdata['droit'];

						header('Location: index.php?category=4');
					}
					else{
						
						?>
					<script>alert("<?php echo htmlspecialchars('Adresse email ou mot de passe incorrect', ENT_QUOTES); ?>")</script>
					<?php
						
					}
				}
			}
			
		break;
		
		
		case 4:
			define('ROOTING', 'include/menu.inc.php');
			
		break;
		
		case 5:
			define('ROOTING', 'view/restaurants.view.php');
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			
				$aListeRestaurants = $oBdd->getRestaurants();
				
		break;
		
		case 6:
			define('ROOTING', 'view/message.view.php');
			
				
		break;
		
		case 7:
			define('ROOTING', 'view/restaurateurs.view.php');
			
			require_once 'class/bdd.class.php';

			$oBdd = new Bdd();
			
			$aListeRestaurateurs = $oBdd->getRestaurateurs();
		break;
		
		case 8:
			define('ROOTING', 'view/restoParRestaurateur.view.php');
			
			require_once 'class/bdd.class.php';

			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aListeRestaurants = $oBdd->getRestaurantParRestaurateur($iId);
		break;
		
		case 9:
			define('ROOTING', 'view/detailRestaurant.view.php');
			
			require_once 'class/bdd.class.php';

			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aListeRestaurants = $oBdd->getDetailRestaurant($iId);
		break;
		
		case 10:
			define('ROOTING', 'view/restaurantsRestaurateur.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_SESSION['id_user'];
			$aListeRestaurants = $oBdd->getRestaurantsRestaurateur($iId);
		break;
		
		case 11:
			define('ROOTING', 'view/reservations.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_SESSION['id_user'];
			$aListeRestaurants = $oBdd->getReservations($iId);
		break;
		
		case 12:
			define('ROOTING', 'view/offres.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_SESSION['id_user'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		break;
		
		case 13: 
			define('ROOTING', 'view\modificationRestaurant.view.php');
			
			require_once 'class/bdd.class.php';
			require_once 'class/restaurant.class.php';
			
			if(isset($_POST['modification']) && !empty($_POST['modification'])){

				$sTelephone = $_POST['modification']['telephone'];
				$sDescriptif = $_POST['modification']['descriptif'];
				$iId = $_GET['id'];
				$dCurrentDate = date('Y-m-d H:i:s');
				
				$oRestaurant = new Restaurant();
				$oRestaurant->setTelephone($sTelephone);
				$oRestaurant->setDescriptif($sDescriptif);
				
				$oRestaurant->validation();
				
				if (empty($oRestaurant->aError)) {
					$oBdd = new Bdd();
					
					$aModifResto = $oBdd->updateRestaurant($iId, $sTelephone, $sDescriptif, $dCurrentDate);
						
					if(!empty($aModifResto) ){
						unset($_SESSION['ID_RESTO_MODIF']);
						header('Location: index.php?category=14');
					}
					else{
						echo 'Erreur modification : Merci de remplir à nouveau le formulaire';
						header('Location: index.php?category=13&&id='.$iId);
					}
				}
			}
		break;
		
		case 14:
			define('ROOTING', 'view/messageModifResto.view.php');
		break;
		
		case 15:
			define('ROOTING', 'view/modificationImage.view.php');
		break;
		
		case 16:
			define('ROOTING', 'class/upload.php');
			$iId = $_GET['id'];
			if (!isset($_FILES['image']) OR $_FILES['image']['error'] != 0) {
				echo 'Erreur téléchargement : Merci de télécharger à nouveau votre image';
				header('Location: index.php?category=15&&id='.$iId);
			}

		break;
		
		case 17:
			define('ROOTING', 'view/offres.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$aListeOffres = $oBdd->getOffresParAdministrateur();
		break;
		
		case 18: 
			define('ROOTING', 'view\ajoutOffre.view.php');
			
			require_once 'class/bdd.class.php';
			require_once 'class/offres.class.php';
			
			if(isset($_POST['ajout']) && !empty($_POST['ajout'])){

				
				$sDescriptif = $_POST['ajout']['descriptif'];
				$iId_resto = $_GET['id'];
				
				$oOffre = new Offre();
				$oOffre->setId_resto($iId_resto);
				$oOffre->setDescriptif($sDescriptif);
				
				$oOffre->validation();
				
				if (empty($oOffre->aError)) {
					$oBdd = new Bdd();
					
					$aAjoutOffre = $oBdd->ajoutOffre($oOffre);
						
					if(!empty($aAjoutOffre) ){
						header('Location: index.php?category=24');
					}
					else{
						echo 'Erreur modification : Merci de remplir à nouveau le formulaire';
						header('Location: index.php?category=18&&id='.$iId_resto);
					}
				}
				else{
					//echo $oOffre->aError['descriptif'];
				}
			}
		break;
		
		case 19:
			define('ROOTING', 'view/offres.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		break;
		
		case 20:
			define('ROOTING', 'view/offres.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurant($iId);
		break;
		
		case 21:
			define('ROOTING', 'view\modificationOffre.view.php');
			
			require_once 'class/bdd.class.php';
			require_once 'class/offres.class.php';
			
			if(isset($_POST['modification']) && !empty($_POST['modification'])){

				$sDescriptif = $_POST['modification']['descriptif'];
				$iId = $_GET['id'];
				
				$oOffre = new Offre();
				$oOffre->setDescriptif($sDescriptif);
				
				$oOffre->validation();
				
				if (empty($oOffre->aError)) {
					$oBdd = new Bdd();
					
					$aModifOffre = $oBdd->updateOffre($iId, $sDescriptif);
						
					if(!empty($aModifOffre) ){
						header('Location: index.php?category=22');
					}
					else{
						echo 'Erreur modification : Merci de remplir à nouveau le formulaire';
						header('Location: index.php?category=21&&id='.$iId);
					}
				}
			}
		break;
		
		case 22:
			define('ROOTING', 'view/messageModifOffre.view.php');
		break;
		
		case 23:
			define('ROOTING', 'view/offres.view.php');
			
			require_once 'class/bdd.class.php';
			
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		break;

		case 24:
			define('ROOTING', 'view/messageAjoutOffre.view.php');
		break;
		
		case 25:
			define('ROOTING', 'view/ajoutRestaurant.view.php');

			if(isset($_POST['ajoutResto']) && !empty($_POST['ajoutResto'])){

				require_once 'class/restaurant.class.php';

				$oRestaurant = new Restaurant();
				$iId = $_GET['id'];

				$oRestaurant->setNom($_POST['ajoutResto']['nom']);
				$oRestaurant->setAdresse($_POST['ajoutResto']['adresse']);
				$oRestaurant->setTelephone($_POST['ajoutResto']['telephone']);
				$oRestaurant->setDescriptif($_POST['ajoutResto']['descriptif']);

				$oRestaurant->validation();
				
				require_once 'class/bdd.class.php';

				$oBdd = new Bdd();
				
				if(empty($oRestaurant->aError)){

					$iReturnIdent = $oBdd->insertRestaurant($oRestaurant);

					if($iReturnIdent !=0){
						header('Location: index.php?category=26&&idresto='.$iReturnIdent);
					}
					else{
						echo 'erreur inscription';
						header('Location: index.php?category=25&&id='.$iId);
					}	
				}
			}
		break;
		
		case 26:
			define('ROOTING', 'view/messageAjoutRestaurant.view.php');
		break;

		case 27:
			
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			$iId_offre = $_GET['id'];
			$oBdd->supprimerOffre($iId_offre);
			define('ROOTING', 'view/messageSuppressionOffre.view.php');
			
		break;
		
		case 28 : 
			define('ROOTING', 'view/consultationProfil.view.php');
			require_once 'class/bdd.class.php';

			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aDetails = $oBdd->user_getDetails($iId);
		break;
			
		case 29:
			define('ROOTING', 'view/recapitulatifProfil.view.php');	
				require_once 'class/user.class.php';

				$oUser = new User();

				$oUser->setNom($_POST['nom']);
				$oUser->setPrenom($_POST['prenom']);
				$oUser->setSexe($_POST['sexe']);
				
				$sEmailComplete = $_POST['debutAdresse']."@";
				$sEmailComplete .= $_POST['domaineAdresse'];
				$sEmailComplete .= ".";
				$sEmailComplete .= $_POST['localAdresse'];;
				$oUser->setEmail($sEmailComplete);
				$oUser->setMdp($_POST['mdp1']);
				$oUser->setActif(true);
				
				if ($_POST['type'] == "Administrateur") {
					$oUser->setDroit(1);
				}
				else {
					$oUser->setDroit(2);
				}
				
				$oUser->validation();
				
				require_once 'class/bdd.class.php';

				$oBdd = new Bdd();
				if(empty($oUser->aError)){

					$iReturnIdent = $oBdd->user_insert($oUser);
					
					if($iReturnIdent ){
						header('Location: index.php?category=40');
					}
					else{
						echo 'erreur inscription';
						header('Location: index.php?category=29');
					}	
				}
		break;
		
		case 30:
			define('ROOTING', 'view/notifications.view.php');
			require_once 'class/bdd.class.php';
			$dDateCurrent = date('Y-m-d H:i:s');
			$oBdd = new Bdd();
			echo 'ANNULATIONS RESERVATIONS CLIENTS :<br/><br/>';
			$aListeNotifsResa = $oBdd->notifAnnulationResa($dDateCurrent);
			echo '<br/><br/>MODIFICATIONS PROFILS RESTAURANTS :<br/><br/>';
			$aListeNotifsResto = $oBdd->notifUpdateRestaurant($dDateCurrent);
		break;


		case 31:
			
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			require_once 'class/fonctions.class.php';
			$oFonctions = new Fonctions();
			$_SESSION['id_offre'] = $_GET['offre'];
			$_SESSION['ID_RESTO'] = $oBdd->getIdrestoParIdoffre($_GET['offre']);
			if($_SESSION['ID_RESTO']!=0){
				/* vérifier si cette offre a déjà été reservée */
				if(!$oBdd->if_offre_reserved($_GET['offre'])){
					/* Enregistrer IP */
					$oBdd->put_connextion_client($_GET['offre'],$oFonctions->get_ip(),$oFonctions->get_url(),date('Y-m-d H:i:s'));
					define('ROOTING', 'view/client.reserver.view.php');
				}
				else{
					define('ROOTING', 'view/client.offre_deja_reserve.view.php');
				}
			}
			else{
				/* Enregistrer IP erronée */ 
				$oBdd->put_connextion_erronee($oFonctions->get_ip(),$oFonctions->get_url(),date('Y-m-d H:i:s'));
				define('ROOTING', 'view/client.offre_error.view.php');
			}
		break;
		case 33:
			
			if(!isset($_SESSION['id_offre'])){
				echo "vueillez selectionner d'abord votre offre acheté";
			}
			elseif(isset($_POST['reservation']) && !empty($_POST['reservation'])){
				require_once 'class/bdd.class.php';
				$oBdd = new Bdd();
				$oBdd->reservation_putdata($_SESSION['id_offre'], $_POST['reservation']['EMAIL_CLIENT'],
				$_POST['reservation']['NOM'], $_POST['reservation']['PRENOM'], $_POST['reservation']['DATE_RESA'],
				$_POST['reservation']['NB_TABLES'], $_POST['reservation']['NB_PERSONNE'] );
				define('ROOTING', 'view/client.reserver.fini.view.php');	
			}
		break;	
		case 34:
			// define('ROOTING', 'view/modif.calendrier.regles.view.php');
		break;
		case 35:
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			if(isset($_GET['op'])){
				switch($_GET['op']){
					case 'delete_weeklyrule':
						$oBdd->delete_calendar_weeklyrules($_GET['ruleid']);
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
					case 'delete_specialrule':
						$oBdd->delete_calendar_specialrules($_GET['ruleid']);
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
					case 'modif_weeklyrule':
						$oBdd->update_calendar_weeklyrules($_POST['id'],$_POST['nbtables']);
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
					case 'modif_specialrule':
						$oBdd->update_calendar_specialrules($_POST['id'],$_POST['nbtables']);
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
					case 'create_weeklyrule':
						if($_POST['nbtables']==''){
							$_SESSION['msg_alert'] = 'Veuillez entrer le nombre de tables';
						}
						else{
							$oBdd->put_calendar_weeklyrules($_SESSION['ID_RESTO_MODIF'],$_POST['selecjour'],$_POST['selecthorairehebdo'].':00:00',$_POST['nbtables']);
						}
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
					case 'create_specialrule':
						if($_POST['nbtables']==''){
							$_SESSION['msg_alert'] = 'Veuillez entrer le nombre de tables';
						}
						elseif($_POST['dateexcepcree']==''){
							$_SESSION['msg_alert'] = 'Veuillez choisir le date exceptionnel';
						}
						else{
							$oBdd->put_calendar_specialrules($_SESSION['ID_RESTO_MODIF'],$_POST['dateexcepcree'],$_POST['selecthoraireexcep'].':00:00',$_POST['nbtables']);
						}
						header('Location: '.$_SERVER['PHP_SELF'].'?category=35');
						exit;
					break;
				}
			}else{
				define('ROOTING', 'view/restaurateur.modif.calendrier.defini.php');
			}
		break;
		
		case 100:
			session_destroy();
			header('Location: index.php?category=0');
		break;
		
		case 40:
			define('ROOTING', 'view/messageAjoutProfil.view.php');
		break;
		
		case 41:
			define('ROOTING', 'view/ajoutProfil.view.php');
		break;
				
		case 42:
			define ('ROOTING', 'view/supprimerProfil.view.php');
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aDetails = $oBdd->user_getDetails($iId);
		break;
		
		case 43:
			define('ROOTING', 'view/messageSuppresionProfil.view.php');
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$oBdd->user_delete($iId);
		break;
		
		case 44:
			define('ROOTING', 'view/annulationReservation.view.php');

			if(isset($_POST['annulation']) && !empty($_POST['annulation'])){

				require_once 'class/annulationReservation.class.php';

				$oAnnulation = new Annulation();
				$iId = $_GET['id'];
				$dCurrentDate = date('Y-m-d H:i:s');

				$oAnnulation->setMotif($_POST['annulation']['motif']);

				$oAnnulation->validation();
				
				require_once 'class/bdd.class.php';

				$oBdd = new Bdd();
				
				if(empty($oAnnulation->aError)){

					$aAnnulResa = $oBdd->annulerReservation($oAnnulation, $dCurrentDate);

					if(!empty($aAnnulResa)){
						header('Location: index.php?category=45');
					}
					else{
						echo 'erreur annulation';
						header('Location: index.php?category=44&&id='.$iId);
					}	
				}
			}
		break;
		
		case 45:
			define('ROOTING', 'view/messageAnnulationReservation.view.php');
		break;
		
		case 46:
			
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			
			$iId_resto = $_GET['id'];
			$oBdd->supprimerRestaurant($iId_resto);
			define('ROOTING', 'view/messageSuppressionRestaurant.view.php');
			
		break;
		case 47:
			define('ROOTING', 'view/modifierMdp.view.php');
		break;
		
		case 48:
			$sNvMdp = md5($_POST['mdp1']);
			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$oBdd->modifierMdp($iId, $sNvMdp);
			define('ROOTING', 'view/messageModifMdp.view.php');
		break;
		case 49 : 
			define('ROOTING', 'view/consultationProfilRestaurateur.view.php');
			require_once 'class/bdd.class.php';

			$oBdd = new Bdd();
			$iId = $_GET['id'];
			$aDetails = $oBdd->user_getDetails($iId);
		break;
	}

?>
