<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à diriger l'utilisateur et à traiter les informations
	dynamiques. C'est le controller, c'est lui qui appel les classes et les
	vues.

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();

			$calendrier = $oBdd->calendar_getAvailability($_SESSION['ID_RESTO'], $_POST['start'], $_POST['end']);
			echo json_encode($calendrier);

		


?>