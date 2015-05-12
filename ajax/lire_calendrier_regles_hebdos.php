<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$regles_hebdos = $oBdd->calendar_showweeklyrules(1);
	echo json_encode($regles_hebdos);
	// print_r($regles_hebdos);


?>