<?php
    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="
        <link href='//fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.css' rel='stylesheet' />
		<link href='//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css' rel='stylesheet' />
        <script src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
        <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='//fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.js'></script>
        <script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/lang/fr.js'></script>
		<script src='//code.jquery.com/ui/1.11.4/jquery-ui.js'></script>
		<script src='view/client.reserver.view.js'></script>
    ";
    include 'include/header.inc.php';
?>



<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		float: left;
		max-width: 500px;
		margin: 0 auto;
	}

</style>

<!--  la dialogue de inscription  -->
<div id='DialogResa'  class='dialog' title='Finir votre réservation' style='display:none'>
	<div id='OrderDetailDisplay' >Veuillez compléter votre réservation </div>
	<form action="<?php echo $_SERVER['PHP_SELF'].'?category=33'; ?>" method="post">
	<table id='HoraireList' ><tbody>
	<tr>
		<td><label for='OrderDetailDateTime'>Date</label></td>
		<td><input name="reservation[DATE_RESA]" type='text' id='OrderDetailDateTime' /></td></tr>
	<tr>
		<td><label for='OrderDetailNbPrs'>Nombre de Personnes</label></td>
		<td><input name="reservation[NB_PERSONNE]" type='text' id='OrderDetailNbPrs' /></td></tr>
	<tr>
		<td><label for='OrderDetailNom'>Nom</label></td>
		<td><input name="reservation[NOM]" type='text' id='OrderDetailNom' /></td></tr>
	<tr>
		<td><label for='OrderDetailPrenom'>Prénom</label>
		<td><input name="reservation[PRENOM]" type='text' id='OrderDetailPrenom' /></td></tr>
	<tr>
		<td><label for='OrderDetailEmail'>Adresse mail</label>
		<td><input name="reservation[EMAIL_CLIENT]" type='text' id='OrderDetailEmail' /></td></tr>
	<tr>
		<td><input type="submit" value="Valider votre réservation" /></td></tr>
		
	</tbody></table></form>
	<!-- <button id='VldBtn'class='btn'  action='' >Valider la réservation</button> -->
</div>

<div ><p>Sélectionner votre date de réservation</p></div>
<div id='calendar'></div>

<div id='OrderDetailInput' >
	<div id='HoraireListDiv' style='display:none'>
		<table id='HoraireList' >
			<thead>
				<tr>
					<td>Sélectionner l'heure de votre réservation</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	</div>
	<button id='CtnBtn' class='btn' style='display:none'>Poursuivre la réservation</button>
</div>
    
<?php
    include 'include/footer.inc.php';
?>