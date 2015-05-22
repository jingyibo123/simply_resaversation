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
