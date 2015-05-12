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
		<script src='view/messageAjoutRestaurant.view.js'></script>
    ";
    include 'include/header.inc.php';
?>
<?php
	$_SESSION['id_nouveau_resto'] = $_GET['idresto'];
?>

<body>
	<h3>Le restaurant a bien été ajouté</br>
	<button id="opener">Cliquez moi</button></br>Veuillez cliquer ici pour définir le calendrier de votre restaurant(obligatoire)</h3>
	<p><a href="index.php?category=4">Retour au menu</a></p>
<!--  la dialogue de inscription  -->
<div id="dialog" title="Définir le calendrier de votre restaurant" style='display:none'>
    <label for="selecjour">Selectionner les jours que votre restaurant est ouvert:</label><br/>
    <label><input class="jourcheckbox" name="selecjour" id="selecjour1" type="checkbox" value="" />Lundi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour2" type="checkbox" value="" />Mardi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour3" type="checkbox" value="" />Mercredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour4" type="checkbox" value="" />Jeudi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour5" type="checkbox" value="" />Vendredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour6" type="checkbox" value="" />Samedi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour7" type="checkbox" value="" />Dimanche</label> 
    <br/><br/><br/>
    <label for="selechoraire">Selectionner les horaires de votre restaurant:</label><br/>
	<label><input type="checkbox" value="" id="selecthoraire1" name="selecthoraire" class="horairecheckbox">1:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire2" name="selecthoraire" class="horairecheckbox">2:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire3" name="selecthoraire" class="horairecheckbox">3:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire4" name="selecthoraire" class="horairecheckbox">4:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire5" name="selecthoraire" class="horairecheckbox">5:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire6" name="selecthoraire" class="horairecheckbox">6:00:00</label><br>
	<label><input type="checkbox" value="" id="selecthoraire7" name="selecthoraire" class="horairecheckbox">7:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire8" name="selecthoraire" class="horairecheckbox">8:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire9" name="selecthoraire" class="horairecheckbox">9:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire10" name="selecthoraire" class="horairecheckbox">10:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire11" name="selecthoraire" class="horairecheckbox">11:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire12" name="selecthoraire" class="horairecheckbox">12:00:00</label><br>
	<label><input type="checkbox" value="" id="selecthoraire13" name="selecthoraire" class="horairecheckbox">13:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire14" name="selecthoraire" class="horairecheckbox">14:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire15" name="selecthoraire" class="horairecheckbox">15:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire16" name="selecthoraire" class="horairecheckbox">16:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire17" name="selecthoraire" class="horairecheckbox">17:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire18" name="selecthoraire" class="horairecheckbox">18:00:00</label><br>
	<label><input type="checkbox" value="" id="selecthoraire19" name="selecthoraire" class="horairecheckbox">19:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire20" name="selecthoraire" class="horairecheckbox">20:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire21" name="selecthoraire" class="horairecheckbox">21:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire22" name="selecthoraire" class="horairecheckbox">22:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire23" name="selecthoraire" class="horairecheckbox">23:00:00</label>
	<label><input type="checkbox" value="" id="selecthoraire24" name="selecthoraire" class="horairecheckbox">24:00:00</label><br><br>
	
	
	
    
    <label for="saisirnbtable">Nombre de tables possibles pour un offre:</label>
	<input type="number" name = "nbtables" class="nbtables" id="nbtables" min="1" max="30">
    <button class="btn calendar initialise save" id="btnsavecalendar" action="" >Sauvegarder</button>
    <button class="btn calendar initialise annuler" id="btncancelcalendar" action="" >Annuler</button>

</div>
</body>


<?php
include 'include/footer.inc.php';
?>
