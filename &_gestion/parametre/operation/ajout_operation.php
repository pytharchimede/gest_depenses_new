<?php
session_start();
include('../../../connex.php');

$lib_operation=addslashes($_POST['lib_operation']);
$chantier_id_operation=addslashes($_POST['chantier_id_operation']);

$date=date("Y-m-d H:i:s");

$sqlQuery 	= $con->query("SELECT * FROM operation WHERE lib_operation='".$lib_operation."' AND chantier_id_operation='".$chantier_id_operation."' ");
$count  	= $sqlQuery->rowCount();



$ser=$con->query('SELECT * FROM operation');
$ser->execute();
$nser=$ser->rowcount();

$num_operation='CH0'.$nser;


if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO operation(lib_operation, date_creat_operation, secur_ajout_operation, num_operation, chantier_id_operation) VALUES (:A, :B, :C, :D, :E)");
$req->execute(array('A'=>$lib_operation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$num_operation, 'E'=>$chantier_id_operation));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Création de l'operation <b>".$lib_operation."</b> pour le chantier N° <b>".$chantier_id_operation."</b> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}

unset($con);

?>