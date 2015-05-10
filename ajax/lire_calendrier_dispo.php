<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
 	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$calendrier = $oBdd->calendar_getAvailability($_SESSION['ID_RESTO'], $_POST['start'], $_POST['end']);
	echo json_encode($calendrier);


?>