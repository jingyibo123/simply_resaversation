<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$regles_special = $oBdd->calendar_showspecialrules(1);
	
	echo json_encode($regles_special);
	// print_r($regles_special);


?>