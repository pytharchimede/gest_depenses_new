$(document).ready(function(){ 

	$("div.div_load").hide(); 
	$("div.msg_erreur").hide();
	$("div.msg_ok").hide();
	
	$(function () {
	   // A chaque sélection de fichier
	   $('#form_photo').find('input[name="photo"]').on('change', function (e) {
		   var files = $(this)[0].files;
	
		   if (files.length > 0) {
			   // On part du principe qu'il n'y qu'un seul fichier
			   // étant donné que l'on a pas renseigné l'attribut "multiple"
			   var file = files[0],
				   $image_preview = $('#image_preview');
	
			   // Ici on injecte les informations recoltées sur le fichier pour l'utilisateur
			   $image_preview.find('.thumbnail').removeClass('hidden');
			   $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
		   }
	   });
   });
   
   
		
		$('#form_mot').live('submit',function(){	
											  
		   $("div.div_load").show();
		   $("#confirm").hide();
	   
		  if($("#mot_new").val()!=$("#mot_conf").val())
		  {   
			   $("div.div_load").hide(); 
			   $("div.msg_erreur").show();
			   $("div.msg_erreur").addClass("red"); 
			   $("div.msg_erreur").removeClass("green");
			   $("div.msg_erreur").html("Les nouveaux mots de passe ne sont pas identiques !").show();
			   $("#conf_mot").focus();
			   $("div.div_load").hide();
			   $("#confirm").show();
			   setTimeout(function() { $("div.msg_erreur").hide(); }, 3500);
		  }
		  else
		  {
		   $("div.msg_erreur").hide();
		  $.ajax({
			  type: "POST",
			  url: "modif_passe.php",
			  data: "mot_actuel="+$("#mot_actu").val()+"&new_mot="+$("#mot_new").val()+"&conf_mot="+$("#mot_conf").val(),
			  success: function(msg){
				  
				   if(msg==1)
				   { 
				   $("div.msg_erreur").show();
					$("div.msg_erreur").addClass("red"); 
					$("div.msg_erreur").removeClass("green");
					$("div.msg_erreur").html("Le mot de passe actuel n'est pas valide !").show();
					
					setTimeout(function() { 
					$("div.msg_erreur").hide();
					$("#mot_actu").focus();
					$("div.div_load").hide();
					$("#confirm").show();
				   }, 3500);
				   }
				   else
				   {
					
					setTimeout(function() { 
					$("div.msg_ok").show();
					$("div.msg_ok").html("Le mot de passe a &eacute;t&eacute; modifi&eacute; avec succ&egrave;s !").show();
					$("#mot_actu").val('');
					$("#mot_new").val('');
					$("#mot_conf").val('');
					$("div.div_load").hide();
					$("#confirm").show();
				   }, 3500);
					
					 setTimeout(function() { 
					$("div.msg_ok").hide();
				   }, 6500);
							 
				   }
			   
			  }
		   });
		  }
		  
		   return false;
	   });
		
		
		
		
		 $('#form_photo').live('submit',function(){					  
			  $.ajax({
			  type: "POST",
			  url: "ajout_photo.php",
			  dataType: 'text', 
			  cache: false,
			  contentType: false,
			  processData: false, 
			  data: new FormData(this),
			  success: function(msg){	  
			  location.reload(true); 
			  }
			 });
			return false;
		 });

		
			
   
   });
   
   $(function () {
	   // A chaque sélection de fichier
	   $('#form_photo').find('input[id="photo"]').on('change', function (e) {
	   
		   var files = $(this)[0].files;
	
		   if (files.length > 0 ) {
		   
			   var file = files[0],
				   $image_preview = $('#user_image');
				   $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
			 }
	   });
	   });
   