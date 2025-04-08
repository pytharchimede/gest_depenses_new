
$(document).ready(function(){ 

$("div.chargement").html('<img src="../../images/MnyxU.gif" style="width:25px; height:25px;" />').show();
$("div.voir").hide();
setTimeout(function() {
$("div.chargement").html('<img src="../../images/MnyxU.gif" style="width:25px; height:25px;" />').hide();
$("div.voir").show();
}, 1500);

$("#type_armoire").val('');
$("#armoire").val('');

   $("div.msg_erreur").hide(); 
   $(".clo_er").hide();
  
   $('.button_annul').live('click',function(){
	$("div.msg_erreur").hide(); 
    $(".clo_er").hide(); 
	$("#type_armoire").val('');
	});
	
	$(".close").live('click', function() {
    $("div.msg_erreur").hide(); 
    $(".clo_er").hide(); 
	$("#type_armoire").val('');
	$("#armoire").val('');
	}); 
	
});


$(document).ready(function(){ 

/**type d'armoire**/

$('#form_type_armoire').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "type_armoire/ajout_type_armoire.php",
	data: "type_armoire="+$("#type_armoire").val(),
	success: function(msg){
		
		if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce type darmoire existe deja !").show();
		}
		else
		{
		 $('#myModal_type_armoire').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#type_armoire").val('');
			 change_page_type_armoire('0');
		 /*location.reload(); */
		}
	}
});
	
	 return false;
}); 


$(".edit_type_armoire").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "type_armoire/form_modifier_type_armoire.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_type_armoire_mod").html(msg);
$("#myModal_type_armoire_mod").modal('show');	
}
});

});



$('#form_type_armoire_mod').live('submit',function(){	

	$.ajax({
	type: "POST",
	url: "type_armoire/modif_type_armoire.php",
	data: "type_armoire_mod="+$("#type_armoire_mod").val(),
	success: function(msg){
 if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce type d'armoire existe deja !").show();
		}
		else
		{
		 $('#myModal_type_armoire_mod').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#type_armoire_mod").val('');
			 change_page_type_armoire('0');
		 /*location.reload(); */
		}
	}
});

	 return false;
});

$(".delete_type_armoire").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "type_armoire/form_supprimer_type_armoire.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_type_armoire_sup").html(msg);
$("#myModal_type_armoire_sup").modal('show');	
}
});

});

$('#submit_type_armoire_sup').live('click',function(){
							
	$.ajax({
	type: "POST",
	url: "type_armoire/sup_type_armoire.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
 $("div.msg_erreur").html("Impossible de supprimer ce type d'armoire car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
	 $('#myModal_type_armoire_sup').modal('toggle');
		$("div.msg_erreur").hide(); 
						$(".clo_er").hide(); 
		change_page_type_armoire('0');
		/*location.reload(); */
		}
	}
});
	 return false;
}); 

/**fin Type d'armoire**/

/**Groupe d'utilisateurs**/

$('#form_groupe_utilisateur').live('submit',function(){	
	
	var groupe_utilisateur = $("#groupe_utilisateur").val();
	var role_groupe_utilisateur = $("#role_groupe_utilisateur").val();
	var membre = $("#membre").val();

	if(groupe_utilisateur=="")
	{
		$("div.msg_erreur").html("Veuillez saisir un nom de groupe svp !").show();
		("#groupe_utilisateur").focus();
	}
	else if(role_groupe_utilisateur=="")
	{
		$("div.msg_erreur").html("Choisissez un role svp !").show();
		("#role_groupe_utilisateur").focus();
	}
	else if(membre=="")
	{
		$("div.msg_erreur").html("Veuillez s&eacute;lectionner un ou plusieurs membre(s) !").show();
		("#membre").focus();
	}
	else
	{
	$.ajax({
	type: "POST",
	url: "groupe_utilisateur/ajout_groupe_utilisateur.php",
	data: "groupe_utilisateur="+$("#groupe_utilisateur").val()+"&role_groupe_utilisateur="+$("#role_groupe_utilisateur").val()+"&membre="+$("#membre").val(),
	beforeSend: function(){
		$("div.msg_erreur").hide();
		$("div.load").show();
				},
	success: function(msg){	
		if(msg==1)
		{
			$("div.load").hide();
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce groupe d'utilisateurs existe d&eacute;j&agrave; !").show();
		}
		else
		{
		$('#myModal_groupe_utilisateur').modal('toggle');
						 $("div.load").hide();
		 				 $("div.msg_erreur").hide(); 
						 $(".modal_body").html("<h3>Ajout r&eacute;ussi !</h3>");
						 $("#groupe_utilisateur").val();
						 $("#role_groupe_utilisateur").val();
						 $("#membre").val();
			 change_page_groupe_utilisateur('0');
		}
	}
});

}
	 return false;
}); 


