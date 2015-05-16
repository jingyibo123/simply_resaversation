<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
 	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$calendrier = $oBdd->get_calendar_defined(1, $_POST['start'], $_POST['end']);
	$event_export = Array();
	foreach ($calendrier as $date => $calendrier_jour){
		foreach ($calendrier_jour as $horaire => $nbtable){
			array_push($event_export, array("title"=>"$nbtable tables","start"=>$date."T".$horaire));
		}
	}
	echo json_encode($event_export);

?>