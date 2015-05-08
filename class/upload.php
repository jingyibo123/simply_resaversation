<?php
include 'include/header.inc.php';

require_once 'class/bdd.class.php';
require_once 'class/restaurant.class.php';

$iId = $_GET['id'];

$oBdd = new Bdd();
$oImage = new Restaurant();


// Tests fichier bien envoyé et pas d'erreur
if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0) {

        if ($_FILES['image']['size'] <= 500000) {
                $infosImage = pathinfo($_FILES['image']['name']);
                $extension_upload = $infosImage['extension'];
                $extensions_autorisees = array('gif', 'jpg', 'png');
                if (in_array($extension_upload, $extensions_autorisees)) {
					move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . basename($_FILES['image']['name']));
//					$image2 = $oImage->redimensionner(400, 400, '', '', 'images', basename($_FILES['image']['name']))
					$sModifImage = $oBdd->updateImage($iId, $_FILES['image']['name']);
					echo "Image modifiée !";
					
/*					if ($extension_upload == $extensions_autorisees[0]){
						// Image GIF
						$image1 = imagecreatefromgif($_FILES['image']['name']);
						$image2 = imagecreate(60,60);
						move_uploaded_file($image2, 'images/' . basename($_FILES['image']['name']));
						$sModifImage = $oBdd->updateImage($iId, $_FILES['image']['name']);
						echo "Image modifiée !";
						}elseif ($extension_upload == $extensions_autorisees[1]){
							// Image JPG
							$image1 = imagecreatefromjpeg($_FILES['image']['name']);
							$image2 = imagecreate(60,60);
							move_uploaded_file($image2, 'images/' . basename($_FILES['image']['name']));
							$sModifImage = $oBdd->updateImage($iId, $_FILES['image']['name']);
							echo "Image modifiée !";
						}elseif ($extension_upload == $extensions_autorisees[2]){
							// Image png
							$image1 = imagecreatefrompng($_FILES['image']['name']);
							$image2 = imagecreate(60,60);
							move_uploaded_file($image2, 'images/' . basename($_FILES['image']['name']));
							$sModifImage = $oBdd->updateImage($iId, $_FILES['image']['name']);
							echo "Image modifiée !";
						}else{
							echo'Format non accepté';
						}**/ ?>
						
					<html>
					<body>
						<p><a href="index.php?category=4">Retour au menu</a></p>
					</body>
					</html><?php
                }
        }
}

include 'include/footer.inc.php';
?>