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
				 NOM : $('#OrderDetailNom').val(), 
				 PRENOM : $('#OrderDetailPrenom').val(), 
				 EMAIL_CLIENT : $('#OrderDetailEmail').val()
	$oBdd->reservation_putdata($_SESSION['id_offre'], $_POST['DATE_RESA'], $_POST['NB_TABLES']);
	echo json_encode($calendrier);

		


?>