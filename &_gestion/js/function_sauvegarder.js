$(document).ready(function(){ 

$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').show();
$("div.affiche_sauvegarder").hide();

setTimeout(function() {
$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').hide();
$("div.affiche_sauvegarder").show();
change_page_sauvegarder('0');
}, 1500);


$("div.msg_erreur").hide(); 



$('#recher_etat').on('change',function(){
   
	var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
});

$('#recher_date_debut').on('change',function(){
   
	var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
});

$('#recher_date_fin').on('change',function(){
   
	var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
});

$('#recher_demandeur').on('keyup',function(){
   
	var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
});

$('#recher_chantier').on('change',function(){
       
  	var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
    });
    
    $('#recher_affectation').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
	var recher_date_debut = $("#recher_date_debut").val();
	var recher_date_fin = $("#recher_date_fin").val();
    var recher_demandeur = $("#recher_demandeur").val();

	var page_id='0';
    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_sauvegarder").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_sauvegarder").html(result).show(); 
		   }
      });
 });



 
});


function change_page_sauvegarder(page_id){
	var recher_etat='';
	var recher_date_debut='';
	var recher_date_fin='';
    var recher_demandeur='';


    var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur;
     $.ajax({
           type: "POST",
           url: "src/charge_sauvegarder.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".affiche_sauvegarder").html(result);
		   }
      });
}
