<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.css' rel='stylesheet' />

<script src='http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.3.1/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.3.1/lang/fr.js'></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>


$(document).ready(function() {

	$( "#DialogModifRegle" ).dialog({ 
		autoOpen: false,
		height: 600,
		width: 600
	});
	$( "#opener" ).click(function() {
		$( "#DialogModifRegle" ).dialog( "open" );
	});

	$("#btnmodifregle").click(function(){
		$.ajax({
		url: 'ajax/lire_calendrier_regles_special.php',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
			
		},
		success: function() {
			alert("votre calendrier a été bien enregistré");
			window.location.href="index.php?category=4";
		}
		});
	});
	$("#btnajouterhebdo").click(function(){
		
		var str = '<tr><td>';
		$("input.jourcheckbox").each(function(){
			if(this.checked){
				str = str + this.nextSibling.data.substring(0,3) + ',';
			}
		});
		str = str + '</td><td>' + $("select#selechoraire").children()[$("select#selechoraire").val()-1].text
		+ '</td><td>' + $ ("input#nbtables").val() + '</td><td>' + 
		'<button class="btn delete horaire" onclick="modifregle(this)" >Supprimer</button>' + '</td></tr>';
		
		$('table#horairelist').append(str);
	});
	//ajouter dans le table
	function ModifRegle(e){
		$( "#DialogModifRegle" ).dialog( "open" );
	}
	
});




</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		float: left;
		max-width: 700px;
		margin: 0 auto;
	}

</style>
</head>
<body>
<a href="index.php?category=4&idresto=">Afficher le calendrier complet du restaurant</a>
<button id="opener">open the dialog</button>
<table id="reglelist" ><thead><tr>
    <td>Jours</td>
    <td>Horaire</td>
    <td>Nombre de tables</td>
    <td></td>
    </tr></thead><tbody></tbody>
</table>
<div id="DialogModifRegle" title="Modifier un règle">
    <label for="selecjour">Selectionner le jour:</label><br/>
	<select>
		<option class="selecjour" name="selecjour" id="selecjour2" value="2" />Lundi</label> 
		<option class="selecjour" name="selecjour" id="selecjour3" value="3" />Mardi</label> 
		<option class="selecjour" name="selecjour" id="selecjour4" value="4" />Mercredi</label> 
		<option class="selecjour" name="selecjour" id="selecjour5" value="5" />Jeudi</label> 
		<option class="selecjour" name="selecjour" id="selecjour6" value="6" />Vendredi</label> 
		<option class="selecjour" name="selecjour" id="selecjour7" value="7" />Samedi</label> 
		<option class="selecjour" name="selecjour" id="selecjour1" value="1" />Dimanche</label>
	</select>
    <br/><br/>
    <label for="selechoraire">Selectionner les horaires de votre restaurant:</label><br/>
    <select>
		<?php
		for($i = 1;$i < 25;$i++){
			echo '<option class="selechoraire" name="selechoraire" id="selechoraire'.$i.'" value="'.$i.'" />'.$i.':00:00</label> ';
		}?>
	</select><br/>
    <label for="saisirnbtable">Nombre de tables possibles pour un offre:</label><br/>
    <input type="number" name = "nbtables" id="nbtables" min="1" max="30"><br/>
    <button class="btn valider" id="btnmodifregle" action="" >Valider cette régle</button>
    
	
</div>


</body>
</html>


