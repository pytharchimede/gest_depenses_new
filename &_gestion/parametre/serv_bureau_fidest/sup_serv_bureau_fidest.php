<?php
session_start();

include('../../../connex.php');
$ido=$_SESSION['serv_bureau_fidest_sup_code'];


$rem=$con->prepare("SELECT * FROM serv_bureau_fidest WHERE id_serv_bureau_fidest=:A");
$rem->execute(array('A'=>$ido));
$rofo=$rem->fetch();

$red=$con->prepare("DELETE FROM serv_bureau_fidest WHERE id_serv_bureau_fidest=:A" ); 
$red->execute(array( 'A'=>$ido));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Suppression de l'serv_bureau_fidest <b>".$rofo['lib_serv_bureau_fidest']."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($_SESSION['serv_bureau_fidest_sup_code']);

unset($con);

?>