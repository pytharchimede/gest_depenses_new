$(document).ready(function(){ 

$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').show();
$("div.affiche_point_chantier").hide();

setTimeout(function() {
$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').hide();
$("div.affiche_point_chantier").show();
change_page_point_chantier('0');
}, 1500);


$("div.msg_erreur").hide(); 



$('#recher_chantier').on('change',function(){
   
    var recher_chantier = $("#recher_chantier").val();


	var page_id='0';

    var dataString = 'page_id='+page_id+'&recher_chantier='+recher_chantier;
     $.ajax({
           type: "POST",
           url: "src/charge_point_chantier.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_point_chantier").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_point_chantier").html(result).show(); 
		   }
      });
});


change_page_point_chantier('0');
 
});


function change_page_point_chantier(page_id){

    var recher_chantier = '';


    var dataString = 'page_id='+page_id+'&recher_chantier='+recher_chantier;
     $.ajax({
           type: "POST",
           url: "src/charge_point_chantier.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".affiche_point_chantier").html(result);
		   }
      });
}
