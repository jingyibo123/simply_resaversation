<!DOCTYPE html> 

<?php
	include '../include/header.inc.php';
?>

<!-- L'utilisateur est connecté et souhaite consulter son profil.-->

<html>
	<meta charset="utf-8" />
    <head> 
		<title>Votre Profil</title> 
	</head> 
	<!-- Le header -->
	<header> Vos informations personnelles</header>
	<body>
		Nom : 
		<br>
		Prenom :
		<br>
		Sexe :
		<br>
		Email :
		<br>
		<button><a href='modificationProfil.view.php'>Modifier</a></button>
		<button><a href='supprimerProfil.view.php'>Supprimer</a></button>
		
	</body>
</html>

<?php
	include '../include/footer.inc.php';
?>