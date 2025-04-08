$(document).ready(function(){ 

    $("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').show();
    $("div.affiche_point").hide();
    
    setTimeout(function() {
    $("div.chargement").html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />').hide();
    $("div.affiche_point").show();
    change_page_point('0');
    }, 1500);
    
    
    $("div.msg_erreur").hide(); 
    
    
    
    $('#recher_etat').on('change',function(){
       
        var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
    
        var page_id='0';
    
              var recher_approbation = $("#recher_approbation").val();
    
        var dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    $('#recher_date_debut').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    $('#recher_date_fin').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    $('#recher_motif').on('keyup',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    $('#recher_chantier').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    $('#recher_affectation').on('change',function(){
       
        var recher_etat = $("#recher_etat").val();
            var recher_date_debut = $("#recher_date_debut").val();
            var recher_date_fin = $("#recher_date_fin").val();
            var recher_motif = $("#recher_motif").val();
            var recher_chantier = $("#recher_chantier").val();
            var recher_affectation = $("#recher_affectation").val();
            var recher_demandeur = $("#recher_demandeur").val();
            var recher_serv_log = $("#recher_serv_log").val();
            var recher_serv_rh = $("#recher_serv_rh").val();
            var page_id='0';
                  var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
             $.ajax({
                   type: "POST",
                   url: "src/charge_point.php",
                   data: dataString,
                   cache: false,
                    beforeSend: function(){
                    $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                    $(".affiche_point").hide();
                    },
                   success: function(result){
                  $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
                  $(".affiche_point").html(result).show(); 
                   }
              });
        });
    
        $('#recher_demandeur').on('keyup',function(){
       
                var recher_etat = $("#recher_etat").val();
                var recher_date_debut = $("#recher_date_debut").val();
                var recher_date_fin = $("#recher_date_fin").val();
                var recher_motif = $("#recher_motif").val();
                var recher_chantier = $("#recher_chantier").val();
                var recher_affectation = $("#recher_affectation").val();
                var recher_demandeur = $("#recher_demandeur").val();
                var recher_serv_log = $("#recher_serv_log").val();
                var recher_serv_rh = $("#recher_serv_rh").val();
                var page_id='0';
                      var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
                 $.ajax({
                       type: "POST",
                       url: "src/charge_point.php",
                       data: dataString,
                       cache: false,
                        beforeSend: function(){
                        $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                        $(".affiche_point").hide();
                        },
                       success: function(result){
                      $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
                      $(".affiche_point").html(result).show(); 
                       }
                  });
            });

            $('#recher_approbation').on('change',function(){
       
                  var recher_etat = $("#recher_etat").val();
                  var recher_date_debut = $("#recher_date_debut").val();
                  var recher_date_fin = $("#recher_date_fin").val();
                  var recher_motif = $("#recher_motif").val();
                  var recher_chantier = $("#recher_chantier").val();
                  var recher_affectation = $("#recher_affectation").val();
                  var recher_demandeur = $("#recher_demandeur").val();
                  var recher_serv_log = $("#recher_serv_log").val();
                  var recher_serv_rh = $("#recher_serv_rh").val();
                  var page_id='0';
                        var recher_approbation = $("#recher_approbation").val();
      
           dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
                   $.ajax({
                         type: "POST",
                         url: "src/charge_point.php",
                         data: dataString,
                         cache: false,
                          beforeSend: function(){
                          $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                          $(".affiche_point").hide();
                          },
                         success: function(result){
                        $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
                        $(".affiche_point").html(result).show(); 
                         }
                    });
              });
              
              
               $('#recher_serv_log').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
     $('#recher_serv_rh').on('change',function(){
       
    var recher_etat = $("#recher_etat").val();
        var recher_date_debut = $("#recher_date_debut").val();
        var recher_date_fin = $("#recher_date_fin").val();
        var recher_motif = $("#recher_motif").val();
        var recher_chantier = $("#recher_chantier").val();
        var recher_affectation = $("#recher_affectation").val();
        var recher_demandeur = $("#recher_demandeur").val();
        var recher_serv_log = $("#recher_serv_log").val();
        var recher_serv_rh = $("#recher_serv_rh").val();
        var page_id='0';
              var recher_approbation = $("#recher_approbation").val();
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
                beforeSend: function(){
                $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').show();
                $(".affiche_point").hide();
                },
               success: function(result){
              $("div.chargement").html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />').hide();
              $(".affiche_point").html(result).show(); 
               }
          });
    });
    
    
    
    change_page_point('0');
     
    });
    
    
    function change_page_point(page_id){
      var recher_etat = $("#recher_etat").val();
      var recher_date_debut = $("#recher_date_debut").val();
      var recher_date_fin = $("#recher_date_fin").val();
      var recher_motif = $("#recher_motif").val();
      var recher_chantier = $("#recher_chantier").val();
      var recher_affectation = $("#recher_affectation").val();
      var recher_demandeur = $("#recher_demandeur").val();
      var recher_serv_log = $("#recher_serv_log").val();
      var recher_serv_rh = $("#recher_serv_rh").val();
      var recher_approbation = $("#recher_approbation").val();
      var page_id='0';
    
         dataString = 'page_id='+page_id+'&recher_etat='+recher_etat+'&recher_date_debut='+recher_date_debut+'&recher_date_fin='+recher_date_fin+'&recher_motif='+recher_motif+'&recher_chantier='+recher_chantier+'&recher_affectation='+recher_affectation+'&recher_demandeur='+recher_demandeur+'&recher_approbation='+recher_approbation+'&recher_serv_log='+recher_serv_log+'&recher_serv_rh='+recher_serv_rh;
         $.ajax({
               type: "POST",
               url: "src/charge_point.php",
               data: dataString,
               cache: false,
               success: function(result){
              $(".affiche_point").html(result);
               }
          });
    }
    