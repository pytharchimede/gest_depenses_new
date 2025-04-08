<?php
session_start();
include('../../../connex.php');

$lib_affectation=addslashes($_POST['lib_affectation']);

$date=date("Y-m-d H:i:s");

$sqlQuery 	= $con->query("SELECT * FROM affectation WHERE lib_affectation='".$lib_affectation."' ");
$count  	= $sqlQuery->rowCount();



$ser=$con->query('SELECT * FROM affectation');
$ser->execute();
$nser=$ser->rowcount();

$num_affectation='AF0'.$nser;


if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO affectation(lib_affectation, date_creat_affectation, secur_ajout_affectation, num_affectation) VALUES (:A, :B, :C, :D)");
$req->execute(array('A'=>$lib_affectation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$num_affectation));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Création de l'affectation <b>".$lib_affectation."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}

unset($con);

?>