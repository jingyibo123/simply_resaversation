<!DOCTYPE html> 

<?php
include 'include/header.inc.php';

require_once 'class/bdd.class.php';

$oBdd = new Bdd();
$iId = $_GET['id'];
$aRestaurant = $oBdd->restaurant_getData("$iId");
?>

<form method="post" action="upload.php" enctype="multipart/form-data">
     <label for="image">Modification de l'image (Formats autorisés : jpeg) :</label><br />
     <input type="file" name="image" /><br />
     <input type="submit" name="submit" value="Modifier" />
</form>


<?php
include 'include/footer.inc.php';
?>