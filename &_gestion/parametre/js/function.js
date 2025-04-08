$(document).ready(function(){ 

$("div.msg_erreur").hide(); 

$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
$("div.voir").hide();
setTimeout(function() {
$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
$("div.voir").show();
}, 1500);

$('.button_annul').live('click',function(){
	$("div.msg_erreur").hide(); 
    $(".clo_er").hide(); 
	location.reload();
});

$(".button_annul").live('click', function(){
	$(location).attr('href', 'parametre.php');
});


/**serv_log**/

$("#import_serv_log").live('click', function(){
	$(location).attr('href', 'importer_serv_log.php');
})

$('#ajout_serv_log').live('click', function(){
	$('#myModal_serv_log').modal('show');
});
$('#form_serv_log').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "serv_log/ajout_serv_log.php",
	data: "lib_serv_log="+$("#lib_serv_log").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet serv_log existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_log').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_serv_log('0');
			 $("#lib_serv_log").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_serv_log").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "serv_log/form_modifier_serv_log.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_log_mod").html(msg);
			$("#myModal_serv_log_mod").modal('show');	
		}
	});

});
$('#form_serv_log_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "serv_log/modif_serv_log.php",
	data: "lib_serv_log_mod="+$("#lib_serv_log_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette serv_log existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_log_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_serv_log_mod").val('');
			 //change_page_serv_log('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_serv_log").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "serv_log/form_supprimer_serv_log.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_log_sup").html(msg);
			$("#myModal_serv_log_sup").modal('show');	
		}
	});

});
$('#submit_serv_log_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "serv_log/sup_serv_log.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette serv_log car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_serv_log_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_serv_log('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**serv_log**/



/**serv_bureau_fidest**/

$("#import_serv_bureau_fidest").live('click', function(){
	$(location).attr('href', 'importer_serv_bureau_fidest.php');
})

$('#ajout_serv_bureau_fidest').live('click', function(){
	$('#myModal_serv_bureau_fidest').modal('show');
});
$('#form_serv_bureau_fidest').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "serv_bureau_fidest/ajout_serv_bureau_fidest.php",
	data: "lib_serv_bureau_fidest="+$("#lib_serv_bureau_fidest").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet serv_bureau_fidest existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_bureau_fidest').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_serv_bureau_fidest('0');
			 $("#lib_serv_bureau_fidest").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_serv_bureau_fidest").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "serv_bureau_fidest/form_modifier_serv_bureau_fidest.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_bureau_fidest_mod").html(msg);
			$("#myModal_serv_bureau_fidest_mod").modal('show');	
		}
	});

});
$('#form_serv_bureau_fidest_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "serv_bureau_fidest/modif_serv_bureau_fidest.php",
	data: "lib_serv_bureau_fidest_mod="+$("#lib_serv_bureau_fidest_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette serv_bureau_fidest existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_bureau_fidest_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_serv_bureau_fidest_mod").val('');
			 //change_page_serv_bureau_fidest('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_serv_bureau_fidest").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "serv_bureau_fidest/form_supprimer_serv_bureau_fidest.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_bureau_fidest_sup").html(msg);
			$("#myModal_serv_bureau_fidest_sup").modal('show');	
		}
	});

});
$('#submit_serv_bureau_fidest_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "serv_bureau_fidest/sup_serv_bureau_fidest.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette serv_bureau_fidest car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_serv_bureau_fidest_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_serv_bureau_fidest('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**serv_bureau_fidest**/
/**serv_bureau_banamur**/

$("#import_serv_bureau_banamur").live('click', function(){
	$(location).attr('href', 'importer_serv_bureau_banamur.php');
})

$('#ajout_serv_bureau_banamur').live('click', function(){
	$('#myModal_serv_bureau_banamur').modal('show');
});
$('#form_serv_bureau_banamur').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "serv_bureau_banamur/ajout_serv_bureau_banamur.php",
	data: "lib_serv_bureau_banamur="+$("#lib_serv_bureau_banamur").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet serv_bureau_banamur existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_bureau_banamur').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_serv_bureau_banamur('0');
			 $("#lib_serv_bureau_banamur").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_serv_bureau_banamur").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "serv_bureau_banamur/form_modifier_serv_bureau_banamur.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_bureau_banamur_mod").html(msg);
			$("#myModal_serv_bureau_banamur_mod").modal('show');	
		}
	});

});
$('#form_serv_bureau_banamur_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "serv_bureau_banamur/modif_serv_bureau_banamur.php",
	data: "lib_serv_bureau_banamur_mod="+$("#lib_serv_bureau_banamur_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette serv_bureau_banamur existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_serv_bureau_banamur_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_serv_bureau_banamur_mod").val('');
			 //change_page_serv_bureau_banamur('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_serv_bureau_banamur").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "serv_bureau_banamur/form_supprimer_serv_bureau_banamur.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_serv_bureau_banamur_sup").html(msg);
			$("#myModal_serv_bureau_banamur_sup").modal('show');	
		}
	});

});
$('#submit_serv_bureau_banamur_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "serv_bureau_banamur/sup_serv_bureau_banamur.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette serv_bureau_banamur car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_serv_bureau_banamur_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_serv_bureau_banamur('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**serv_bureau_banamur**/



/**affectation**/

$("#import_affectation").live('click', function(){
	$(location).attr('href', 'importer_affectation.php');
})

$('#ajout_affectation').live('click', function(){
	$('#myModal_affectation').modal('show');
});
$('#form_affectation').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "affectation/ajout_affectation.php",
	data: "lib_affectation="+$("#lib_affectation").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet affectation existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_affectation').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_affectation('0');
			 $("#lib_affectation").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_affectation").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "affectation/form_modifier_affectation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_affectation_mod").html(msg);
			$("#myModal_affectation_mod").modal('show');	
		}
	});

});
$('#form_affectation_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "affectation/modif_affectation.php",
	data: "lib_affectation_mod="+$("#lib_affectation_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette affectation existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_affectation_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_affectation_mod").val('');
			 //change_page_affectation('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_affectation").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "affectation/form_supprimer_affectation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_affectation_sup").html(msg);
			$("#myModal_affectation_sup").modal('show');	
		}
	});

});
$('#submit_affectation_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "affectation/sup_affectation.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette affectation car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_affectation_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_affectation('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**affectation**/


/**chantier**/

$("#import_chantier").live('click', function(){
	$(location).attr('href', 'importer_chantier.php');
})

$('#ajout_chantier').live('click', function(){
	$('#myModal_chantier').modal('show');
});
$('#form_chantier').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "chantier/ajout_chantier.php",
	data: "lib_chantier="+$("#lib_chantier").val()+"&cout_total_chantier="+$("#cout_total_chantier").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet chantier existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_chantier').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_chantier('0');
			 $("#lib_chantier").val('');
			 $("#cout_total_chantier").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_chantier").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "chantier/form_modifier_chantier.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_chantier_mod").html(msg);
			$("#myModal_chantier_mod").modal('show');	
		}
	});

});
$('#form_chantier_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "chantier/modif_chantier.php",
	data: "lib_chantier_mod="+$("#lib_chantier_mod").val()+"&cout_total_chantier_mod="+$("#cout_total_chantier_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cet chantier existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_chantier_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_chantier_mod").val('');
			 //change_page_chantier('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_chantier").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "chantier/form_supprimer_chantier.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_chantier_sup").html(msg);
			$("#myModal_chantier_sup").modal('show');	
		}
	});

});
$('#submit_chantier_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "chantier/sup_chantier.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cet chantier car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_chantier_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_chantier('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**chantier**/


/**operation**/

$("#import_operation").live('click', function(){
	$(location).attr('href', 'importer_operation.php');
})

$('#ajout_operation').live('click', function(){
	$('#myModal_operation').modal('show');
});
$('#form_operation').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "operation/ajout_operation.php",
	data: "lib_operation="+$("#lib_operation").val()+"&chantier_id_operation="+$("#chantier_id_operation").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet operation existe d&eacute;j&agrave; sur ce chantier !").show();
		}
		else
		{
			 $('#myModal_operation').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_operation('0');
			 $("#lib_operation").val('');
			 $("#chantier_id_operation").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_operation").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "operation/form_modifier_operation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_operation_mod").html(msg);
			$("#myModal_operation_mod").modal('show');	
		}
	});

});
$('#form_operation_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "operation/modif_operation.php",
	data: "lib_operation_mod="+$("#lib_operation_mod").val()+"&chantier_id_operation_mod="+$("#chantier_id_operation_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette operation existe d&eacute;j&agrave; sur ce chantier !").show();
		}
		else
		{
			 $('#myModal_operation_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_operation_mod").val('');
			 $("#chantier_id_operation_mod").val('');
			 //change_page_operation('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_operation").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "operation/form_supprimer_operation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_operation_sup").html(msg);
			$("#myModal_operation_sup").modal('show');	
		}
	});

});
$('#submit_operation_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "operation/sup_operation.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette operation car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_operation_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_operation('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**operation**/


/**designation**/
$("#prix_designation").on('keyup', function(){
	var tot_des = $("#qte_designation").val()*$("#prix_designation").val();
	$("#total_designation").val(tot_des);
});
$("#qte_designation").on('keyup', function(){
	var tot_des = $("#qte_designation").val()*$("#prix_designation").val();
	var tot_debour = parseFloat($("#fourniture_debourse").val())+parseFloat($("#main_doeuvre_debourse").val());
	$("#total_designation").val(tot_des);
	$("#montant_debourse").val(tot_debour);
});
$("#fourniture_debourse").on('keyup', function(){
	var tot_des = $("#qte_designation").val()*$("#prix_designation").val();
	var tot_debour = parseFloat($("#fourniture_debourse").val())+parseFloat($("#main_doeuvre_debourse").val());
	$("#total_designation").val(tot_des);
	$("#montant_debourse").val(tot_debour);
});
$("#main_doeuvre_debourse").on('keyup', function(){
	var tot_des = $("#qte_designation").val()*$("#prix_designation").val();
	var tot_debour = parseFloat($("#fourniture_debourse").val())+parseFloat($("#main_doeuvre_debourse").val());
	$("#total_designation").val(tot_des);
	$("#montant_debourse").val(tot_debour);
});



$("#import_designation").live('click', function(){
	$(location).attr('href', 'importer_designation.php');
});

$("#download_designation").live('click', function(){
	$(location).attr('href', '../exportation/excel/excel_designation.php');
});

$('#ajout_designation').live('click', function(){
	$('#myModal_designation').modal('show');
});
$('#form_designation').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "designation/ajout_designation.php",
	data: "lib_designation="+$("#lib_designation").val()+"&operation_id_designation="+$("#operation_id_designation").val()+"&qte_designation="+$("#qte_designation").val()+"&prix_designation="+$("#prix_designation").val()+"&fourniture_debourse="+$("#fourniture_debourse").val()+"&main_doeuvre_debourse="+$("#main_doeuvre_debourse").val()+"&montant_debourse="+$("#montant_debourse").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cet designation existe d&eacute;j&agrave; sur ce chantier !").show();
		}
		else
		{
			 $('#myModal_designation').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 change_page_designation('0');
			 $("#lib_designation").val('');
			 $("#operation_id_designation").val('');
			 $("#qte_designation").val('');
			 $("#prix_designation").val('');
			 $("#fourniture_debourse").val('');
			 $("#main_doeuvre_debourse").val('');
			 $("#montant_debourse").val('');
			 //$(location).attr('href', 'parametre.php');
		}
	}
 });
	
 return false;
}); 


