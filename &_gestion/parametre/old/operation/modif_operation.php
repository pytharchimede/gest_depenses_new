<?php
session_start();
include('../../../connex.php');

$id_operation=$_SESSION['id_operation_mod'];

$lib_operation=addslashes($_POST['lib_operation_mod']);
$chantier_id_operation=addslashes($_POST['chantier_id_operation_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE operation SET lib_operation=:A, date_mod_operation=:B, secur_mod_operation=:C, chantier_id_operation=:D WHERE id_operation=:E");
$req->execute(array('A'=>$lib_operation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$chantier_id_operation, 'E'=>$id_operation));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

if($lib_operation!=$_SESSION['lib_operation_mod'] || $chantier_id_operation!=$_SESSION['chantier_id_operation_mod'])
{
    $lib_trace='Modification effectuee sur operation <b>'.$_SESSION['lib_operation_mod'].'</b> pour le chantier <b>'.$_SESSION['chantier_id_operation_mod'].'</b> <br>';
    if($lib_operation!=$_SESSION['lib_operation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR L'OPERATION) <b>".$_SESSION['lib_operation_mod']."</b> => <b>".$lib_operation."</b> <br>";
    }
    if($chantier_id_operation!=$_SESSION['chantier_id_operation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR LE CHANTIER) <b>".$_SESSION['chantier_id_operation_mod']."</b> => <b>".$chantier_id_operation."</b> ";
    }
}
else
{
    $lib_trace='Aucune modification effectuee sur operation <b>'.$_SESSION['lib_operation_mod'].'</b> pour le chantier <b>'.$_SESSION['chantier_id_operation_mod'].'</b> <br>'; 
}

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_operation_mod']);
unset($_SESSION['chantier_id_operation_mod']);
unset($_SESSION['lib_operation_mod']);

?>