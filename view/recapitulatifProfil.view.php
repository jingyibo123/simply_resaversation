
<!-- L'utilisateur a rempli le formulaire et visualise les informations remplies.-->

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
	<p><a href="javascript:history.back()"> Retour</a></p>


<?php
	include 'include/footer.inc.php';
?>