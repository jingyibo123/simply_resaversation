<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

require_once 'class/bdd.class.php';

$oBdd = new Bdd();
$iId = $_GET['id'];
$aRestaurant = $oBdd->restaurant_getData("$iId");
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=13&&id='.$iId; ?>" method="post">

    <h1>Modification restaurant</h1>

    <div>
        <p>Nom :</p><input type="text" name="modification[nom]" size="50" value="<?php echo ''.$aRestaurant['NOM']; ?>" />
    </div>
    <div>
        <p>Adresse : </p><input type="text" name="modification[adresse]" size="70" value="<?php echo ''.$aRestaurant['ADRESSE']; ?>" />
    </div>
    <div>
        <p>Téléphone : </p> <input type="text" name="modification[telephone]" value="<?php echo ''.$aRestaurant['TELEPHONE']; ?>" />
    </div>
    <div>
        <p>Descriptif : </p><textarea name="modification[descriptif]" rows="7" cols="100"><?php echo ''.$aRestaurant['DESCRIPTIF']; ?></textarea>
    </div>
	
    <div>
        <p>Image : </p><input type="file" name="modification[image]" />
    </div>

    <p></br><input name="Modifier" value="Modifier" type="submit" /></p>
</form>


<?php
include 'include/footer.inc.php';
?>
