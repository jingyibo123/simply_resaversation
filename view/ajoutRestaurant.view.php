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

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=25&&id='.$iId; ?>" method="post">

    <h1>Ajouter un restaurant</h1>
	
    <div>
        <label for="nom">Nom :</label><input type="text" name="ajoutResto[nom]" size="50" /><?php if(isset($oRestaurant->aError['nom'])){echo $oRestaurant->aError['nom'];} ?>
    </div>
    <div>
        <label for="adresse">Adresse :</label><input type="text" name="ajoutResto[adresse]" size="70" /><?php if(isset($oRestaurant->aError['adresse'])){echo $oRestaurant->aError['adresse'];} ?>
    </div>
    <div>
        <label for="telephone">Téléphone :</label> <input type="text" name="ajoutResto[telephone]" /><?php if(isset($oRestaurant->aError['telephone'])){echo $oRestaurant->aError['telephone'];} ?>
    </div>
    <div>
		<p>Descriptif : </p><textarea name="ajoutResto[descriptif]" rows="7" cols="100"></textarea> <?php if(isset($oRestaurant->aError['descritif'])){echo $oRestaurant->aError['descriptif'];} ?>
    </div>

    <p>Tous les champs sont obligatoires</p>

    <p><input type="submit" value="Valider" />
</form>


	<p><a href="javascript:history.back()">Retour</a></p>



<?php

include 'include/footer.inc.php';
?>
