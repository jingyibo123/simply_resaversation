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
				
				//Si l'email n'existe pas déjà dans la base de donnée
				if($oBdd->user_checkEmail($oUser->getEmail())>0){
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
						
						echo 'error_log';
						define('ROOTING', 'view/connexion.view.php');
					}
				}
			}
			
		break;
		case 2:
			//define('ROOTING', 'view/calendrier.view.php');
			echo'calendrier';
			/*if(!isset($_SESSION['id_user'])){
				header('Location: index.php');
			}*/

		break;
		case 3:
			define('ROOTING', 'view/bienvenue.view.php');
			
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

				$sNom = $_POST['modification']['nom'];
				$sAdresse = $_POST['modification']['adresse'];
				$sTelephone = $_POST['modification']['telephone'];
				$sDescriptif = $_POST['modification']['descriptif'];
				$iId = $_GET['id'];
				
				$oRestaurant = new Restaurant();
				$oRestaurant->setNom($sNom);
				$oRestaurant->setAdresse($sAdresse);
				$oRestaurant->setTelephone($sTelephone);
				$oRestaurant->setDescriptif($sDescriptif);
				
				$oRestaurant->validation();
				
				if (empty($oRestaurant->aError)) {
					$oBdd = new Bdd();
					
					$aModifResto = $oBdd->updateRestaurant($iId, $sNom, $sAdresse, $sTelephone, $sDescriptif);
						
					if(!empty($aModifResto) ){
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
			define('ROOTING', 'view\modificationRestaurant.view.php');
			
			require_once 'class/bdd.class.php';
			require_once 'class/offres.class.php';
			
			if(isset($_POST['ajout']) && !empty($_POST['ajout'])){

				
				$sDescriptif = $_POST['ajout']['descriptif'];
				$iId = $_GET['id'];
				
				$oOffre = new Offre();
				$oOffre->setDescriptif($sDescriptif);
				
				$oOffre->validation();
				
				if (empty($oOffre->aError)) {
					$oBdd = new Bdd();
					
					$aModifOffre = $oBdd->ajoutOffre($iId, $sNom, $sAdresse, $sTelephone, $sDescriptif);
						
					if(!empty($aModifResto) ){
						header('Location: index.php?category=14');
					}
					else{
						echo 'Erreur modification : Merci de remplir à nouveau le formulaire';
						header('Location: index.php?category=13&&id='.$iId);
					}
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

		
		case 31:
			
			require_once 'class/bdd.class.php';
			$oBdd = new Bdd();
			$_SESSION['id_offre'] = $_GET['offre'];
			$_SESSION['ID_RESTO'] = $oBdd->getIdrestoParIdoffre($_GET['offre']);
			if($_SESSION['ID_RESTO']!=0){
				/* verifier si cet offre a déjà été reservé */
				if(!$oBdd->if_offre_reserved($_GET['offre'])){
					/* Enrigistrer IP 
				
					*/
					define('ROOTING', 'view/client.reserver.view.php');
				}
				else{
					define('ROOTING', 'view/client.offre_deja_reserve.view.php');
				}
			}
			else{
				/* Enrigistrer IP errone 
				
				
				*/
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
		break;
	}

?>