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


require_once 'class/bdd.class.php';

$oBdd = new Bdd();

$iId = $_GET['id'];
?>

<form action="<?php echo $_SERVER['PHP_SELF'].'?category=18&&id='.$iId; ?>" method="post">

    <h1>Ajout d'une offre</h1>

    
    <div>
        <p>Descriptif : </p><textarea name="ajout[descriptif]" rows="7" cols="100"></textarea> <?php if(isset($oOffre->aError['descriptif'])){echo $oOffre->aError['descriptif'];} ?>
    </div>

    <p></br><input name="Ajouter" value="Ajouter" type="submit" /></p>
	
	
</form>
<p><a href="javascript:history.back()"> Retour </a></p>

<?php
include 'include/footer.inc.php';
?>

