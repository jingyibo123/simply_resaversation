<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$oBdd->calendrier_initialise(2, array(1,2,3), array('12:00:00','15:00:00'),20);



?>