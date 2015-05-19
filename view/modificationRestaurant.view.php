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
        <p>Téléphone : </p> <input type="text" name="modification[telephone]" value="<?php echo ''.$aRestaurant['TELEPHONE']; ?>" /> <?php if(isset($oRestaurant->aError['telephone'])){echo $oRestaurant->aError['telephone'];} ?>
    </div>
    <div>
        <p>Descriptif : </p><textarea name="modification[descriptif]" rows="7" cols="100"><?php echo ''.$aRestaurant['DESCRIPTIF']; ?></textarea> <?php if(isset($oRestaurant->aError['descriptif'])){echo $oRestaurant->aError['descriptif'];} ?>
    </div>
	

    <p></br><input name="Modifier" value="Modifier" type="submit" /></p>
</form>


<?php
include 'include/footer.inc.php';
?>
