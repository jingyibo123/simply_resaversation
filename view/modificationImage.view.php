<?php
//echo $_SESSION['test'];
/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une vue, elle affiche se que l'utilisateur voit.
    Ici se trouve le strict minimum, du code html et un peu de php
    pour les traitements des erreurs par exemple.

    Si la page necessite du javascript ou du css, il faudra le rentré 
    dans la variable $sScript.  

/ ------------------------------------------------------------------------- */


    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="";
    include 'include/header.inc.php';
	include 'include/menu.inc.php';
?>

<?php


require_once 'class/upload.php';

$iId = $_GET['id'];
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?category=16&&id='.$iId; ?>" enctype="multipart/form-data">
     <label for="image">Modification de l'image (Formats autorisés : jpg, png, gif / Taille maximale : 10Mo) :</label><br /><br/>
	 <input type="hidden" name=\"max_file_size" value="500000">
     <input type="file" name="image" /><br /><br/>
     <input type="submit" name="submit" value="Modifier" />
</form>


	<p><a href="javascript:history.back()"> Retour</a></p>


<?php
include 'include/footer.inc.php';
?>