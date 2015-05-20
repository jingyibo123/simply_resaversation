<?php
    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="
        <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
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
	</br>Veuillez cliquer ici pour définir le calendrier de votre restaurant(obligatoire)</h3>
	

    <label for="selecjour">Selectionner les jours que votre restaurant est ouvert:</label><br/>
    <label><input class="jourcheckbox" name="selecjour" id="selecjour1" type="checkbox" value="" />Lundi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour2" type="checkbox" value="" />Mardi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour3" type="checkbox" value="" />Mercredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour4" type="checkbox" value="" />Jeudi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour5" type="checkbox" value="" />Vendredi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour6" type="checkbox" value="" />Samedi</label> 
    <label><input class="jourcheckbox" name="selecjour" id="selecjour7" type="checkbox" value="" />Dimanche</label> 
    <br/><br/><br/>
    <label for="selechoraire">Selectionner les tranches horaires de votre restaurant:</label><br/>
	<!-- 11--17  1730--24 -->
	<p>Midi</p>
	<label><input type="checkbox" value="11:00:00" name="selecthoraire" class="horairecheckbox">11h00</label>
	<label><input type="checkbox" value="11:30:00" name="selecthoraire" class="horairecheckbox">11h30</label>
	<label><input type="checkbox" value="12:00:00" name="selecthoraire" class="horairecheckbox">12h00</label>
	<label><input type="checkbox" value="12:30:00" name="selecthoraire" class="horairecheckbox">12h30</label>
	<label><input type="checkbox" value="13:00:00" name="selecthoraire" class="horairecheckbox">13h00</label><br>
	<label><input type="checkbox" value="13:30:00" name="selecthoraire" class="horairecheckbox">13h30</label>
	<label><input type="checkbox" value="14:00:00" name="selecthoraire" class="horairecheckbox">14h00</label>
	<label><input type="checkbox" value="14:30:00" name="selecthoraire" class="horairecheckbox">14h30</label>
	<label><input type="checkbox" value="15:00:00" name="selecthoraire" class="horairecheckbox">15h00</label>
	<label><input type="checkbox" value="15:30:00" name="selecthoraire" class="horairecheckbox">15h30</label><br>
	<label><input type="checkbox" value="16:00:00" name="selecthoraire" class="horairecheckbox">16h00</label>
	<label><input type="checkbox" value="16:30:00" name="selecthoraire" class="horairecheckbox">16h30</label>
	<label><input type="checkbox" value="17:00:00" name="selecthoraire" class="horairecheckbox">17h00</label>
	<p>Après midi</p><br>
	<label><input type="checkbox" value="17:30:00" name="selecthoraire" class="horairecheckbox">17h30</label>
	<label><input type="checkbox" value="18:00:00" name="selecthoraire" class="horairecheckbox">18h00</label>
	<label><input type="checkbox" value="18:30:00" name="selecthoraire" class="horairecheckbox">18h30</label>
	<label><input type="checkbox" value="19:00:00" name="selecthoraire" class="horairecheckbox">19h00</label>
	<label><input type="checkbox" value="19:30:00" name="selecthoraire" class="horairecheckbox">19h30</label><br>
	<label><input type="checkbox" value="20:00:00" name="selecthoraire" class="horairecheckbox">20h00</label>
	<label><input type="checkbox" value="20:30:00" name="selecthoraire" class="horairecheckbox">20h30</label>
	<label><input type="checkbox" value="21:00:00" name="selecthoraire" class="horairecheckbox">21h00</label>
	<label><input type="checkbox" value="21:30:00" name="selecthoraire" class="horairecheckbox">21h30</label>
	<label><input type="checkbox" value="22:00:00" name="selecthoraire" class="horairecheckbox">22h00</label><br>
	<label><input type="checkbox" value="22:30:00" name="selecthoraire" class="horairecheckbox">22h30</label>
	<label><input type="checkbox" value="23:00:00" name="selecthoraire" class="horairecheckbox">23h00</label>
	<label><input type="checkbox" value="23:30:00" name="selecthoraire" class="horairecheckbox">23h30</label>
	<label><input type="checkbox" value="24:00:00" name="selecthoraire" class="horairecheckbox">24h00</label><br><br>
	
	
	
    
    <label for="saisirnbtable">Nombre de tables par défaut pour un offre:</label>
	<input type="number" name = "nbtables" class="nbtables" id="nbtables" min="1" max="30">
    <button class="btn calendar initialise save" id="btnsavecalendar" action="" >Sauvegarder</button><br/>
	<h4>Pour modifier votre calendrier restaurant plus précisément, veuillez aller dans rubrique "Modification Restaurant"</h4>

</body>


<?php
include 'include/footer.inc.php';
?>
