<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$return = $oBdd->calendrier_initialise($_SESSION['id_nouveau_resto'], $_POST['jours'], $_POST['horaires'],$_POST['nbtables']);
	if($return[1]!=''){
		print_r($return);
	}
	else{
		echo '{"success":true}';
	}
?>