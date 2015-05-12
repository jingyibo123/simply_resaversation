<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

?>

<html>
    <head>
		<meta charset="utf-8" /> 
		<title>Mes offres</title> 
	</head> 
	<body>
		<?php if($_SESSION['droit']==1){
			?><p><a href="index.php?category=18&&id=<?php echo $_GET['id'];?>"> Ajouter une offre</a></p><?php
		}
		?>
		<p><a href="index.php?category=4"> Retour au menu</a></p>
		
	</body>

	
	
</html>

<?php
include 'include/footer.inc.php';
?>