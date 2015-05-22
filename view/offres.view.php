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
		<?php /*
		
		echo "Liste des offres <br/><br/>";
		if(!empty($aListeOffres)){
			foreach($aListeOffres as $k=>$v){
				echo $v['DESCRIPTIF']; 
				if ($_SESSION['droit']==1) {
					?> <a href="index.php?category=21&&id=<?php echo $v['ID_OFFRE'];?>">Modifier Offre</a>
					<a href="index.php?category=27&&id=<?php echo $v['ID_OFFRE'];?>" onclick="return confirm('Voulez-vous vraiment suprimer cette offre ?');">Supprimer Offre</a>
					<?php }
				echo '<br/>';
			}
		}*/
		
		if($_SESSION['droit']==1){
			?><p><a href="index.php?category=18&&id=<?php echo $_GET['id'];?>"> Ajouter une offre</a></p><?php
		}
		require_once 'class/bdd.class.php';
		$oBdd = new Bdd();
		if(isset($_GET['category']) && $_GET['category'] = 12){
			$iId = $_SESSION['id_user'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		}
		elseif(isset($_GET['category']) && $_GET['category'] = 17){
			$aListeOffres = $oBdd->getOffresParAdministrateur();
		}
		elseif(isset($_GET['category']) && $_GET['category'] = 19){
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		}
		elseif(isset($_GET['category']) && $_GET['category'] = 20){
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurant($iId);
		}
		elseif(isset($_GET['category']) && $_GET['category'] = 23){
			$iId = $_GET['id'];
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
		}
		$oBdd = new Bdd();
		$iId = $_SESSION['id_user'];
		if($_SESSION['droit']==1){
			$aListeOffres = $oBdd->getOffresParAdministrateur();
		}
		elseif($_SESSION['droit']==2){
			$aListeOffres = $oBdd->getOffresParRestaurateur($iId);
			}
			
		?>

		<p><a href="javascript:history.back()"> Retour</a></p>

<?php
include 'include/footer.inc.php';
?>