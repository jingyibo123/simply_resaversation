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
		<script src='restaurateur_initialisation_calendrier.js'></script>
    ";
    include 'include/header.inc.php';
?>

<link href='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.css' rel='stylesheet' />

<script src='http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/lang/fr.js'></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

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
<button id="opener">open the dialog</button>
<div id="dialog" title="Dialog Title">
    <label for="selecjour">Selectionner les jours que votre restaurant est ouvert:</label><br/>
    <label><input class="jourcheckbox" name="selecjour" id="selecjour1" type="checkbox" value="" />Lundi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour2" type="checkbox" value="" />Mardi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour3" type="checkbox" value="" />Mercredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour4" type="checkbox" value="" />Jeudi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour5" type="checkbox" value="" />Vendredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour6" type="checkbox" value="" />Samedi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour7" type="checkbox" value="" />Dimanche</label> 
    <br/><br/>
    <label for="selechoraire">Selectionner les horaires de votre restaurant:</label><br/><?php
    for($i = 1;$i < 25;$i++){
		echo '<label><input class="horairecheckbox" name="selecthoraire" id="selecthoraire'.$i.'" type="checkbox" value="" />'.$i.':00:00</label>';
	}?><br/>
	
    
    <label for="saisirnbtable">Nombre de tables possibles pour un offre:</label>
	<input type="number" name = "nbtables" id="nbtables" min="1" max="30">
    <button class="btn calendar initialise save" id="btnsavecalendar" action="" >Sauvegarder</button>
    <button class="btn calendar initialise annuler"  action="" >Annuler</button>

</div>

    
<?php
    include 'include/footer.inc.php';
?>