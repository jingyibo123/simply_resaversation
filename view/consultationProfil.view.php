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

<?php
	require_once 'class/bdd.class.php';



			
	$oBdd = new Bdd();
	$iId = $_GET['id'];
	$aDetails = $oBdd->user_getDetails($iId);
?>

<!-- L'utilisateur est connecté et souhaite consulter son profil.-->


	<br>
		<button><a href="index.php?category=47&&id=<?php echo $_SESSION['id_user']; ?>">Modifier mon mot de passe</a></button>
		<br><br>
		<p><a href="javascript:history.back()"> Retour</a></p>


<?php
	include 'include/footer.inc.php';
?>