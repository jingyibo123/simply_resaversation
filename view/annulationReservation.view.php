<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

$iId = $_GET['id'];
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=44&&id='.$iId; ?>" method="post">

    <h1>Annulation de la reservation</h1>

    <div>
        <p>Motif : </p><textarea name="annulation[motif]" rows="7" cols="100"></textarea> <?php if(isset($oAnnulation->aError['motif'])){echo $oAnnulation->aError['motif'];} ?>
    </div>
	<p>Etes-vous sur de vouloir annuler cette reservation ?</p>
    <p></br><input name="Annuler" value="Oui, j'annule" type="submit" /></p>
	<p><a href="javascript:history.back()">Non : Retour</a></p>
</form>


<?php
include 'include/footer.inc.php';
?>
