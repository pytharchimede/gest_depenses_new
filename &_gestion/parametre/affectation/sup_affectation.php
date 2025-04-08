<?php
session_start();

include('../../../connex.php');
$ido=$_SESSION['affectation_sup_code'];


$rem=$con->prepare("SELECT * FROM affectation WHERE id_affectation=:A");
$rem->execute(array('A'=>$ido));
$rofo=$rem->fetch();

$red=$con->prepare("DELETE FROM affectation WHERE id_affectation=:A" ); 
$red->execute(array( 'A'=>$ido));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Suppression de l'affectation <b>".$rofo['lib_affectation']."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($_SESSION['affectation_sup_code']);

unset($con);

?>