<?php
session_start();
include('../../../connex.php');

$id_serv_bureau_fidest=$_SESSION['id_serv_bureau_fidest_mod'];

$lib_serv_bureau_fidest=addslashes($_POST['lib_serv_bureau_fidest_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE serv_bureau_fidest SET lib_serv_bureau_fidest=:A, date_mod_serv_bureau_fidest=:B, secur_mod_serv_bureau_fidest=:C WHERE id_serv_bureau_fidest=:D");
$req->execute(array('A'=>$lib_serv_bureau_fidest, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$id_serv_bureau_fidest));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Modification serv_bureau_fidest <b>".$_SESSION['lib_serv_bureau_fidest_mod']."</b> en <b>".$lib_serv_bureau_fidest."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_serv_bureau_fidest_mod']);

?>