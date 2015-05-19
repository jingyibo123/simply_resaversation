$(document).ready(function() {
	$('#calendar').fullCalendar({
		lang: 'fr',
		editable: true,
		selectable: false,
		dayClick: function(date, jsEvent, view) {
			if($(this).css('background-color')=='rgb(80, 120, 255)'){
				$('.fc-day').each(function(index){
					if($(this).css('background-color') == 'rgb(0, 128, 0)'){
						$(this).css('background-color', 'rgb(80, 120, 255)');
					}
				});//enlever le marque precedent
				$(this).css('background-color','green');//marquer le jour choisi
				$('#HoraireListDiv').children('table').children('tbody').children().remove();
				var i = 0;
				for(var key in window.calendrier[$(this).attr('data-date')]){
					var str = '<tr><td><input type=\'radio\' name=\'horaire\' class=\'horaireboutton\' id=\'horaireboutton';
					str = str + i;
					str = str + '\' onclick=\'ShowContinueButton(this)\' /><label for=\'horaireboutton';
					str = str + i;
					str = str + '\'>'
					str = str + key;
					str = str + '</label></td></tr>';
					$('#HoraireListDiv').children('table').children('tbody').append(str);
					i = i + 1;
				}
				$('#CtnBtn').fadeOut();
				$('#TableTotalDiv').fadeOut();
				$('#HoraireListDiv').fadeIn();
				
			}

		},
		events: function( start, end, timezone, callback ) {
			$.ajax({
				url: 'ajax/lire_calendrier_dispo.php',
				type: 'POST',
				dataType: 'json',
				cache: false,
				data: {
					start: start.format('YYYY-MM-DD'),
					end: end.format('YYYY-MM-DD'),
				},
				success: function(response) {
					window.calendrier = response;
					window.AvailableDays = new Array();
					for(var key in window.calendrier){
						window.AvailableDays.push(key);
					}
					for(var i in window.AvailableDays){//mettre en couleurs les dates possibles
						$('.fc-day').each(function(index){
						if($(this).attr('data-date') == window.AvailableDays[i] && Date.parse($(this).attr('data-date')) > new Date() && !$(this).hasClass('fc-other-month'))
							$(this).css('background-color', 'rgb(80, 120, 255)');
						});
					}
				}
			});
		},
		viewRender: function(currentView){//désactiver les dates avant ajd
			var minDate = moment(),
			maxDate = moment().add(2,'weeks');
			// Past
			if (minDate >= currentView.start && minDate <= currentView.end) {
				$('.fc-prev-button').prop('disabled', true); 
				$('.fc-prev-button').addClass('fc-state-disabled'); 
			}
			else {
				$('.fc-prev-button').removeClass('fc-state-disabled'); 
				$('.fc-prev-button').prop('disabled', false); 
			}
		},
		eventLimit: false,
		timeFormat: 'H:mm'
	});

	$( '#DialogResa' ).dialog({ 
		autoOpen: false,
		height: 600,
		width: 600,
		modal: true
	});
	$( '#CtnBtn' ).click(function() {
		var sDate,sTime,sDateTime,iNbtable;
		$('.fc-day').each(function(){
			if($(this).css('background-color') == 'rgb(0, 128, 0)'){
				sDate = $(this).attr('data-date');
			}
		});
		$('.horaireboutton').each(function(){
			if(this.checked){
				sTime = $(this).next().html();
			}
		});
		// $('.tabletotalboutton').each(function(){
			// if(this.checked){
				// iNbtable = $(this).next().html();
			// }
		// });
		$('#OrderDetailDateTime').val(sDate + ' ' + sTime);
		$('#OrderDetailDateTime').attr("readonly","readonly");
		// $('#OrderDetailNbTable').val(iNbtable);
		// $('#OrderDetailNbTable').attr("readonly","readonly");
		$( '#DialogResa' ).dialog( 'open' );
	});
});
function ShowContinueButton(e){
	$('#CtnBtn').fadeIn();
}
// function ShowTableTotalChooser(e){
	// $('#CtnBtn').fadeOut();
	// var date;
	// $('.fc-day').each(function(index){
		// if($(this).css('background-color') == 'rgb(0, 128, 0)'){
			// date = $(this).attr('data-date');
		// }
	// });//trouver le date choisi maintenant
	// $('#TableTotalDiv').children('table').children('tbody').children().remove();
	// for(var i = 1; i <= window.calendrier[date][$(e).next().html()] ;i++){
		// var str = '<tr><td><input type=\'radio\' name=\'tabletotal\' class=\'tabletotalboutton\' id=\'tabletotalboutton';
		// str = str + i;
		// str = str + '\'  onclick=\'ShowContinueButton(this)\'/><label for=\'tabletotalboutton';
		// str = str + i;
		// str = str + '\'>'
		// str = str + i
		// str = str + '</label></td></tr>';
		// $('#TableTotalDiv').children('table').children('tbody').append(str);
	// }
	// $('#TableTotalDiv').fadeIn();
// }
