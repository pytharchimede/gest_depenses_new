$(document).ready(function(){ 

$("div.msg_erreur").hide(); 


$('.annul_decaisse').live('click', function(){
    $(location).attr('href', 'decaisse.php');
});

$('#montant_decaisser').on('keyup',function(){
   
	var mont_dec = $("#montant_decaisser").val();

     $.ajax({
           type: "POST",
           url: "src/verif_montant_decaisser.php",
           data: 'mont_dec='+mont_dec,
           cache: false,
           success: function(result){
                if(result==0)
                {
                    $("div.msg_erreur").html('<i class="fa fa-exclammation-triangle"></i> Attention ! Dépassement du montant demandé !').show();
                    $('.btn_dec').hide();
                }
                else
                {
                    $("div.msg_erreur").hide(); 
                    $('.btn_dec').show();
                }
		   }
      });
});


$('.submit_decaisse').live('click',function(){
   
	var montant_decaisser = $("#montant_decaisser").val();

     $.ajax({
           type: "POST",
           url: "src/decaisser_fiche.php",
           data: 'montant_decaisser='+montant_decaisser,
           cache: false,
           success: function(msg){
             $(location).attr('href', 'decaisse.php');           
		   }
      });
});



 
});
