
$(document).ready(function(){ 

$("div.load").html('<img src="img/MnyxU.gif" style="width:65px; height:65px;" />').show();
$("div.affiche").hide();
setTimeout(function() {
$("div.load").html('<img src="img/MnyxU.gif" style="width:65px; height:65px;" />').hide();
$("div.affiche").show();
}, 500);

});

setInterval(function(){
    $('.donnee_reference').load('reference/charge_comp_reference.php').fadeIn("slow");
  }, 1000);
  
  setInterval(function(){
    $('.donnee_parole').load('mot_dir/charge_comp_mot.php').fadeIn("slow");
  }, 1000);
setInterval(function(){
    $('.donnee_actualite').load('actualite/charge_comp_actualite.php').fadeIn("slow");
  }, 1000);
setInterval(function(){
    $('.donnee_photo').load('photo/charge_comp_photo.php').fadeIn("slow");
  }, 1000);
setInterval(function(){
    $('.donnee_video').load('video/charge_comp_video.php').fadeIn("slow");
  }, 1000);
setInterval(function(){
    $('.donnee_demande_emploi').load('demande_emploi/charge_comp_demande_emploi.php').fadeIn("slow");
  }, 1000);
setInterval(function(){
    $('.donnee_flash').load('flash/charge_comp_flash.php').fadeIn("slow");
  }, 1000);