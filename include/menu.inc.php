<?php
require_once 'class/bdd.class.php';
$oBdd = new Bdd();
$aMembre = $oBdd->user_getData($_SESSION['id_user']);
$sNom = $aMembre['NOM'];
$sPrenom = $aMembre['PRENOM'];
?>

	<div id="menu">
		<nav>
			<ul>
				<?php
				
				if (!empty($_SESSION['droit'])){
				switch ($_SESSION['droit'])
				{ 
					case null:
					break;
					case "0": // Client : A créer 
					?>
						<li><a href="CompteClient.html"> Mon Compte</a></li>
						<li><a href="ReservationsClients.html"> Ma Reservation</a></li>
						<li><a href="index.php?category=100" onclick="return confirm('Voulez-vous vraiment vous deconnecter ?');">Deconnexion</a></li>
					<?php break;
					
					case "2": // Restaurateur : A créer
					?>
						
						<li><a href="index.php?category=28&&id=<?php echo $_SESSION['id_user']; ?>"> Modifier mon mot de passe </a></li>
						<li><a href="index.php?category=10"> Mes Restaurants </a></li>
						<li><a href="index.php?category=12"> Mes Offres </a></li>
						<li><a href="index.php?category=11"> Mes Reservations </a></li>
						<li><a href="index.php?category=100" onclick="return confirm('Voulez-vous vraiment vous deconnecter ?');">Deconnexion</a></li>
					<?php break;
					
					case "1": // Administrateur : A créer
					?>
						
						<li><a href="index.php?category=28&&id=<?php echo $_SESSION['id_user']; ?>"> Modifier mon mot de passe </a></li>
						<li><a href="index.php?category=7"> Restaurateurs </a></li>
						<li><a href="index.php?category=5"> Restaurants </a></li>
						<li><a href="index.php?category=30"> Notifications</a></li>
						<li><a href="index.php?category=1"> Inscrire un restaurateur</a></li>
						<li><a href="index.php?category=100" onclick="return confirm('Voulez-vous vraiment vous deconnecter ?');">Deconnexion</a></li>
					<?php break;
					
					default:
								echo "Le type de l'utilisateur n'est pas reconnu";
				}
				}
				?>
			</ul>
	</nav>
	</div></br>
	