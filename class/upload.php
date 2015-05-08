<?php
include 'include/header.inc.php';

require_once 'class/bdd.class.php';
require_once 'class/restaurant.class.php';

$iId = $_GET['id'];

$oBdd = new Bdd();
$oImage = new Restaurant();


// Tests fichier bien envoyé et pas d'erreur
if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0) {

		if (!file_exists("images/".$_FILES['image']['name'])) {

			if ($_FILES['image']['size'] <= 500000) {
					$infosImage = pathinfo($_FILES['image']['name']);
					$extension_upload = $infosImage['extension'];
					$extensions_autorisees = array('gif', 'jpg', 'jpeg', 'png');
					if (in_array($extension_upload, $extensions_autorisees)) {
						move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . basename($_FILES['image']['name']));
						$sModifImage = $oBdd->updateImage($iId, $_FILES['image']['name']);
						echo "Image modifiée !"; ?>
						
						<html>
						<body>
							<p><a href="index.php?category=4">Retour au menu</a></p>
						</body>
						</html><?php
					}
			}
		}
		else {
			echo "Nom de fichier déjà existant sur notre serveur. <br/><br/>";
			echo "Veuillez renommer votre image avant de la charger à nouveau."; ?>
			<html>
				<body>
					<p><a href="index.php?category=15&&id=<?php echo $iId;?>">Modifier à nouveau</a></p><br/>
					<p><a href="index.php?category=4">Retour au menu</a></p>
				</body>
			</html><?php
		}
}

include 'include/footer.inc.php';
?>