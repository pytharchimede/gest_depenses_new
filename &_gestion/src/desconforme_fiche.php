<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

$num_fiche=addslashes($_SESSION['num_fiche_desconforme']);
$detail_desconforme=addslashes($_POST['detail_desconforme']);

//Mettre à jour si déjà existant
$req=$con->prepare('UPDATE fiche SET conforme=2, sauvegarder=0, detail_desconforme=:B, secur_desconforme="'.$_SESSION['secur_hop'].'" WHERE num_fiche=:A');
$req->execute(array('A'=>$num_fiche, 'B'=>$detail_desconforme));

$fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
$fic->execute(array('A'=>$num_fiche));
$ific=$fic->fetch();
$montant_fiche=$ific['montant_fiche'];
$beneficiaire_fiche=$ific['beficiaire_fiche'];
$designation_fiche=$ific['designation_fiche'];


    //tra�abilite
    $ip	= $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $adresse='Adresse IP: '.$ip.' Port: '.$port;
    $date_trace=gmdate('Y-m-d H:i:s');
    
    $lib_trace="Desapprobation de la fiche  N° <b>".$num_fiche."</b> soumise par <b>".$beneficiaire_fiche."</b> pour <b>".$designation_fiche."</b> <br> Motif : <b>".$detail_desconforme."</b>";
    
    $red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
    $red->execute(array('A'=>$lib_trace, 'B'=>$date_trace, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));


unset($_SESSION['num_fiche_desconforme']);
unset($con);

header('Location: ../accueil_verif_conforme.php');
?>