$(".edit_designation").live('click', function() {
var id_ref = $(this).attr('data-id');

	$.ajax({
		type: "GET",
		url: "designation/form_modifier_designation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_designation_mod").html(msg);
			$("#myModal_designation_mod").modal('show');	
		}
	});

});
$('#form_designation_mod').live('submit',function(){	

alert("lib_designation_mod="+$("#lib_designation_mod").val()+"&operation_id_designation_mod="+$("#operation_id_designation_mod").val()+"&qte_designation_mod="+$("#qte_designation_mod").val()+"&prix_designation_mod="+$("#prix_designation_mod").val()+"&fourniture_debourse_mod="+$("#fourniture_debourse_mod").val()+"&main_doeuvre_debourse_mod="+$("#main_doeuvre_debourse_mod").val()+"&montant_debourse_mod="+$("#montant_debourse_mod").val());

$.ajax({
	type: "POST",
	url: "designation/modif_designation.php",
	data: "lib_designation_mod="+$("#lib_designation_mod").val()+"&operation_id_designation_mod="+$("#operation_id_designation_mod").val()+"&qte_designation_mod="+$("#qte_designation_mod").val()+"&prix_designation_mod="+$("#prix_designation_mod").val()+"&fourniture_debourse_mod="+$("#fourniture_debourse_mod").val()+"&main_doeuvre_debourse_mod="+$("#main_doeuvre_debourse_mod").val()+"&montant_debourse_mod="+$("#montant_debourse_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette designation existe d&eacute;j&agrave; sur ce chantier !").show();
		}
		else
		{
			 $('#myModal_designation_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#lib_designation_mod").val('');
			 $("#operation_id_designation_mod").val('');
			 $("#qte_designation_mod").val('');
			 $("#prix_designation_mod").val('');
			 //change_page_designation('0');
			 $(location).attr('href', 'parametre.php');
		}
	}
 });

 return false;
});