$(".edit_groupe_utilisateur").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "groupe_utilisateur/form_modifier_groupe_utilisateur.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_groupe_utilisateur_mod").html(msg);
$("#myModal_groupe_utilisateur_mod").modal('show');	
}
});

});



$('#form_groupe_utilisateur_mod').live('submit',function(){	

	$.ajax({
	type: "POST",
	url: "groupe_utilisateur/modif_groupe_utilisateur.php",
	data: "groupe_utilisateur_mod="+$("#groupe_utilisateur_mod").val()+"&role_groupe_utilisateur_mod="+$("#role_groupe_utilisateur_mod").val()+"&membre="+$("#membre").val(),
	success: function(msg){
 if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce groupe d'utilisateurs existe deja !").show();
		}
		else
		{
		 $('#myModal_groupe_utilisateur_mod').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#groupe_utilisateur_mod").val('');
						 $("#role_groupe_utilisateur_mod").val();
						 $("#membre").val();
			 change_page_groupe_utilisateur('0');
		 /*location.reload(); */
		}
	}
});

	 return false;
});

$(".delete_type_armoire").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "type_armoire/form_supprimer_type_armoire.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_type_armoire_sup").html(msg);
$("#myModal_type_armoire_sup").modal('show');	
}
});

});

$('#submit_type_armoire_sup').live('click',function(){
							
	$.ajax({
	type: "POST",
	url: "type_armoire/sup_type_armoire.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
 $("div.msg_erreur").html("Impossible de supprimer ce type d'armoire car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
	 $('#myModal_type_armoire_sup').modal('toggle');
		$("div.msg_erreur").hide(); 
						$(".clo_er").hide(); 
		change_page_type_armoire('0');
		/*location.reload(); */
		}
	}
});
	 return false;
}); 

/**fin groupe d'utilisateurs**/


/**type fichier**/

$('#form_type_fichier').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "type_fichier/ajout_type_fichier.php",
	data: "type_fichier="+$("#type_fichier").val(),
	success: function(msg){
		
		if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce type de fichier existe deja !").show();
		}
		else
		{
		 $('#myModal_type_fichier').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#type_fichier").val('');
			 change_page_type_fichier('0');
		 /*location.reload(); */
		}
	}
});
	
	 return false;
}); 


$(".edit_type_fichier").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "type_fichier/form_modifier_type_fichier.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_type_fichier_mod").html(msg);
$("#myModal_type_fichier_mod").modal('show');	
}
});

});



$('#form_type_fichier_mod').live('submit',function(){	

	$.ajax({
	type: "POST",
	url: "type_fichier/modif_type_fichier.php",
	data: "type_fichier_mod="+$("#type_fichier_mod").val(),
	success: function(msg){
 if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce type de fichier existe d&eacute;ja !").show();
		}
		else
		{
		 $('#myModal_type_fichier_mod').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#type_fichier_mod").val('');
			 change_page_type_fichier('0');
		 /*location.reload(); */
		}
	}
});

	 return false;
});

$(".delete_type_fichier").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "type_fichier/form_supprimer_type_fichier.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_type_fichier_sup").html(msg);
$("#myModal_type_fichier_sup").modal('show');	
}
});

});

$('#submit_type_fichier_sup').live('click',function(){
							
	$.ajax({
	type: "POST",
	url: "type_fichier/sup_type_fichier.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
 $("div.msg_erreur").html("Impossible de supprimer ce type de fichier car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
	 $('#myModal_type_fichier_sup').modal('toggle');
		$("div.msg_erreur").hide(); 
						$(".clo_er").hide(); 
		change_page_type_fichier('0');
		/*location.reload(); */
		}
	}
});
	 return false;
}); 

