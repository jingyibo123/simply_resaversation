<?php
//echo $_SESSION['test'];
/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une vue, elle affiche se que l'utilisateur voit.
    Ici se trouve le strict minimum, du code html et un peu de php
    pour les traitements des erreurs par exemple.

    Si la page necessite du javascript ou du css, il faudra le rentré 
    dans la variable $sScript.  

/ ------------------------------------------------------------------------- */


    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="";
    include 'include/header.inc.php';
	include 'include/menu.inc.php';
?>

<div>
	<?php
	if (!empty($_SESSION['droit'])){
		switch ($_SESSION['droit'])
		{ 
		case null:
		break;
		case "0": // Client : A créer 
		?>
			<?php break;
		case "2": // Restaurateur : A créer
		?>
			</br></br><h2>Compte restaurateur : Bienvenue <?php echo $sPrenom.' '.$sNom;?> ! </h2>
			<?php break;
		case "1": // Administrateur : A créer
		?>
			</br></br><h2>Compte administrateur : Bienvenue <?php echo $sPrenom.' '.$sNom;?> ! </h2>
			<?php break;
		default:
			echo "Le type de l'utilisateur n'est pas reconnu";
		}
	}?>
</div>


<?php

include 'include/footer.inc.php';
?>