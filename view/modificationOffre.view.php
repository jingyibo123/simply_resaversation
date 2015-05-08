<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

require_once 'class/bdd.class.php';

$oBdd = new Bdd();
$iId = $_GET['id'];
$aOffre = $oBdd->offre_getData("$iId");
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=21&&id='.$iId; ?>" method="post">

    <h1>Modification de l'offre</h1>

    <div>
        <p>Descriptif : </p><textarea name="modification[descriptif]" rows="7" cols="100"><?php echo ''.$aOffre['DESCRIPTIF']; ?></textarea> <?php if(isset($oOffre->aError['descriptif'])){echo $oOffre->aError['descriptif'];} ?>
    </div>

    <p></br><input name="Modifier" value="Modifier" type="submit" /></p>
</form>


<?php
include 'include/footer.inc.php';
?>
