<?php
session_start();
include('../../../connex.php');

$id_serv_log=$_SESSION['id_serv_log_mod'];

$lib_serv_log=addslashes($_POST['lib_serv_log_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE serv_log SET lib_serv_log=:A, date_mod_serv_log=:B, secur_mod_serv_log=:C WHERE id_serv_log=:D");
$req->execute(array('A'=>$lib_serv_log, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$id_serv_log));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Modification serv_log <b>".$_SESSION['lib_serv_log_mod']."</b> en <b>".$lib_serv_log."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_serv_log_mod']);

?>