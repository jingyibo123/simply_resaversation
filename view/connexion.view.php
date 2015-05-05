<?php
//$_SESSION['test'] = 'actif';
/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une vue, elle affiche ce que l'utilisateur voit.
    Ici se trouve le strict minimum, du code html et un peu de php
    pour les traitements des erreurs par exemple.

    Si la page necessite du javascript ou du css, il faudra le rentré 
    dans la variable $sScript.  

/ ------------------------------------------------------------------------- */


    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="";

    include 'include/header.inc.php';

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <h1>Bienvenue sur le site de réservation SimplyCE</h1>
	
	<h2>Connexion</h2>


  
    <div>
        <label for="email">Email :</label> <input type="text" name="connexion[email]" /><?php /* if(isset($oUser->aError['email'])){echo $oUser->aError['email'];} */ ?>
    </div>
    <div>
        <label for="password">Mot de Passe :</label><input type="password" name="connexion[mdp]" id="mdp" /><?php  /* if(isset($oUser->aError['mdp'])){echo $oUser->aError['mdp'];} */  ?>
    </div>

    <p><input type="submit" value="Connexion" />
</form>

<?php

include 'include/footer.inc.php';
?>