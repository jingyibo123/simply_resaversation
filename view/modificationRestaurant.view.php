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

$aRestaurant = $oBdd->restaurant_getData("$iId");
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=13&&id='.$iId; ?>" method="post">

    <h1>Modification restaurant</h1>

	<?php if ($_SESSION['droit']==1) { ?>
    <div>
        <p>Nom : </p> <input type="text" name="modification[nom]" value="<?php echo ''.$aRestaurant['NOM_RESTO']; ?>" /> <?php if(isset($oRestaurant->aError['nom'])){echo $oRestaurant->aError['nom'];} ?>
    </div>
    <div>
        <p>Adresse : </p> <input type="text" name="modification[adresse]" value="<?php echo ''.$aRestaurant['ADRESSE']; ?>" /> <?php if(isset($oRestaurant->aError['adresse'])){echo $oRestaurant->aError['adresse'];} ?>
    </div>
	<?php } ?>
    <div>
        <p>Téléphone : </p> <input type="text" name="modification[telephone]" value="<?php echo ''.$aRestaurant['TELEPHONE']; ?>" /> <?php if(isset($oRestaurant->aError['telephone'])){echo $oRestaurant->aError['telephone'];} ?>
    </div>
    <div>
        <p>Descriptif : </p><textarea name="modification[descriptif]" rows="7" cols="100"><?php echo ''.$aRestaurant['DESCRIPTIF']; ?></textarea> <?php if(isset($oRestaurant->aError['descriptif'])){echo $oRestaurant->aError['descriptif'];} ?>
    </div>
	

    <p></br><input name="Modifier" value="Modifier" type="submit" /></p>
	
	<p><a href="javascript:history.back()"> Retour</a></p>
</form>


<?php
include 'include/footer.inc.php';
?>
