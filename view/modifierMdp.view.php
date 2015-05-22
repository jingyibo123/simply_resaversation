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


 
		<!-- Création Compte -->
	<!-- Le menu -->
	<!--php include ("../include/menu.inc.php");-->
	<!-- Le corps de la page -->

	<form method="post" onSubmit="return verifyInfo(this)"
	action="<?php echo $_SERVER['PHP_SELF'].'?category=48&&id='.$iId; ?>">
	<h2> Modification Mot de Passe </h2>	
		<script type="text/javascript">
		function verifyInfo(f)
		 {
		  var passed=false
		  var element1 = f.mdp1;
		  var element2 = f.mdp2;
		   if (element1.value=='')
		   {
			alert("ERREUR : Vous n'avez pas renseigné votre mot de passe.")
			element1.focus()
		   }
		   else if (element2.value=='')
		   {
			alert("ERREUR : Vous n'avez pas confirmé votre mot de passe.")
			element2.focus()
		   }
		   else if (element1.value!=element2.value)
		   {
			alert("ERREUR : Les deux mots de passe ne sont pas identiques.")
			element2.select()
		   }
		   else
		   passed=true
		   return passed&&window.confirm("Etes vous sûr de vouloir modifier votre mot de passe ?");
		   }
		</script>
		Entrez votre nouveau mot de passe : <input type="password" name="mdp1">
		<br>
		Tapez le de nouveau :<input type="password" name="mdp2">
		<br></br>
		<input type="submit" value="Confirmer"/>
	</form>
	<br></br>
	<p><a href="javascript:history.back()"> Retour</a></p>


<?php
	include 'include/footer.inc.php';
?>