/**fin Type fichier**/


/**Role**/

//ajout
$('#form_role').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "role/ajout_role.php",
	data: "role="+$("#role").val(),
	success: function(msg){
		
		if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce r&ocirc;le existe deja !").show();
		}
		else
		{
		 $('#myModal_role').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#role").val('');
			 change_page_role('0');
		 /*location.reload(); */
		}
	}
});
	
	 return false;
}); 

//modif
$(".edit_role").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "role/form_modifier_role.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_role_mod").html(msg);
$("#myModal_role_mod").modal('show');	
}
});

});

$('#form_role_mod').live('submit',function(){	

	$.ajax({
	type: "POST",
	url: "role/modif_role.php",
	data: "role_mod="+$("#role_mod").val(),
	success: function(msg){
 if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce r&ocirc;le existe d&eacute;ja !").show();
		}
		else
		{
		 $('#myModal_role_mod').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#role_mod").val('');
			 change_page_role('0');
		 /*location.reload(); */
		}
	}
});

	 return false;
});

//sup
$(".delete_role").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "role/form_supprimer_role.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_role_sup").html(msg);
$("#myModal_role_sup").modal('show');	
}
});

});

$('#submit_role_sup').live('click',function(){
							
	$.ajax({
	type: "POST",
	url: "role/sup_role.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
 $("div.msg_erreur").html("Impossible de supprimer ce r&ocirc;le car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
	 $('#myModal_role_sup').modal('toggle');
		$("div.msg_erreur").hide(); 
						$(".clo_er").hide(); 
		change_page_role('0');
		/*location.reload(); */
		}
	}
});
	 return false;
}); 


//Definir privilege
$(".privilege_role").live('click', function() {
	var id_ref = $(this).attr('data-id');
	$.ajax({
	type: "GET",
	url: "role/form_privilege_role.php",
	data: "ref="+id_ref,
	success: function(msg){
	$("#affiche_privilege_role").html(msg);
	$("#myModal_privilege_role").modal('show');	
	}
	});
	
	});
	
	$('#privilege_role').live('submit',function(){
						
		//var privileges=$(this).serialize();

		var lecture=0;
		var edition=0;
		var suppression=0;
		var creation=0;

		if($('#lecture').prop('checked')){
			var lecture=1;
			alert('Lecture vaut => '+lecture);
		}
		else
		{
			alert('Lecture vaut => '+lecture);
		}

		if($('#edition').prop('checked')){
			var edition=1;
			alert('edition vaut => '+edition);
		}
		else
		{
			alert('edition vaut => '+edition);
		}

		if($('#suppression').prop('checked')){
			var suppression=1;
			alert('suppression vaut => '+suppression);
		}
		{
			alert('suppression vaut => '+suppression);
		}

		if($('#creation').prop('checked')){
			var creation=1;
			alert('Cr&eacute;ation vaut => '+creation);
		}
		{
			alert('Cr&eacute;ation vaut => '+creation);
		}

		$.ajax({
		type: "POST",
		url: "role/ajout_privilege_role.php",
		data: "lecture="+lecture+"&edition="+edition+"&suppression="+suppression+"&creation="+creation,
		beforeSend: function(){
		//	$("div.msg_erreur").hide();
		//	$("div.load").show();
		$("#affiche_privilege_role").html("<h3>Param&eacute;trage r&eacute;ussi !</h3>");
					},
		success: function(msg){
			$("#myModal_privilege_role").modal('toggle');	
			change_page_role('0');
		}
	});
		 return false;
	}); 


/**fin role**/

/**etagere**/

$('#form_etagere').live('submit',function(){	
			
	$.ajax({
	type: "POST",
	url: "etagere/ajout_etagere.php",
	data: "etagere="+$("#etagere").val()+"&id_armoire="+$("#id_armoire").val(),
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Une etagere similaire existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_etagere').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#etagere").val('');
			 $("#id_armoire").val('');
			// $('input:checkbox[name=af_org]')[0].checked = false;
			 change_page_etagere('0');
			 /*location.reload(); */
		}
	}
 });
	
 return false;
}); 


