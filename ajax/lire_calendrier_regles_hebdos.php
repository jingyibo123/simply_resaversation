<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à traiter les appels AJAX 

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	$regles_hebdos = $oBdd->calendar_showweeklyrules(1);
	for($i = 0;$i < count($regles_hebdos); $i++){
		switch ($regles_hebdos[$i]['JOUR']){
		case 1:
			$regles_hebdos[$i]['JOUR'] = 'Dimanche';
		break;
		case 2:
			$regles_hebdos[$i]['JOUR'] = 'Lundi';
		break;
		case 3:
			$regles_hebdos[$i]['JOUR'] = 'Mardi';
		break;
		case 4:
			$regles_hebdos[$i]['JOUR'] = 'Mercredi';
		break;
		case 5:
			$regles_hebdos[$i]['JOUR'] = 'Jeudi';
		break;
		case 6:
			$regles_hebdos[$i]['JOUR'] = 'Vendredi';
		break;
		case 7:
			$regles_hebdos[$i]['JOUR'] = 'Samedi';
		break;
		}
	}
	echo json_encode($regles_hebdos);
	// print_r($regles_hebdos);


?>