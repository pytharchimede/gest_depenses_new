$(document).ready(function(){ 

$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').show();
$("div.affiche_approbation").hide();

setTimeout(function() {
$("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').hide();
$("div.affiche_approbation").show();
change_page_approbation('0');
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
           url: "src/charge_approbation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_approbation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_approbation").html(result).show(); 
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
           url: "src/charge_approbation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_approbation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_approbation").html(result).show(); 
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
           url: "src/charge_approbation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_approbation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_approbation").html(result).show(); 
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
           url: "src/charge_approbation.php",
           data: dataString,
           cache: false,
		    beforeSend: function(){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
			$(".affiche_approbation").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
		  $(".affiche_approbation").html(result).show(); 
		   }
      });
});



 
});


function change_page_approbation(page_id){
	var recher_date_debut='';
	var recher_date_fin='';
    var recher_demandeur='';
    var recher_affectation='';

    var dataString = 'page_id='+page_id+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_demandeur='+recher_demandeur+'&recher_affectation='+recher_affectation;
     $.ajax({
           type: "POST",
           url: "src/charge_approbation.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".affiche_approbation").html(result);
		   }
      });
}