$(".edit_etagere").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "etagere/form_modifier_etagere.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_etagere_mod").html(msg);
$("#myModal_etagere_mod").modal('show');	
}
});

});



$('#form_etagere_mod').live('submit',function(){	

$.ajax({
	type: "POST",
	url: "etagere/modif_etagere.php",
	data: "etagere_mod="+$("#etagere_mod").val()+"&id_armoire_mod="+$("#id_armoire_mod").val(),
	success: function(msg){
	 if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Cette &eacute;tag&egrave;re existe d&eacute;j&agrave; !").show();
		}
		else
		{
			 $('#myModal_etagere_mod').modal('toggle');
			 $("div.msg_erreur").hide(); 
			 $("#etagere_mod").val('');
			// $('input:checkbox[name=af_org_mod]')[0].checked = false;
			 change_page_etagere('0');
			 /*location.reload(); */
		}
	}
 });

 return false;
});

$(".delete_etagere").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "etagere/form_supprimer_etagere.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_etagere_sup").html(msg);
$("#myModal_etagere_sup").modal('show');	
}
});

});

$('#submit_etagere_sup').live('click',function(){
								
$.ajax({
	type: "POST",
	url: "etagere/sup_etagere.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	 $("div.msg_erreur").html("Impossible de supprimer cette &eacute;tag&egrave;re car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
		 $('#myModal_etagere_sup').modal('toggle');
			$("div.msg_erreur").hide(); 
			$(".clo_er").hide(); 
			change_page_etagere('0');
			/*location.reload(); */
		}
	}
 });
 return false;
}); 

/**fin etagere**/

/**armoire**/

$('#form_armoire').live('submit',function(){	
			
			$.ajax({
			type: "POST",
			url: "armoire/ajout_armoire.php",
			data: "armoire="+$("#armoire").val()+"&id_type_armoire="+$("#id_type_armoire").val(),
			success: function(msg){
				
				if(msg==1)
				{
			 $("div.msg_erreur").addClass("red"); 
			 $("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Une armoire du m&ecirc;me nom existe d&eacute;j&agrave; !").show();
				}
				else
				{
					 $('#myModal_armoire').modal('toggle');
					 $("div.msg_erreur").hide(); 
					 $("#armoire").val('');
					 $("#id_type_armoire").val('');
					// $('input:checkbox[name=af_org]')[0].checked = false;
					 change_page_armoire('0');
					 /*location.reload(); */
				}
			}
		 });
			
		 return false;
	 }); 
 
 
 $(".edit_armoire").live('click', function() {
	 var id_ref = $(this).attr('data-id');
	 
	 $.ajax({
	  type: "GET",
	  url: "armoire/form_modifier_armoire.php",
	  data: "ref="+id_ref,
	  success: function(msg){
		$("#affiche_armoire_mod").html(msg);
		$("#myModal_armoire_mod").modal('show');	
	  }
	});
	 
  });
 
 
 
  $('#form_armoire_mod').live('submit',function(){	

		$.ajax({
			type: "POST",
			url: "armoire/modif_armoire.php",
			data: "armoire_mod="+$("#armoire_mod").val()+"&id_type_armoire_mod="+$("#id_type_armoire_mod").val(),
			success: function(msg){
			 if(msg==1)
				{
			 $("div.msg_erreur").addClass("red"); 
			 $("div.msg_erreur").removeClass("green");
			$("div.msg_erreur").html("Cette armoire existe d&eacute;j&agrave; !").show();
				}
				else
				{
					 $('#myModal_armoire_mod').modal('toggle');
					 $("div.msg_erreur").hide(); 
					 $("#armoire_mod").val('');
					// $('input:checkbox[name=af_org_mod]')[0].checked = false;
					 change_page_armoire('0');
					 /*location.reload(); */
				}
			}
		 });
	 
		 return false;
	 });
  
  $(".delete_armoire").live('click', function() {
	 var id_ref = $(this).attr('data-id');
	 $.ajax({
	  type: "GET",
	  url: "armoire/form_supprimer_armoire.php",
	  data: "ref="+id_ref,
	  success: function(msg){
		$("#affiche_armoire_sup").html(msg);
		$("#myModal_armoire_sup").modal('show');	
	  }
	});
	 
  });
	 
  $('#submit_armoire_sup').live('click',function(){
									  
		$.ajax({
			type: "POST",
			url: "armoire/sup_armoire.php",
			success: function(msg){
				
				if(msg==1)
				{
			 $("div.msg_erreur").addClass("red"); 
			 $("div.msg_erreur").removeClass("green");
		   $("div.msg_erreur").html("Impossible de supprimer cette armoire car des enregistrements lui sont rattach&eacute;s !").show();
				}
				else
				{
				 $('#myModal_armoire_sup').modal('toggle');
				  $("div.msg_erreur").hide(); 
				  $(".clo_er").hide(); 
				  change_page_armoire('0');
				  /*location.reload(); */
				}
			}
		 });
		 return false;
	 }); 
  
	/**fin armoire**/
	
	/**service**/

