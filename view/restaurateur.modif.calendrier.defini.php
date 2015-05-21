
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
		<script src='view/restaurateur.modif.calendrier.defini.js'></script>
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
		max-width: 600px;
		margin: 0 auto;
		overflow-y: visible;
	}
	#regles {
		text-align:center;
		float: left;
	}
</style>

<?php
	
	if(isset($_SESSION['msg_alert'])){
		echo '<script>alert("'.$_SESSION['msg_alert'].'")</script>';
		unset($_SESSION['msg_alert']);
	}
	$regles_special = $oBdd->get_calendar_specialrules($_SESSION['ID_RESTO_MODIF']);
	$regles_hebdos = $oBdd->get_calendar_weeklyrules($_SESSION['ID_RESTO_MODIF']);
	echo $_SESSION['ID_RESTO_MODIF'];
?>
<div id='regles'>
	<h3>Définition du calendrier hebdomadaire des tranches horaires disponibles</h3>
	<table id="reglelisthebdo" ><thead><tr>
		<td>Jours</td>
		<td>Horaires</td>
		<td>Tables</td>
		<td></td><td><button class="btn creer regle" id="BtnAjoutRegleHebdo">Ajouter</button></td>
		</tr></thead><tbody>
		<?php
		foreach ($regles_hebdos as $regle){
			echo '<tr>
			<td>'.$regle['JOUR'].'</td>
			<td>'.$regle['HORAIRE'].'</td>
			<td>'.$regle['NB_TABLES'].'</td>
			<td><button class="btn modif regle" onclick="modif_regle_hebdo(this,'.$regle['ID_REGLE_HEBDO'].')" >Modifier</button></td>
			<td> <a href="'.$_SERVER['PHP_SELF'].'?category=35&op=delete_weeklyrule&ruleid='.$regle['ID_REGLE_HEBDO'].'"><button class="btn delete regle" >Supprimer</button></a></td></tr>';
		}
		?>
		</tbody>
	</table>
	<h3>Définition des jours exceptionnels</h3>
	<table id="reglelistexcep" ><thead><tr>
		<td>Date</td>
		<td>Horaire</td>
		<td>Tables</td>
		<td></td><td><button class="btn creer regle" id="BtnAjoutRegleExcep">Ajouter</button></td>
		</tr></thead>
		<tbody><?php
		foreach ($regles_special as $regle){
			echo '<tr>
			<td>'.$regle['DATE_EXCEPTION'].'</td>
			<td>'.$regle['HORAIRE'].'</td>
			<td>'.$regle['NB_TABLES'].'</td>
			<td><button class="btn modif regle" onclick="modif_regle_excep(this,'.$regle['ID_REGLE_EXCEP'].')" >Modifier</button></td>
			<td> <a href="'.$_SERVER['PHP_SELF'].'?category=35&op=delete_specialrule&ruleid='.$regle['ID_REGLE_EXCEP'].'"><button class="btn delete regle" >Supprimer</button></a></td></tr>';
		}?>
		</tbody>
	</table>
	<p><a href="javascript:history.back()"> Retour</a></p>
</div>

<div id='calendar'>

<div id="DialogModifRegleHebdo" title="Modifier un règle" style='display:none'>
	<form id="ModifRegleHebdoForm" action="<?php echo $_SERVER['PHP_SELF'].'?category=35&op=modif_weeklyrule'; ?>" method="post">
		<input name="id" type='text' id='idreglehebdo' style='display:none'	readonly='readonly'/><br/>
		<input name="jourhebdo" type='text' id='jourhebdo' readonly='readonly'/><br/>
		<input name="horairehebdo" type='text' id='horairehebdo' readonly='readonly'/><br/>
		<label for="nbtableshebdo">Nombre de tables possibles :</label><br/>
		<input type="number" name="nbtables" id="nbtableshebdo" min="1" max="30"><br/>
		<input type="submit" value="Sauvegarder cette régle" />
	</form>
</div>

<div id="DialogModifRegleExcep" title="Modifier un règle" style='display:none' readonly='readonly'>
	<form id="ModifRegleExcepForm" action="<?php echo $_SERVER['PHP_SELF'].'?category=35&op=modif_specialrule'; ?>" method="post">
		<input name="id" type='text' id='idregleexcep' style='display:none'	readonly='readonly'/><br/>
		<input name="dateexcep" type='text' id='dateexcep' readonly='readonly'/><br/>
		<input name="horaireexcep" type='text' id='horaireexcep' readonly='readonly'/><br/>
		<label for="nbtablesexcep">Nombre de tables possibles :</label><br/>
		<input type="number" name="nbtables" id="nbtablesexcep" min="0" max="30"><br/>
		<input type="submit" value="Sauvegarder cette régle" />
	</form>
</div>

<div id="DialogCreeRegleHebdo" title="Crée une règle hebdomataire" style='display:none'>
	<form id="CreeRegleHebdoForm" action="<?php echo $_SERVER['PHP_SELF'].'?category=35&op=create_weeklyrule'; ?>" method="post">
		<label for="selecjour">Selectionner le jour:</label><br/>
		<select name = "selecjour" id="selecjour" >
			<option value="1" />Lundi</option> 
			<option value="2" />Mardi</option> 
			<option value="3" />Mercredi</option> 
			<option value="4" />Jeudi</option> 
			<option value="5" />Vendredi</option> 
			<option value="6" />Samedi</option> 
			<option value="7" />Dimanche</option>
		</select>
		<br/><br/>
		<label for="selecthorairehebdo">Selectionner l'horaire:</label><br/>
		<select name="selecthorairehebdo" id="selecthorairehebdo" >
			<?php
			for($i = 1;$i < 25;$i++){
				echo '<option value="'.$i.'" />'.$i.':00:00</option> ';
			}?>
		</select><br/>
		<label for="nbtablescreehebdo">Nombre de tables possibles :</label><br/>
		<input type="number" name="nbtables" id="nbtablescreehebdo" min="1" max="30"><br/>
		<input type="submit" value="Sauvegarder cette régle" />
	</form>
</div> 
<div id="DialogCreeRegleExcep" title="Crée une règle exceptionnelle" style='display:none'>
	<form id="CreeRegleHebdoForm" action="<?php echo $_SERVER['PHP_SELF'].'?category=35&op=create_specialrule'; ?>" method="post">
		<label for="dateexcepcree">Selectionner le date exceptionnel:</label><br/>
		<input type="text" name="dateexcepcree" id="dateexcepcree"><br/>
		<label for="selecthoraireexcep">Selectionner l'horaire:</label><br/>
		<select name="selecthoraireexcep" id="selecthoraireexcep" >
			<?php
			for($i = 1;$i < 25;$i++){
				echo '<option value="'.$i.'" />'.$i.':00:00</option> ';
			}?>
		</select><br/>
		<label for="nbtablescreeexcep">Nombre de tables possibles :</label><br/>
		<input type="number" name="nbtables" id="nbtablescreeexcep" min="0" max="30"><br/>
		<input type="submit" value="Sauvegarder cette régle" />
	</form>
</div> 
<?php
    include 'include/footer.inc.php';
?>