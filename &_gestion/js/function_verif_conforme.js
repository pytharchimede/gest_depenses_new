$(document).ready(function(){ 

$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').show();
$("div.affiche_verif_conforme").hide();

setTimeout(function() {
$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').hide();
$("div.affiche_verif_conforme").show();
change_page_verif_conforme('0');
}, 1500);


$("div.msg_erreur").hide(); 


$('#recher_date_debut').on('change',function(){
   
	
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();
    var recher_affectation = $("#recher_affectation").val();
	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_verif_conforme.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_verif_conforme").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_verif_conforme").html(result).show(); 
		   }
      });
});

$('#recher_date_fin').on('change',function(){
   
	
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();
    var recher_affectation = $("#recher_affectation").val();
	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_verif_conforme.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_verif_conforme").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_verif_conforme").html(result).show(); 
		   }
      });
});

$('#recher_demandeur').on('keyup',function(){
   
    
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();
    var recher_affectation = $("#recher_affectation").val();
	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_verif_conforme.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_verif_conforme").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_verif_conforme").html(result).show(); 
		   }
      });
});

$('#recher_affectation').live('change',function(){
   
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();
    var recher_affectation = $("#recher_affectation").val();
	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_verif_conforme.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_verif_conforme").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_verif_conforme").html(result).show(); 
		   }
      });
});



 
});


function change_page_verif_conforme(page_id){
	var recher_date_debut='';
	var recher_date_fin='';
    var recher_demandeur='';
    var recher_affectation='';

    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_verif_conforme.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".affiche_verif_conforme").html(result);
		   }
      });
}
