<?php
session_start();
include('../../../connex.php');

$id_affectation=$_SESSION['id_affectation_mod'];

$lib_affectation=addslashes($_POST['lib_affectation_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE affectation SET lib_affectation=:A, date_mod_affectation=:B, secur_mod_affectation=:C WHERE id_affectation=:D");
$req->execute(array('A'=>$lib_affectation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$id_affectation));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Modification affectation <b>".$_SESSION['lib_affectation_mod']."</b> en <b>".$lib_affectation."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_affectation_mod']);

?>