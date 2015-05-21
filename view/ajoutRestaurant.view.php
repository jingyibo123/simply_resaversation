<?php
include 'include/header.inc.php';
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

<body>
	<p><a href="javascript:history.back()">Retour</a></p>
</body>


<?php

include 'include/footer.inc.php';
?>
