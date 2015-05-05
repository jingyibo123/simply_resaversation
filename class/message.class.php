<?php

require_once "class/Mail.php";
require_once "class/bdd.class.php";

class Message {

	public function envoyer($sEmailDest, $sObjet, $sMessage) {
	
		$from = '<essai.simplyce@gmail.com>'; // Adresse Mail à modifier
		$to = $sEmailDest; 

		$headers = array(
			'From' => $from,
			'To' => $to,
			'Subject' => $sObject
		);

		$mail = Mail::factory('smtp', array( // PARAMETRES A MODIFIER
			'host' => 'smtp.gmail.com', 
			'port' => '465',
			'auth' => true,
			'username' => 'username', 
			'password' => 'password'  
		));

		if (PEAR::isError($mail)) {
			echo $mail->getMessage() . "\n" . $mail->getUserInfo() . "\n";
			die();
		} else {
			echo('<p>Votre message a bien été envoyé !</p>');
		}

		$mail->send($to, $headers, $sMessage);

	}
	
	
	public function reservation($sEmailRest) {
		
		$bdd = new Bdd();
		$iIdResa = ; // A récupérer
		$iOffre = $bdd->reservation_getData($iIdResa)[1];
		$dDate = $bdd->reservation_getData($iIdResa)[5];
		$sNom = $bdd->reservation_getData($iIdResa)[3];
		$sPrenom = $bdd->reservation_getData($iIdResa)[4];
		$iNbTable = $bdd->reservation_getData($iIdResa)[6];
		$iNbPrs = $bdd->reservation_getData($iIdResa)[7];

		$sObjet = "[SimplyCE] Réservation";
		$sMessage = "
		<html>
		<head>
			<title>Réservation au $dDate</title>
		</head>
		<body>
			<p>Bonjour,</p>
			</br>
			<p>M/Mme $sPrenom $sNom a réservé  $iNbTable le $dDate pour $iNbPrs. </p>
			<br>
			<p>Pour plus d\'information, rendez-vous sur votre compte en ligne SimplyCE.</p>
			<br>
			<br>
			<p>Cordialement,</p>
			<br>
			<p>L\'équipe SimplyCE.</p>
		</body>
		</html>";
		
		$this->envoyer($sEmailRest, $sObjet, $sMessage);
		
	}
	
	
	public function confirmationClient($sEmailClient) {
	
		$bdd = new Bdd();
		$iIdResa = ; // A récupérer
		$iOffre = $bdd->reservation_getData($iIdResa)[1];
		$dDate = $bdd->reservation_getData($iIdResa)[5];
		$sNom = $bdd->reservation_getData($iIdResa)[3];
		$sPrenom = $bdd->reservation_getData($iIdResa)[4];
		$iNbPrs = $bdd->reservation_getData($iIdResa)[7];

		$sObjet = "[SimplyCE] Confirmation de réservation";
		$sMessage = "
		<html>
		<head>
			<title>Réservation du $dDate</title>
		</head>
		<body>
			<p>Bonjour,</p>
			</br>
			<p>M/Mme $sPrenom $sNom,</p>
			<br>
			<p>Nous vous confirmons votre réservation du $dDate pour $iNbPrs avec l'offre $iOffre.</p>
			<br>
			<br>
			<p>Cordialement,</p>
			<br>
			<p>L\'équipe SimplyCE.</p>
		</body>
		</html>";
		
		$this->envoyer($sEmailClient, $sObjet, $sMessage);
		
	}
	
	
	public function annulationClient($sEmailRest) {
	
		$bdd = new Bdd();
		$iIdResa = ; // A récupérer
		$sEmailClient = $bdd->reservation_getData($iIdResa)[2];
		$iOffre = $bdd->reservation_getData($iIdResa)[1];
		$dDate = $bdd->reservation_getData($iIdResa)[5];
		$sNom = $bdd->reservation_getData($iIdResa)[3];
		$sPrenom = $bdd->reservation_getData($iIdResa)[4];
		$iNbPrs = $bdd->reservation_getData($iIdResa)[7];
		$sMotif = $bdd->annulation_getData($iIdResa)[1];

		$sObjet = "[SimplyCE] Annulation de réservation";
		$sMessage = "
		<html>
		<head>
			<title>Annulation de la réservation du $dDate</title>
		</head>
		<body>
			<p>Bonjour,</p>
			</br>
			<p>M/Mme $sPrenom $sNom a annulé sa réservation du $dDate pour $iNbPrs avec l'offre $iOffre.</p>
			<br>
			<p>Motif de l'annulation : $sMotif.</p>
			<br>
			<br>
			<p>Cordialement,</p>
			<br>
			<p>L\'équipe SimplyCE.</p>
		</body>
		</html>";
		
		$this->envoyer($sEmailClient, $sObjet, $sMessage);
		
	}
	
	
	public function annulationRest($sEmailClient) {
	
		$bdd = new Bdd();
		$iIdResa = ; // A récupérer
		$iOffre = $bdd->reservation_getData($iIdResa)[1];
		$dDate = $bdd->reservation_getData($iIdResa)[5];
		$sNom = $bdd->reservation_getData($iIdResa)[3];
		$sPrenom = $bdd->reservation_getData($iIdResa)[4];
		$iNbPrs = $bdd->reservation_getData($iIdResa)[7];
		$sMotif = $bdd->annulation_getData($iIdResa)[1];

		$sObjet = "[SimplyCE] Annulation de réservation";
		$sMessage = "
		<html>
		<head>
			<title>Annulation de la réservation du $dDate</title>
		</head>
		<body>
			<p>Bonjour M/Mme $sPrenom $sNom,</p>
			</br>
			<p>Nous sommes dans le regret de vous annoncer que votre réservation du $dDate pour $iNbPrs avec l'offre $iOffre a dû être annulée.</p>
			<br>
			<p>Motif de l'annulation : $sMotif.</p>
			<br>
			<p>Votre offre a été réactivée, n'hésitez pas à retourner sur notre site pour refaire une réservation.</p> 
			<br>
			<br>
			<p>Cordialement,</p>
			<br>
			<p>L\'équipe SimplyCE.</p>
		</body>
		</html>";
		
		$this->envoyer($sEmailClient, $sObjet, $sMessage);
		
	}


}


?>