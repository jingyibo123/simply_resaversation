<?php
	$sScript='
	<script type="text/javascript">
		function verifyInfo(f)
		 {
		  var passed=false
		  var nom = f.nom;
		  var prenom = f.prenom;
		  var debut = f.debutAdresse;
		  var domaine = f.domaineAdresse;
		  var local = f.localAdresse;
		  var element1 = f.mdp1;
		  var element2 = f.mdp2;
		   if (nom.value==\'\')
		   {
		    alert("ERREUR : Vous n\'avez pas renseigné votre nom.")
		   }
		   else if (prenom.value==\'\')
		   {
		    alert("ERREUR : Vous n\'avez pas renseigné votre prénom.")
		   }
		   else if (debut.value==\'\' || domaine.value==\'\' || local.value==\'\')
		   {
		    alert("ERREUR : Vous n\'avez pas complétement renseigné votre adresse email.")
		   }
		   else if (element1.value==\'\')
		   {
			alert("ERREUR : Vous n\'avez pas renseigné votre mot de passe.")
			element1.focus()
		   }
		   else if (element2.value==\'\')
		   {
			alert("ERREUR : Vous n\'avez pas confirmé votre mot de passe.")
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
	';

	include 'include/header.inc.php';
	
	/*require_once 'class/bdd.class.php';

	$oBdd = new Bdd();*/
?>

<!-- L'utilisateur n'est pas connecté et souhaite s'enregistrer sur le site.-->

	<title> Formulaire de création </title>
	<form method="post" onSubmit="return verifyInfo(this)"
	action="<?php echo $_SERVER['PHP_SELF'].'?category=29'; ?>">
	<h2> Inscription </h2>
		Type Profil :
		<select name="type">
		<option value="Restaurateur">Restaurateur</option>
		<option value="Administrateur">Administrateur</option>
		</select>
		<br>
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
		@ <input type="text" name="domaineAdresse" value="" size="5"/> 
		. <input type="text" name="localAdresse" value="" size="5"/>
		<br>
	
		
		Entrez votre mot de passe : <input type="password" name="mdp1">
		<br>
		Confirmez le mot de passe :<input type="password" name="mdp2">
		<br></br>
		<input type="submit" value="Confirmer"/>
	</form>
	<br></br>
	<p><a href="index.php?category=4"> Retour au menu</a></p>

<?php
	include 'include/footer.inc.php';
?>