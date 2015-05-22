
<!-- L'utilisateur n'est pas connecté et souhaite s'enregistrer sur le site.-->
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
	<p> Quel champ souhaitez-vous modifier ? </p>
	<!-- Le menu -->
	<!--php include ("../include/menu.inc.php");-->
	<!-- Le corps de la page -->


	<form method="post" action="recapitulatifProfil.view.php" onSubmit="return verifyInfo(this.nom, this.prenom, this.debutAdresse, this.domaineAdresse, this.localAdresse, this.mdp1, this.mdp2)"> 
		Nom :
		<input type="text" name="nom" value=""/>
		<br>
		Prénom :
		<input type="text" name="prenom" value=""/>
		<br>
		Sexe :
		<select name="sexe">
		<option value="Femme">Femme</option>
		<option value="Homme">Homme</option>
		<option value="Autre">Autre</option>
		</select>
		<br>
		Adresse e-mail : 
		<input type="text" name="debutAdresse" value=""/>
		@<input type="text" name="domaineAdresse" value="" size="5"/> 
		.<input type="text" name="localAdresse" value="" size="5"/>
		<br>
	
		<script type="text/javascript">
		function verifyInfo(nom, prenom, debut, domaine, local, element1, element2)
		 {
		  var passed=false
		   if (nom.value=='')
		   {
		    alert("ERREUR : Vous n'avez pas renseigné votre nom.")
		   }
		   else if (prenom.value=='')
		   {
		    alert("ERREUR : Vous n'avez pas renseigné votre prénom.")
		   }
		   else if (debut.value=='' || domaine.value=='' || local.value=='')
		   {
		    alert("ERREUR : Vous n'avez pas complétement renseigné votre adresse email.")
		   }
		   else if (element1.value=='')
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
			alert("ERREUR : Les deux mots de passe ne condordent pas.")
			element2.select()
		   }
		   else
		   passed=true
		   return passed&&window.confirm("Les informations suivantes sont-elles correctes ? \n Nom : " +nom.value+ "\n Prénom : " +prenom.value+ "\n Adresse e-mail : " +debut.value+ "@" +domaine.value+ "." +local.value+ "")
		  }
		</script>
		Entrez votre mot de passe : <input type="password" name="mdp1">
		<br>
		Confirmez le mot de passe :<input type="password" name="mdp2">
		<br>
		<input type="submit" value="Confirmer"/>
	</form>


<?php
	include '../include/footer.inc.php';
?>