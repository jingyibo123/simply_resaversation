<!DOCTYPE html> 

<?php
	include 'include/header.inc.php';
	require_once 'class/bdd.class.php';

	$oBdd = new Bdd();
	$iId = $_GET['id'];
?>

<!-- L'utilisateur n'est pas connecté et souhaite s'enregistrer sur le site.-->

<html>
	<meta charset="utf-8" />
    <head> 
		<title>Supprimer le profil suivant</title> 
	</head> 
	<header> Vous êtes sur le point de supprimer ce profil. </header>
	<!-- Le menu -->
	<!--php include ("../include/menu.inc.php");-->
	<!-- Le corps de la page -->
	<br>
	<body>
		<input type="button" onclick="confirmation()" value="Supprimer"
		action="<?php echo $_SERVER['PHP_SELF'].'?category=43&&id='.$_GET['id']; ?>">
		<p><a href="index.php?category=4"> Retour au menu</a></p>
		<script type="text/javascript">
		function confirmation()
		 {
		  if (confirm("Êtes vous sûrs de vouloir supprimer ce profil et toutes les informations rattachées ?")) {
		   window.location.href = "<?php echo $_SERVER['PHP_SELF'].'?category=43&&id='.$_GET['id']; ?>"
		  }
		 }
		</script>
	</body>
</html>

<?php
	include 'include/footer.inc.php';
?>