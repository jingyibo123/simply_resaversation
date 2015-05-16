<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
 	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$calendrier = $oBdd->delete_calendar_weeklyrules(1, $_POST['ruleid']);
	echo '{"success":true}';
?>