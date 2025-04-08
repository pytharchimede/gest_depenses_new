<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

$num_fiche=addslashes($_GET['num_fiche_conforme']);
$date_trace=gmdate('Y-m-d H:i:s');

//Mettre à jour si déjà existant
$req=$con->prepare('UPDATE fiche SET conforme=1, secur_conforme="'.$_SESSION['secur_hop'].'", date_conforme=:A WHERE num_fiche=:B');
$req->execute(array('A'=>$date_trace, 'B'=>$num_fiche));

$fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
$fic->execute(array('A'=>$num_fiche));
$ific=$fic->fetch();
$montant_fiche=$ific['montant_fiche'];
$beneficiaire_fiche=$ific['beficiaire_fiche'];

//Approuver automatiquement pour un chantier spécifique | Garage 32
$chant=$con->prepare('SELECT * FROM fiche LEFT JOIN chantier ON fiche.chantier_id=chantier.id_chantier WHERE num_fiche=:A AND chantier_id!=0 ');
$chant->execute(array('A'=>$num_fiche));
$ichant=$chant->fetch();
$chantier_id=$ichant['chantier_id'];

if($chantier_id==35)
{
    //Debut approbation
    //$num_fiche=addslashes($_GET['num_fiche_approuve']);
    $date_trace=gmdate('Y-m-d H:i:s');
    
    //Mettre à jour si déjà existant
    $req=$con->prepare('UPDATE fiche SET approuve=1, secur_approuve="'.$_SESSION['secur_hop'].'", date_approuve=:A WHERE num_fiche=:B');
    $req->execute(array('A'=>$date_trace, 'B'=>$num_fiche));
    
    $fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
    $fic->execute(array('A'=>$num_fiche));
    $ific=$fic->fetch();
    $montant_fiche=$ific['montant_fiche'];
    $beneficiaire_fiche=$ific['beficiaire_fiche'];
    
    //tra�abilite
    $ip	= $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];
    $adresse='Adresse IP: '.$ip.' Port: '.$port;
    
    
    $fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
    $fic->execute(array('A'=>$num_fiche));
    $ific=$fic->fetch();
    $montant_fiche=$ific['montant_fiche'];
    $beneficiaire_fiche=$ific['beficiaire_fiche'];
    $designation_fiche=$ific['designation_fiche'];
    
    $lib_trace="Approbation de la fiche  N° <b>".$num_fiche."</b> soumise par <b>".$beneficiaire_fiche."</b> pour <b>".$designation_fiche."</b> <br> ";
    
    $red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
    $red->execute(array('A'=>$lib_trace, 'B'=>$date_trace, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));
    //Fin approbation
}

//tra�abilite
$ip	= $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse='Adresse IP: '.$ip.' Port: '.$port;


$fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
$fic->execute(array('A'=>$num_fiche));
$ific=$fic->fetch();
$montant_fiche=$ific['montant_fiche'];
$beneficiaire_fiche=$ific['beficiaire_fiche'];
$designation_fiche=$ific['designation_fiche'];

$lib_trace="Declaree conforme | Fiche  N° <b>".$num_fiche."</b> soumise par <b>".$beneficiaire_fiche."</b> pour <b>".$designation_fiche."</b> <br> ";

$red=$con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A'=>$lib_trace, 'B'=>$date_trace, 'C'=>$adresse, 'D'=>$_SESSION['secur_hop']));

unset($con);

header('Location: ../accueil_verif_conforme.php');
?>

