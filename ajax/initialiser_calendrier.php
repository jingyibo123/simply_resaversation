<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$oBdd->calendrier_initialise($_SESSION['id_nouveau_resto'], $_POST['jours'], $_POST['horaires'],$_POST['nbtables']);



?>