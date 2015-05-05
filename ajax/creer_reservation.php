<?php

/* ------------------------------------------------------------------------- /
						
	Ce fichier sert à diriger l'utilisateur et à traiter les informations
	dynamiques. C'est le controller, c'est lui qui appel les classes et les
	vues.

/ ------------------------------------------------------------------------- */
	include '../include/parametres.inc.php';
	require_once '../class/bdd.class.php';
	$oBdd = new Bdd();
	
	$calendrier = 
	 : $('#OrderDetailDateTime').val(), 
				  : $('#OrderDetailNbTable').val(), 
				  : $('#OrderDetailNom').val(), 
				 PRENOM : $('#OrderDetailPrenom').val(), 
				  : $('#OrderDetailEmail').val()
	$oBdd->reservation_putdata($_SESSION['id_offre'], $_POST['reservation']['EMAIL_CLIENT'], $_POST['NOM'], $_POST['reservation']['PRENOM'], $_POST['reservation']['DATE_RESA'], $_POST['reservation']['NB_TABLES'], $_POST['reservation']['NB_PERSONNE'] );
	echo json_encode($calendrier);

		


?>