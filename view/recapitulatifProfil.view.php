<!DOCTYPE html> 

<?php
	include 'include/header.inc.php';
?>

<!-- L'utilisateur a rempli le formulaire et visualise les informations remplies.-->

<html>
    <head>
		<meta charset="utf-8" /> 
		<title>Récapitulatif Inscription</title> 
	</head> 
	<!-- Le menu -->
	<!--php include ("Menu.php"); -->
	<!-- Le corps de la page -->
	<body>
	<?php	
	if (isset($_POST['sexe']) AND isset($_POST['nom']) AND isset($_POST['prenom']))
	{
	$_SESSION['prenom'] = htmlspecialchars($_POST['prenom']);
	$_SESSION['nom'] = htmlspecialchars($_POST['nom']);
	$_SESSION['sexe'] = htmlspecialchars($_POST['sexe']);
	$_SESSION['debutAdresse'] = htmlspecialchars($_POST['debutAdresse']);
	$_SESSION['domaineAdresse'] = htmlspecialchars($_POST['domaineAdresse']);
	$_SESSION['localAdresse'] = htmlspecialchars($_POST['localAdresse']);
	?>
	<h1>Voici le récapitulatif de l'inscription :</h1>
	<?php $sNom = strtoupper($_POST['nom']); ?>
	<?php switch ($_POST['sexe'])
		{
			case "Femme":
				echo 'Madame ';
			break;
			case "Homme":
				echo 'Monsieur ';
			break;
			default:
				echo 'M. ';
			break;
		}
		echo htmlspecialchars($sNom) . ' ' . htmlspecialchars($_POST['prenom']);
	?>
	<div>
		<?php echo 'Votre adresse e-mail : ' . $_SESSION['debutAdresse'] . '@' . $_SESSION['domaineAdresse'] . '.' . $_SESSION['localAdresse'];	
	}
	?>
	<br></br>
	<p><a href="index.php?category=4"> Retour au menu</a></p>
</body>
</html>

<?php
	include 'include/footer.inc.php';
?>