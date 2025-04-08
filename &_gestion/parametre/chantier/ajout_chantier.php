<?php
session_start();
include('../../../connex.php');

$lib_chantier=addslashes($_POST['lib_chantier']);
$cout_total_chantier=addslashes($_POST['cout_total_chantier']);

$date=date("Y-m-d H:i:s");

$sqlQuery 	= $con->query("SELECT * FROM chantier WHERE lib_chantier='".$lib_chantier."' ");
$count  	= $sqlQuery->rowCount();



$ser=$con->query('SELECT * FROM chantier');
$ser->execute();
$nser=$ser->rowcount();

$num_chantier='CH0'.$nser;


if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO chantier(lib_chantier, date_creat_chantier, secur_ajout_chantier, num_chantier, cout_total_chantier) VALUES (:A, :B, :C, :D, :E)");
$req->execute(array('A'=>$lib_chantier, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$num_chantier, 'E'=>$cout_total_chantier));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Création du chantier <b>".$lib_chantier."</b> facture au montant <b>".$cout_total_chantier."</b>  ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}

unset($con);

?>