$(document).ready(function(){ 

$("div.msg_erreur").hide(); 

$("div.chargement").html('<img src="../../images/loading.gif" style="width:50px; height:50px;" />').show();
$("div.voir").hide();

setTimeout(function() {
$("div.chargement").html('<img src="../../images/loading.gif" style="width:50px; height:50px;" />').hide();
$("div.voir").show();
}, 1500);

$('.button_annul').live('click',function(){
	$("div.msg_erreur").hide(); 
    $(".clo_er").hide(); 
	location.reload();
});

 $('#groupe').on('change', function () {
		var id=$("#groupe").val();
		if(id!='')
		{
		$.ajax({
		   type: "GET",
		   url: "utilisateur/choix_droit.php",
		   data:"cpt_id="+id,
		   success: function(msg){
		   $(".af_choix").html(msg);
		   }
		});
		}
		else
		{
		$(".af_choix").html("");
		}
	});
	

	$('#personnel_id').on('change', function () {
		var id_pers=$("#personnel_id").val();
		$("#utilisateur").val('');
		if(id_pers!='')
		{
		$.ajax({
		   type: "GET",
		   dataType:"json",
		   url: "utilisateur/charge_info_pers.php",
		   data:"personnel_id="+id_pers,
		   success: function(msg){

			$("#utilisateur").val(msg.nom);
			$("#email").val(msg.email);
			$("#tel").val(msg.tel);
			$("#service").val(msg.service);
			$("#site").val(msg.site);
		    $("#fonction").val(msg.fonction);
		   }
		});
		}
		else
		{
			$("div.msg_erreur").html("Veuillez s&eacute;lectionner une personne svp !").show();
		}
	});

	$('.creat_util').live('click', function(){
		$('#myModal_utilisateur').modal('show');
	});
	 $('#form_utilisateur').live('submit',function(){	
	   
	   var email=$("#email").val();
	   var service=$("#service").val();
	   var groupe_uti=$("#groupe").val();
	   var tel=$("#tel").val();
	   var personnel_id=$("#personnel_id").val();
	   var fonction=$("#fonction").val();
	   
	   if(email=="" || service=="" || groupe_uti=="" || personnel_id=="" || fonction=="")
	   {   
		    $("div.msg_erreur").show();
		    $("div.msg_erreur").html("Les champs avec ast&eacute;ristique sont obligatoires !").show();
	   }
	   else
	   {
	    $("div.msg_erreur").hide();
       $.ajax({
		   type: "POST",
		   url: "utilisateur/ajout_utilisateur.php",
		   data: "email="+email+"&service="+service+"&groupe_uti="+groupe_uti+"&tel="+tel+"&personnel_id="+personnel_id+"&fonction="+fonction,
		   //data: "utilisateur="+utilisateur+"&email="+email,
		   success: function(msg){
			   
			    if(msg==1)
				{ 
				 $("div.msg_erreur").show();
		         $("div.msg_erreur").html("Cet utilisateur existe d&eacute;j&agrave; !").show();
				}
				else
				{
				 location.reload(true);
				}
		   }
		});
	   }
	   
        return false;
    });
	 
	$(".edit").live('click', function() {
	var id_ref = $(this).attr('data-id');
	
	$.ajax({
	 type: "GET",
     url: "utilisateur/form_modifier_utilisateur.php",
     data: "ref="+id_ref,
	 success: function(msg){
	   $("#affiche_utilisateur_mod").html(msg);
	   $("#myModal_utilisateur_mod").modal('show');	
	 }
   });
	
 });


$('#form_utilisateur_mod').live('submit',function(){	
	   
	var email=$("#email_mod").val();
	var service=$("#service_mod").val();
	var groupe_uti=$("#demo-chosen-select_").val();
	var tel_personnel_soignant=$("#tel_personnel_soignant_mod").val();
	var personnel_id=$("#demo-chosen-select").val();
	
	if(email=="" || service=="" || groupe_uti=="" || personnel_id=="" )
	{   
		 $("div.msg_erreur").show();
		 $("div.msg_erreur").html("Les champs avec ast&eacute;ristique sont obligatoires !").show();
	}
	else
	{
	 $("div.msg_erreur").hide();
	$.ajax({
		type: "POST",
		url: "utilisateur/modif_utilisateur.php",
		data: "email_mod="+email+"&service_mod="+service+"&groupe_uti_mod="+groupe_uti+"&tel_personnel_soignant_mod="+tel_personnel_soignant+"&personnel_id_mod="+personnel_id,
		success: function(msg){
			
			 if(msg==1)
			 { 
			  $("div.msg_erreur").show();
			  $("div.msg_erreur").html("Cet utilisateur existe d&eacute;j&agrave; !").show();
			 }
			 else
			 {
			  location.reload(true);
			 }
		}
	 });
	}
	
	 return false;
    });
	 
$(".valide").live('click', function() {
	var id_ref = $(this).attr('data-id');
	$.ajax({
	 type: "GET",
     url: "utilisateur/valide.php",
     data: "ref="+id_ref,
	 success: function(msg){
	   
	           if(msg==1)
			   {
	             $("div.msg_valide").html('<span class="orange">Compte utilisateur d&eacute;sactiv&eacute;</span>').show();
				  setTimeout(function() {
                 $("div.msg_valide").hide();
				  location.reload(true); 
		         }, 2000);
			   }
			   else
			   {
				$("div.msg_valide").html('<span class="vert">Compte utilisateur activ&eacute;</span>').show();
				  setTimeout(function() {
                 $("div.msg_valide").hide();
				  location.reload(true); 
		         }, 2000); 
			   }		  
	 }
   });
	
 });


  $(".delete").live('click', function() {
	var id_ref = $(this).attr('data-id');
	$.ajax({
	 type: "GET",
     url: "utilisateur/form_supprimer_utilisateur.php",
     data: "ref="+id_ref,
	 success: function(msg){
	   $("#affiche_utilisateur_sup").html(msg);
	   $("#myModal_utilisateur_sup").modal('show');	
	 }
   });
	
 });
	
 $('#submit_utilisateur_sup').live('click',function(){
									 
       $.ajax({
		   type: "POST",
		   url: "utilisateur/sup_utilisateur.php",
		   success: function(msg){
			   
			  $("div.msg_valide").html('<span class="rouge">Compte utilisateur supprim&eacute;</span>').show();
				  setTimeout(function() {
                 $("div.msg_valide").hide();
				  location.reload(true); 
		         }, 2000); 
		   }
		});
        return false;
	}); 

	change_page_utilisateur('0');
	
//Recherche utilisateur
$("#search_util").live('click',function(){		 
	   
	var recher_utilisateur=$("#recher_utilisateur").val();
	var recher_groupe=$("#recher_groupe").val();
	var recher_service=$("#recher_service").val();
	var recher_statut=$("#recher_statut").val();
	var page_id_cons=0;

    var dataString = 'page_id_cons='+ page_id_cons+"&recher_utilisateur="+recher_utilisateur+"&recher_groupe="+recher_groupe+"&recher_service="+recher_service+"&recher_statut="+recher_statut;
	
	$.ajax({
		type: "POST",
		url: "utilisateur/charge_utilisateur.php",
		data: dataString,
		cache: false,
		beforeSend: function(){
            $("div.chargement").html('<img src="../../images/loading.gif" style="width:50px; height:50px;" />').show();
            $(".aff_utilisateur").hide();
            },
           success: function(result){
		  $("div.chargement").html('<img src="../../images/loading.gif" style="width:50px; height:50px;" />').hide();
		  $(".aff_utilisateur").html(result).show();
		   }
   });
   
	   return false;
});


 
});


function change_page_utilisateur(page_id_cons){
	
	var recher_utilisateur='';
	var recher_groupe='';
	var recher_statut='';

    var dataString = 'page_id_cons='+ page_id_cons+"&recher_utilisateur="+recher_utilisateur+"&recher_groupe="+recher_groupe+"&recher_statut="+recher_statut;
	//alert(dataString);
	$.ajax({
           type: "POST",
           url: "utilisateur/charge_utilisateur.php",
           data: dataString,
           cache: false,
           success: function(result){
			$("div.chargement").html('<img src="../../images/loading.gif" style="width:50px; height:50px;" />').hide();
			$(".aff_utilisateur").html(result).show();
		   }
      });
}