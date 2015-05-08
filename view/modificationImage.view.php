<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

require_once 'class/upload.php';

$iId = $_GET['id'];
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?category=16&&id='.$iId; ?>" enctype="multipart/form-data">
     <label for="image">Modification de l'image (Formats autorisés : jpg, png, gif / Taille maximale : 10Mo) :</label><br />
	 <input type="hidden" name=\"max_file_size" value="500000">
     <input type="file" name="image" /><br />
     <input type="submit" name="submit" value="Modifier" />
</form>


<?php
include 'include/footer.inc.php';
?>