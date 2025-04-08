<?php
session_start();
include('../../../connex.php');

$id_chantier=$_SESSION['id_chantier_mod'];

$lib_chantier=addslashes($_POST['lib_chantier_mod']);
$cout_total_chantier=addslashes($_POST['cout_total_chantier_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE chantier SET lib_chantier=:A, date_mod_chantier=:B, secur_mod_chantier=:C, cout_total_chantier=:D WHERE id_chantier=:E");
$req->execute(array('A'=>$lib_chantier, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$cout_total_chantier, 'E'=>$id_chantier));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Modification chantier <b>".$_SESSION['lib_chantier_mod']."</b> en <b>".$lib_chantier."</b> <b>".$_SESSION['cout_total_chantier_mod']."</b> en <b>".$cout_total_chantier."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_chantier_mod']);

?>