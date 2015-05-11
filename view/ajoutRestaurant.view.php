<?php
include 'include/header.inc.php';
require_once 'class/bdd.class.php';
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=1'; ?>" method="post">

    <h1>Ajouter un restaurant</h1>
	
    <div>
        <label for="nom">Nom :</label><input type="text" name="ajoutResto[nom]" /><?php if(isset($oRestaurant->aError['nom'])){echo $oRestaurant->aError['nom'];} ?>
    </div>
    <div>
        <label for="adresse">Adresse :</label><input type="text" name="ajoutResto[adresse]" /><?php if(isset($oRestaurant->aError['adresse'])){echo $oRestaurant->aError['adresse'];} ?>
    </div>
    <div>
        <label for="telephone">Téléphone :</label> <input type="text" name="ajoutResto[telephone]" /><?php if(isset($oRestaurant->aError['telephone'])){echo $oRestaurant->aError['telephone'];} ?>
    </div>
    <div>
        <label for="descriptif">Descriptif :</label><input type="text" name="ajoutResto[descriptif]" /><?php if(isset($oRestaurant->aError['descritif'])){echo $oRestaurant->aError['descriptif'];} ?>
    </div>
    <div>
        <label for="type">Actif :</label>
        <select name="ajoutResto[actif]">
            <option value='1'>Oui</option>
            <option value='0'>Non</option>
        </select>
    </div>

    <p>Tous les champs sont obligatoires</p>

    <p><input type="submit" value="Valider" />
</form>

<body>
	<p><a href="index.php?category=4">Retour au menu</a></p>
</body>


<?php

include 'include/footer.inc.php';
?>
