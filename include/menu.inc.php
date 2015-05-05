
<!DOCTYPE html>
<html>
	<nav id="menu">
		<div class="element_menu">
			<ul id="onglets">
				<?php
				
				if (!empty($_SESSION['droit'])){
				switch ($_SESSION['droit'])
				{ 
					case null:
					break;
					case "0": // Client : A créer 
					?>
						<li><a href="CompteClient.html"> Mon Compte C</a></li>
						<li><a href="ReservationsClients.html"> Ma Reservation C</a></li>
					<?php break;
					
					case "2": // Restaurateur : A créer
					?>
						<li><a href="CompteRestaurateur.html"> Mon Compte R</a></li>
						<li><a href="index.php?category=10"> Mes Restaurants R</a></li>
						<li><a href="OffresRestaurateur.html"> Mes Offres R</a></li>
						<li><a href="index.php?category=11"> Mes Reservations R</a></li>
					<?php break;
					
					case "1": // Administrateur : A créer
					?>
						<li><a href="CompteModerateur.html"> Mon Compte </a></li>
						<li><a href="OffresModerateur.html"> Offres </a></li>
						<li><a href="index.php?category=7"> Restaurateurs </a></li>
						<li><a href="index.php?category=5"> Restaurants </a></li>
						<li><a href="index.php?category=1"> Inscrire un membre</a></li>
					<?php break;
					
					default:
								echo "Le type de l'utilisateur n'est pas reconnu";
				}
				}
				?>
			</ul>
		</div>
	</nav>
</html>
