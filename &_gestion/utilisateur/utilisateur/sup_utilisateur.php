<?php
session_start();

include('../../../connex.php');
$ido=$_SESSION['id_utilisateur_sup'];


$sqlQ=$con->prepare("SELECT * FROM utilisateur LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id INNER JOIN service ON service.id_service=personnel_soignant.service_id INNER JOIN fonction ON fonction.id_fonction=personnel_soignant.fonction_id INNER JOIN groupe_utilisateur ON groupe_utilisateur.id_type_groupe=personnel_soignant.type_groupe_id WHERE id_utilisateur=:A");
$sqlQ->execute(array('A'=>$ido));
$rofo=$sqlQ->fetch();
/*
$red=$con->prepare("UPDATE utilisateur SET statut=:A WHERE id_utilisateur=:B"); 
$red->execute(array( 'A'=>"2", 'B'=>$ido));
*/
$nom_util=$rofo['nom_personnel_soignant'];

$groupe=$rofo['nom_type_groupe'];

if($rofo['ajout_type_groupe']== 1){ $ajout = "Ajouter"; }else{ $ajout = ""; }
if($rofo['modif_type_groupe']==1){ $modif="Modifier"; }else{ $modif=""; }
if($rofo['sup_type_groupe']==1){ $t_sup="Supprimer"; }else{ $t_sup=""; }
if($rofo['config_type_groupe']==1){ $configura = "Configuration"; }else{ $configura=""; }
if($rofo['secur_type_groupe']==1){ $securite = "S&eacute;curit&eacute;"; }else{ $securite=""; }



$red=$con->prepare("DELETE FROM utilisateur WHERE id_utilisateur=:A"); 
$red->execute(array('A'=>$ido));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i:s", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;


$lib_trace="Suppression de l'utilisateur <b>".$nom_util."</b> du groupe utilsateur <b>".$groupe."</b> avec pour droit(s) : <b>".$ajout."</b>-<b>".$modif."</b>-<b>".$t_sup."</b>--<b>".$configura."</b>-<b>".$securite."</b>";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($_SESSION['id_utilisateur_sup']);
unset($con);

?>