<?php
session_start();
include('../../../connex.php');

$lib_serv_log=addslashes($_POST['lib_serv_log']);

$date=date("Y-m-d H:i:s");

$sqlQuery 	= $con->query("SELECT * FROM serv_log WHERE lib_serv_log='".$lib_serv_log."' ");
$count  	= $sqlQuery->rowCount();



$ser=$con->query('SELECT * FROM serv_log');
$ser->execute();
$nser=$ser->rowcount();

$num_serv_log='AF0'.$nser;


if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO serv_log(lib_serv_log, date_creat_serv_log, secur_ajout_serv_log, num_serv_log) VALUES (:A, :B, :C, :D)");
$req->execute(array('A'=>$lib_serv_log, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$num_serv_log));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Création de l'serv_log <b>".$lib_serv_log."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}

unset($con);

?>