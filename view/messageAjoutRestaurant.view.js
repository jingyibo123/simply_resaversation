$( "#dialog" ).dialog({ 
    autoOpen: false,
    height: 800,
    width: 700
});
$( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
});

$ ("input#nbtablesrange").change (function (){
    $ ("input#nbtables").val($ ("input#nbtablesrange").val());
});


$("button#btnsavecalendar").click(function(){
	var jours = new Array();
	var horaires = new Array();
    $("input.jourcheckbox").each(function(){
        if(this.checked){
            jours.push(this.id.substring(9,10));
        }
    });
	$("input.horairecheckbox").each(function(){
        if(this.checked){
            horaires.push(this.nextSibling.data);
        }
    });
	if(jours.length == 0&&horaires.length == 0){
		alert("Veuillez selectionner d'abord les jours les horaires");
		return;
	}
	var nbtables = $("input#nbtables").val();
	if(nbtables == ''){
		alert("Veuillez définir le nombre de tables disponinbles");
		return;
	}
    $.ajax({
		url: 'ajax/calendrier.initialiser.php',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data: {
			jours: jours,
			horaires: horaires,
			nbtables: nbtables
		},
		success: function() {
			alert("votre calendrier a été bien enregistré");
			window.location.href="index.php?category=4";
		}
	});
});
$("button#btncancelcalendar").click(function(){
	$( "#dialog" ).dialog( "close" );
});


