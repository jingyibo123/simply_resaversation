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
	$oBdd = new Bdd();
	$aListeRestaurants = $oBdd->getRestaurants();
?>

		<p><a href="javascript:history.back()"> Retour</a></p>


<?php
include 'include/footer.inc.php';
?>