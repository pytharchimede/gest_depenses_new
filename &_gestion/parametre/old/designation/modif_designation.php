<?php
session_start();
include('../../../connex.php');

$id_designation=$_SESSION['id_designation_mod'];

$lib_designation=addslashes($_POST['lib_designation_mod']);
$chantier_id_designation=addslashes($_POST['chantier_id_designation_mod']);
$qte_designation=addslashes($_POST['qte_designation_mod']);
$prix_designation=addslashes($_POST['prix_designation_mod']);

$fourniture_debourse=addslashes($_POST['fourniture_debourse_mod']);
$main_doeuvre_debourse=addslashes($_POST['main_doeuvre_debourse_mod']);
$montant_debourse=addslashes($_POST['montant_debourse_mod']);

$date=date("Y-m-d H:i:s");


$req=$con->prepare("UPDATE designation SET lib_designation=:A, date_mod_designation=:B, secur_mod_designation=:C, chantier_id_designation=:D, qte_designation=:E, prix_designation=:F, fourniture_debourse=:G, main_doeuvre_debourse=:H, montant_debourse=:I WHERE id_designation=:J");
$req->execute(array('A'=>$lib_designation, 'B'=>$date, 'C'=>$_SESSION['secur_hop'], 'D'=>$chantier_id_designation, 'E'=>$qte_designation, 'F'=>$prix_designation, 'G'=>$fourniture_debourse, 'H'=>$main_doeuvre_debourse, 'I'=>$montant_debourse, 'J'=>$id_designation));
echo'0';


$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;

setlocale(LC_TIME,"fr_FR.UTF-8","French_France.1252");
$zone=3600*0 ;

$heure=gmdate("H:i", time() + $zone);
$date_histo=date('d/m/Y').' '.$heure;

if($lib_designation!=$_SESSION['lib_designation_mod'] || $chantier_id_designation!=$_SESSION['chantier_id_designation_mod'] || $qte_designation!=$_SESSION['qte_designation_mod'] || $prix_designation!=$_SESSION['prix_designation_mod'])
{
    $lib_trace='Modification effectuee sur designation <b>'.$_SESSION['lib_designation_mod'].'</b> pour le chantier <b>'.$_SESSION['chantier_id_designation_mod'].'</b> <br>';
    if($lib_designation!=$_SESSION['lib_designation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR L'designation) <b>".$_SESSION['lib_designation_mod']."</b> => <b>".$lib_designation."</b> <br>";
    }
    if($chantier_id_designation!=$_SESSION['chantier_id_designation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR LE CHANTIER) <b>".$_SESSION['chantier_id_designation_mod']."</b> => <b>".$chantier_id_designation."</b> ";
    }
    if($qte_designation!=$_SESSION['qte_designation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR LA QUANTITE) <b>".$_SESSION['qte_designation_mod']."</b> => <b>".$qte_designation."</b> ";
    }
    if($prix_designation!=$_SESSION['prix_designation_mod'])
    {
        $lib_trace.=" - (MODIFICATION SUR LE PRIX) <b>".$_SESSION['prix_designation_mod']."</b> => <b>".$prix_designation."</b> ";
    }
}
else
{
    $lib_trace='Aucune modification effectuee sur designation <b>'.$_SESSION['lib_designation_mod'].'</b> pour le chantier <b>'.$_SESSION['chantier_id_designation_mod'].'</b> <br>'; 
}

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_histo, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);
unset($_SESSION['id_designation_mod']);
unset($_SESSION['chantier_id_designation_mod']);
unset($_SESSION['lib_designation_mod']);

?>