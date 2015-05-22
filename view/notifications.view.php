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
	require_once 'class/bdd.class.php';
			$dDateCurrent = date('Y-m-d H:i:s');
			$oBdd = new Bdd();
			echo 'ANNULATIONS RESERVATIONS CLIENTS :<br/><br/>';
			$aListeNotifsResa = $oBdd->notifAnnulationResa($dDateCurrent);
			echo '<br/><br/>MODIFICATIONS PROFILS RESTAURANTS :<br/><br/>';
			$aListeNotifsResto = $oBdd->notifUpdateRestaurant($dDateCurrent);
?>
		<p><a href="javascript:history.back()"> Retour</a></p>


<?php
include 'include/footer.inc.php';
?>