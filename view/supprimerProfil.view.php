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
?>

<!-- L'utilisateur n'est pas connect?et souhaite s'enregistrer sur le site.-->


	<p> Vous êtes sur le point de supprimer ce profil. </p>
	<!-- Le menu -->
	<!--php include ("../include/menu.inc.php");-->
	<!-- Le corps de la page -->
	<br>

		<input type="button" onclick="confirmation()" value="Supprimer"
		action="<?php echo $_SERVER['PHP_SELF'].'?category=43&&id='.$_GET['id']; ?>">
		<p><a href="javascript:history.back()"> Retour</a></p>
		<script type="text/javascript">
		function confirmation()
		 {
		  if (confirm(Etes vous sûr de vouloir supprimer ce profil et toutes les informations rattachés ?")) {
		   window.location.href = "<?php echo $_SERVER['PHP_SELF'].'?category=43&&id='.$_GET['id']; ?>"
		  }
		 }
		</script>


<?php
	include 'include/footer.inc.php';
?>