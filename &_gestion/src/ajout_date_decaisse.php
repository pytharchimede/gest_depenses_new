<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

$num_fiche=$_SESSION['num_fiche'];
$date_decaissement=$_GET['date_decaissement'];

//Mettre à jour si déjà existant
$req=$con->prepare('UPDATE fiche SET date_decaissement=:A WHERE num_fiche=:B');
$req->execute(array('A'=>$date_decaissement, 'B'=>$num_fiche));


//traçabilité
$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;
$date_trace=gmdate('Y-m-d H:i:s');

$lib_trace="Planification du decaissement de la fiche  N° <b>".$num_fiche."</b> au <b>".$date_decaissement."</b>  <br> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_trace, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['num_fiche']);

header('Location: ../accepte.php');
?>

