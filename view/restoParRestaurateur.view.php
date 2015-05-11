<!DOCTYPE html> 

<?php
include 'include/header.inc.php';
$iId = $_GET['id'];
?>

<html>
    <head>
		<meta charset="utf-8" /> 
		<title>Liste Restaurants</title> 
	</head> 
	<body>
		<p><a href="index.php?category=25&&id=<?php echo $iId; ?>">Ajouter un restaurant</a></p>
		<p><a href="index.php?category=4">Retour au menu</a></p>
	</body>

</html>

<?php
include 'include/footer.inc.php';
?>