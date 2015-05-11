$( "#dialog" ).dialog({ 
    autoOpen: false,
    height: 600,
    width: 600
});
$( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
});

$ ("input#nbtablesrange").change (function (){
    $ ("input#nbtables").val($ ("input#nbtablesrange").val());
});
//recharge de case selon le glisseur
$("#btnajouterhebdo").click(function(){
    
    var str = '<tr><td>';
    $("input.jourcheckbox").each(function(){
        if(this.checked){
            str = str + this.nextSibling.data.substring(0,3) + ',';
        }
    });
    str = str + '</td><td>' + $("select#selechoraire").children()[$("select#selechoraire").val()-1].text + '</td><td>' + $ ("input#nbtables").val() + '</td><td>' + '<button class="btn delete horaire" onclick="supprimerhoraire(this)" >Supprimer</button>' + '</td></tr>';
    $('table#horairelist').append(str);
});
//ajouter dans le table
function supprimerhoraire(e){  
    if(confirm("Supprimer l'horaire choisi?")){
        $(e).parent().parent("tr").remove();
    }
}
