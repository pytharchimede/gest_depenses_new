
   $(document).ready(function(){

	$("#ident").val('');
	$("#pass").val('');
	$("div.error1").hide();
	$("div.load").hide();
	
    $('#form_connexion').live('submit',function(){
		
		if($("#ident").val()=='' || $("#pass").val()=='')
	   {   
	         $("div.error1").html('<img src="images/error.png" style="width:22px; height:22px" />&nbsp; L&rsquo;e-mail ou le Mot de passe n&rsquo;est pas saisi !').show();
				 $("div.error").hide();
				 setTimeout(function() {
 $("div.error1").html('<img src="images/error.png" style="width:22px; height:22px" />&nbsp; L&rsquo;e-mail ou le Mot de passe n&rsquo;est pas saisi !').hide();
				 $("div.error").show();
		}, 3000);
	   }
	   else
	   {
       $.ajax({
		   type: "POST",
		   url: "connexion.php",
		   data: "adres="+$("#ident").val()+"&mot_pass="+$("#pass").val(),
		   success: function(msg){
			    if(msg==2)
				{
				 $("div.error1").html('<img src="images/error.png" style="width:22px; height:22px" />&nbsp; L&rsquo;e-mail ou le Mot de passe n&rsquo;est pas valide !').show();
				 $("div.error").hide();
				 setTimeout(function() {
 $("div.error1").html('<img src="images/error.png" style="width:22px; height:22px" />&nbsp; L&rsquo;e-mail ou le Mot de passe n&rsquo;est pas valide !').hide();
				 $("div.error").show();
		}, 3000);
				}
				else
				{   		
				 $("div.load").show();
                 setTimeout(' window.location.href = "dol/accueil.php"; ',4000);
				 $("div.error1").hide();
				}
				
		   }
		});
	     
	   }
	   
        return false;
		
    });
	
	
 });
   
   