$('#form_service').live('submit',function(){		 
   	
	$.ajax({
	type: "POST",
	url: "service/ajout_service.php",
	data: "service="+$("#service").val(),
	success: function(msg){
		
		if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce service existe deja !").show();
		}
		else
		{
		 $('#myModal_service').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#service").val('');
			 change_page_service('0');
		 /*location.reload(); */
		}
	}
});
	
	 return false;
}); 


$(".edit_service").live('click', function() {
var id_ref = $(this).attr('data-id');

$.ajax({
type: "GET",
url: "service/form_modifier_service.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_service_mod").html(msg);
$("#myModal_service_mod").modal('show');	
}
});

});



$('#form_service_mod').live('submit',function(){	

	$.ajax({
	type: "POST",
	url: "service/modif_service.php",
	data: "service_mod="+$("#service_mod").val(),
	success: function(msg){
 if(msg==1)
		{
 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
	$("div.msg_erreur").html("Ce type d'armoire existe deja !").show();
		}
		else
		{
		 $('#myModal_service_mod').modal('toggle');
		 $("div.msg_erreur").hide(); 
						 $("#service_mod").val('');
			 change_page_service('0');
		 /*location.reload(); */
		}
	}
});

	 return false;
});

$(".delete_service").live('click', function() {
var id_ref = $(this).attr('data-id');
$.ajax({
type: "GET",
url: "service/form_supprimer_service.php",
data: "ref="+id_ref,
success: function(msg){
$("#affiche_service_sup").html(msg);
$("#myModal_service_sup").modal('show');	
}
});

});

$('#submit_service_sup').live('click',function(){
							
	$.ajax({
	type: "POST",
	url: "service/sup_service.php",
	success: function(msg){
		
		if(msg==1)
		{
	 $("div.msg_erreur").addClass("red"); 
	 $("div.msg_erreur").removeClass("green");
 $("div.msg_erreur").html("Impossible de supprimer ce type d'armoire car des enregistrements lui sont rattach&eacute;s !").show();
		}
		else
		{
	 $('#myModal_service_sup').modal('toggle');
		$("div.msg_erreur").hide(); 
						$(".clo_er").hide(); 
		change_page_service('0');
		/*location.reload(); */
		}
	}
});
	 return false;
}); 

/**fin service**/
					 				
change_page_type_armoire('0');
change_page_type_fichier('0');
change_page_role('0');
change_page_privilege('0');
change_page_service('0');
change_page_armoire('0');
change_page_etagere('0');
change_page_groupe_utilisateur('0');
//change_page_departement('0');
//change_page_section('0');
//change_page_cellule('0');

 $('#recher_type_armoire').on( 'keyup', function() {
	     change_page_type_armoire('0');
       });

 $('#recher_type_fichier').on( 'keyup', function() {
				change_page_type_fichier('0');
				});			 
	
	$('#recher_role').on( 'keyup', function() {
					change_page_role('0');
					});		

	$('#recher_privilege').on( 'keyup', function() {
					change_page_privilege('0');
					});		

	$('#recher_service').on( 'keyup', function() {
			change_page_service('0');
			});
	 
	
  $('#recher_armoire').on( 'keyup', function() {
	     change_page_armoire('0');
			 });

  $('#recher_etagere').on( 'keyup', function() {
	     change_page_etagere('0');
			 });
	
	$('#recher_groupe_utilisateur').on( 'keyup', function() {
			change_page_groupe_utilisateur('0');
			});
