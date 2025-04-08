$(document).ready(function(){ 

	$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').show();
	$("div.voir").hide();

	setTimeout(function() {
	$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').hide();
	$("div.voir").show();
	}, 1500);

	/*
	$("#recher_hist").on("keyup", function() {
		var value = $(this).val().toLowerCase();

		$("#tab_hist tr").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#excel_hist").live("click", function(){
		
		var ret=$("#recher_hist").val();
		$.ajax({
			type: "POST",
			url: "exportation/excel/excel_historique.php",
			data: "ret="+ret,
			success: function(msg){
				$(location).attr('href', 'exportation/excel/excel_historique.php');
			}
		 });
	});
	*/

change_page_historique('0');
 
$('#hist_search').on( 'click', function() {

	var recher_utilisateur=$("#recher_utilisateur").val();
	var recher_historique=$("#recher_historique").val();
	var dp1=$("#dp1").val();
	var dp2=$("#dp2").val();
	var page_id_cons=0;

    var dataString = 'page_id_cons='+ page_id_cons+"&recher_historique="+recher_historique+"&recher_utilisateur="+recher_utilisateur+"&dp1="+dp1+"&dp2="+dp2;
     $.ajax({
           type: "POST",
           url: "historique/charge_historique.php",
           data: dataString,
           cache: false,
           beforeSend: function(result){
		$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').show();
		$(".affiche_historique").hide();
		   },
		   success: function(result){
		$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').hide();
		$(".affiche_historique").html(result).show();
		   }
      });
});	 



});

function change_page_historique(page_id_cons){
	
	var recher_historique=$("#recher_historique").val();
	var recher_utilisateur=$("#recher_utilisateur").val();
	var dp1=$("#dp1").val();
	var dp2=$("#dp2").val();

	var dataString = 'page_id_cons='+ page_id_cons+"&recher_historique="+recher_historique+"&recher_utilisateur="+recher_utilisateur+"&dp1="+dp1+"&dp2="+dp2;
	
     $.ajax({
           type: "POST",
           url: "historique/charge_historique.php",
           data: dataString,
           cache: false,
		   beforeSend: function(result){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').show();
			$(".affiche_historique").hide();
			   },
			   success: function(result){
			$("div.chargement").html('<img src="../../img/giphy.gif" style="width:50px; height:50px;" />').hide();
			$(".affiche_historique").html(result).show();
			   }
      });
}

	

