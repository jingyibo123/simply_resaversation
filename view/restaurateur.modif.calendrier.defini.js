function modif_regle_excep(e,ruleid){  
	$("#idregleexcep").val(ruleid);
	$('#dateexcep').val($(e).parent().prev().prev().prev().text());
	$('#horaireexcep').val($(e).parent().prev().prev().text());
	$("#nbtablesexcep").val( $(e).parent().prev().text());
	$( "#DialogModifRegleExcep" ).dialog( "open" );
}
function modif_regle_hebdo(e,ruleid){ 
	$("#idreglehebdo").val(ruleid);
	$('#jourhebdo').val($(e).parent().prev().prev().prev().text());
	$('#horairehebdo').val($(e).parent().prev().prev().text());
	$("#nbtableshebdo").val( $(e).parent().prev().text());
	$( "#DialogModifRegleHebdo" ).dialog( "open" );
}

$(document).ready(function() {
    $('#calendar').fullCalendar({
        lang: 'fr',
        defaultDate: '2015-03-12',
        editable: false,
		disableDragging: true,
        selectable: false,
        eventLimit: false,
        timeFormat: 'H:mm',
		contentHeight: 'auto',
        events: function( start, end, timezone, callback ) {
			$.ajax({
            url: 'ajax/lire_calendrier_defini.php',
			type: 'POST',
            dataType: 'json',
            data: {
                start: start.format("YYYY-MM-DD"),
                end: end.format("YYYY-MM-DD")
            },
            success: function(response) {
				
                callback(response);
            }
        });
		},
    });
	$( "#dateexcepcree" ).datepicker({
	dateFormat: "yy-mm-dd",
	});
	$( "#DialogModifRegleHebdo" ).dialog({ 
		autoOpen: false,
		height: 400,
		width: 400
	});
	$( "#DialogModifRegleExcep" ).dialog({ 
		autoOpen: false,
		height: 400,
		width: 400
	});
	$( "#DialogCreeRegleHebdo" ).dialog({ 
		autoOpen: false,
		height: 400,
		width: 400
	});
	$( "#DialogCreeRegleExcep" ).dialog({ 
		autoOpen: false,
		height: 400,
		width: 400
	});
	$( "#BtnAjoutRegleHebdo" ).click(function() {
		$( '#DialogCreeRegleHebdo' ).dialog( 'open' );
	});
	$( "#BtnAjoutRegleExcep" ).click(function() {
		$( '#DialogCreeRegleExcep' ).dialog( 'open' );
	});
});