/* 
 $('#recher_departement').on( 'keyup', function() {
	     change_page_departement('0');
       });
 
$('#recher_section').on( 'keyup', function() {
	     change_page_section('0');
       });

$('#recher_cellule').on( 'keyup', function() {
	     change_page_cellule('0');
       });
	 
*/
 });

function change_page_type_armoire(page_id){
	 
	 var recher_type_armoire=$("#recher_type_armoire").val();
     var dataString = 'page_id='+ page_id +'&recher_type_armoire='+recher_type_armoire;
     $.ajax({
           type: "GET",
           url: "type_armoire/charge_type_armoire.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_type_armoire").html(result);
		   }
      });
}

function change_page_type_fichier(page_id){
	 
	var recher_type_fichier=$("#recher_type_fichier").val();
		var dataString = 'page_id='+ page_id +'&recher_type_fichier='+recher_type_fichier;
		$.ajax({
					type: "GET",
					url: "type_fichier/charge_type_fichier.php",
					data: dataString,
					cache: false,
					success: function(result){
		 $(".aff_type_fichier").html(result);
			}
		 });
}

function change_page_role(page_id){
	 
	var recher_role=$("#recher_role").val();
		var dataString = 'page_id='+ page_id +'&recher_role='+recher_role;
		$.ajax({
					type: "GET",
					url: "role/charge_role.php",
					data: dataString,
					cache: false,
					success: function(result){
		 $(".aff_role").html(result);
			}
		 });
}

function change_page_privilege(page_id){
	 
	var recher_privilege=$("#recher_privilege").val();
		var dataString = 'page_id='+ page_id +'&recher_privilege='+recher_privilege;
		$.ajax({
					type: "GET",
					url: "privilege/charge_privilege.php",
					data: dataString,
					cache: false,
					success: function(result){
		 $(".aff_privilege").html(result);
			}
		 });
}



function change_page_service(page){
	var recher_service=$("#recher_service").val();
	var dataString = 'page='+ page +'&recher_service='+recher_service;
	$.ajax({
				type: "GET",
				url: "service/charge_service.php",
				data: dataString,
				cache: false,
				success: function(result){
	 $(".aff_service").html(result);
		}
	 });
}

function change_page_armoire(page_id){
	 
	 var recher_armoire=$("#recher_armoire").val();
     var dataString = 'page_id='+ page_id +'&recher_armoire='+recher_armoire;
     $.ajax({
           type: "GET",
           url: "armoire/charge_armoire.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_armoire").html(result);
		   }
      });
}

function change_page_etagere(page_id){
	 
	 var recher_etagere=$("#recher_etagere").val();
     var dataString = 'page_id='+ page_id +'&recher_etagere='+recher_etagere;
     $.ajax({
           type: "GET",
           url: "etagere/charge_etagere.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_etagere").html(result);
		   }
      });
}

function change_page_groupe_utilisateur(page){
     var recher_groupe_utilisateur=$("#recher_groupe_utilisateur").val();
     var dataString = 'page='+ page +'&recher_groupe_utilisateur='+ recher_groupe_utilisateur;
     $.ajax({
           type: "GET",
           url: "groupe_utilisateur/charge_groupe_utilisateur.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_groupe_utilisateur").html(result);
		   }
      });
}
/*
function change_page_section(page){
     var recher_secti=$("#recher_section").val();
     var dataString = 'page='+ page +'&recher_sect='+ recher_secti;
     $.ajax({
           type: "GET",
           url: "section/charge_section.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_section").html(result);
		   }
      });
}

function change_page_cellule(page){
     var recher_cellu=$("#recher_cellule").val();
     var dataString = 'page='+ page +'&recher_cel='+ recher_cellu;
     $.ajax({
           type: "GET",
           url: "cellule/charge_cellule.php",
           data: dataString,
           cache: false,
           success: function(result){
		  $(".aff_cellule").html(result);
		   }
      });
}
*/
