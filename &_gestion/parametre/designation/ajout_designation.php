<?php
session_start();
include('../../../connex.php');

$lib_designation=addslashes($_POST['lib_designation']);
$operation_id_designation=addslashes($_POST['operation_id_designation']);
$qte_designation=addslashes($_POST['qte_designation']);
$prix_designation=addslashes($_POST['prix_designation']);
$fourniture_debourse=addslashes($_POST['fourniture_debourse']);
$main_doeuvre_debourse=addslashes($_POST['main_doeuvre_debourse']);
$montant_debourse=addslashes($_POST['montant_debourse']);

$date=date("Y-m-d H:i:s");

$sqlQuery 	= $con->query("SELECT * FROM designation WHERE lib_designation='".$lib_designation."' AND operation_id_designation='".$operation_id_designation."' ");
$count  	= $sqlQuery->rowCount();



$ser=$con->query('SELECT * FROM designation');
$ser->execute();
$nser=$ser->rowcount();

$num_designation='CH0'.$nser;


if($count>0)
{
echo'1';
}
else
{
$req=$con->prepare("INSERT INTO designation(lib_designation, date_creat_designation, secur_ajout_designation, num_designation, operation_id_designation, qte_designation, prix_designation, fourniture_debourse, main_doeuvre_debourse, montant_debourse) VALUES (:A, :B, :C, :D, :E, :F, :G, :H, :I, :J)");
$req->execute(array('A'=>$lib_designation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$num_designation, 'E'=>$operation_id_designation, 'F'=>$qte_designation, 'G'=>$prix_designation, 'H'=>$fourniture_debourse, 'I'=>$main_doeuvre_debourse, 'J'=>$montant_debourse));
echo'0';

$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

$lib_trace="Création de l'designation <b>".$lib_designation."</b> pour le chantier N° <b>".$operation_id_designation."</b> de quantité <b>".$qte_designation."</b> au prix de <b>".$prix_designation."</b> l'unité ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

}

unset($con);

?>