<!DOCTYPE html> 

<?php
	include '../include/header.inc.php';
?>

<!-- L'utilisateur n'est pas connect� et souhaite s'enregistrer sur le site.-->

<html>
	<meta charset="utf-8" />
    <head> 
		<title>Supprimer le profil suivant</title> 
	</head> 
	<header> Vous �tes sur le point de supprimer le profil suivant : </header>
	<!-- Le menu -->
	<!--php include ("../include/menu.inc.php");-->
	<!-- Le corps de la page -->
	<br>
	<body>
		Nom : 
		<br>
		Prenom :
		<br>
		Sexe :
		<br>
		Email :
		<br>
		<input type="button" onclick="confirmation()" value="Supprimer">
		<button><a href="">Retour</a></button>
		<script type="text/javascript">
		function confirmation()
		 {
		  if (confirm("�tes vous s�rs de vouloir supprimer ce profil et toutes les informations rattach�es ?")) {
		   window.location.href = "bienvenue.view.php"
		  }
		 }
		</script>
	</body>
</html>

<?php
	include '../include/footer.inc.php';
?>