<!DOCTYPE html> 

<?php
	include 'include/header.inc.php';
	require_once 'class/bdd.class.php';

	$oBdd = new Bdd();
	$iId = $_GET['id'];
?>

<!-- L'utilisateur est connecté et souhaite consulter son profil.-->

<html>
	<meta charset="utf-8" />
    <head> 
		<title>Votre Profil</title> 
	</head> 

	<body>
	<br>
		<button><a href="index.php?category=47&&id=<?php echo $_SESSION['id_user']; ?>">Modifier mot de passe</a></button>
		<br><br>
		<p><a href="index.php?category=4"> Retour au menu</a></p>
	</body>
</html>

<?php
	include 'include/footer.inc.php';
?>