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
		<?php /*
		
		echo "Liste des offres <br/><br/>";
		if(!empty($aListeOffres)){
			foreach($aListeOffres as $k=>$v){
				echo $v['DESCRIPTIF']; 
				if ($_SESSION['droit']==1) {
					?> <a href="index.php?category=21&&id=<?php echo $v['ID_OFFRE'];?>">Modifier Offre</a>
					<a href="index.php?category=27&&id=<?php echo $v['ID_OFFRE'];?>" onclick="return confirm('Voulez-vous vraiment suprimer cette offre ?');">Supprimer Offre</a>
					<?php }
				echo '<br/>';
			}
		}
		
		if($_SESSION['droit']==1){
			?><p><a href="index.php?category=18&&id=<?php echo $_GET['id'];?>"> Ajouter une offre</a></p><?php
		}
		*/?>
		<p><a href="index.php?category=4"> Retour</a></p>
		
	</body>

	
	
</html>

<?php
include 'include/footer.inc.php';
?>