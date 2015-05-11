<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$oBdd->calendrier_initialise(2, $_POST['jours'], $_POST['horaires'],$_POST['nbtables']);



?>