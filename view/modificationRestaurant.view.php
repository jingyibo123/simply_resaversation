<!DOCTYPE html> 

<?php
include 'include/header.inc.php';
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=13'; ?>" method="post">

    <h1>Modification du restaurant</h1>

    <div>
        <label for="nom">Nom : </label><input type="text" name="modification[nom]" />
    </div>
    <div>
        <label for="adresse">Adresse : </label><input type="text" name="modification[adresse]" />
    </div>
    <div>
        <label for="telephone">Téléphone : </label> <input type="text" name="modification[telephone]" />
    </div>
    <div>
        <label for="descriptif">Descriptif : </label><input type="text" name="modification[descriptif]" />
    </div>
	
    <div>
        <label for="image">Image : </label><input type="file" name="modification[image]" />
    </div>

    <p><input name="Modifier" value="Modifier" type="submit" />
</form>


<?php
include 'include/footer.inc.php';
?>