$(".delete_designation").live('click', function() {
var id_ref = $(this).attr('data-id');
	$.ajax({
		type: "GET",
		url: "designation/form_supprimer_designation.php",
		data: "ref="+id_ref,
		success: function(msg){
			$("#affiche_designation_sup").html(msg);
			$("#myModal_designation_sup").modal('show');	
		}
	});

});
$('#submit_designation_sup').live('click',function(){
							  
$.ajax({
	type: "POST",
	url: "designation/sup_designation.php",
	success: function(msg){
		
		if(msg==1)
		{
			$("div.msg_erreur").addClass("red"); 
			$("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Impossible de supprimer cette designation car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
			$('#myModal_designation_sup').modal('toggle');
		  	$("div.msg_erreur").hide(); 
		  	$(".clo_er").hide(); 
		  	//change_page_designation('0');
		  	$(location).attr('href', 'parametre.php');
		}
	}
 });
 return false;
}); 

/**designation**/

change_page_serv_log('0');
change_page_serv_bureau_fidest('0');
change_page_serv_bureau_banamur('0');
change_page_affectation('0');
change_page_chantier('0');
change_page_operation('0');
change_page_designation('0');
 
});


function change_page_serv_log(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "serv_log/charge_serv_log.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_serv_log").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_serv_log").html(result).show();
			}
	 });

}

function change_page_serv_bureau_fidest(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "serv_bureau_fidest/charge_serv_bureau_fidest.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_serv_bureau_fidest").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_serv_bureau_fidest").html(result).show();
			}
	 });

}

function change_page_serv_bureau_banamur(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "serv_bureau_banamur/charge_serv_bureau_banamur.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_serv_bureau_banamur").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_serv_bureau_banamur").html(result).show();
			}
	 });

}

function change_page_affectation(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "affectation/charge_affectation.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_affectation").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_affectation").html(result).show();
			}
	 });

}

function change_page_chantier(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "chantier/charge_chantier.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_chantier").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_chantier").html(result).show();
			}
	 });

}

function change_page_operation(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "operation/charge_operation.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_operation").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_operation").html(result).show();
			}
	 });

}

function change_page_designation(page_id_cons){
	
	var page_id_cons=0;

	var dataString = 'page_id_cons='+ page_id_cons;
	$.ajax({
			type: "POST",
			url: "designation/charge_designation.php",
			data: dataString,
			cache: false,
			beforeSend: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
				$(".aff_designation").hide();
			},
			success: function(result){
				$("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
				$(".aff_designation").html(result).show();
			}
	 });

}

