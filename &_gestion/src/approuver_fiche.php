<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');


//Approbation fiche
include '../../../decaissement/model/WhatsAppSMS.php';

// Envoi notification whatsapp
$sid = "ACded19f6cd55b2ba3d18c13f438f1e878"; // Votre SID Twilio
$token = "fea6684286c6b923e8ce0ce19bc48cb4"; // Remplacez par votre AuthToken
$from = "whatsapp:+2250711048002"; // Numéro WhatsApp Twilio

$whatsapp = new WhatsAppSMS($sid, $token, $from);

$num_fiche=addslashes($_GET['num_fiche_approuve']);
$date_trace=gmdate('Y-m-d H:i:s');

//Mettre à jour si déjà existant
$req=$con->prepare('UPDATE fiche SET approuve=1, secur_approuve="'.$_SESSION['secur_hop'].'", date_approuve=:A WHERE num_fiche=:B');
$req->execute(array('A'=>$date_trace, 'B'=>$num_fiche));

$fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
$fic->execute(array('A'=>$num_fiche));
$ific=$fic->fetch();
$montant_fiche=$ific['montant_fiche'];
$beneficiaire_fiche=$ific['beficiaire_fiche'];

    //Envoi notif whatsapp
    
     $whatsappNumber = "+225" . $ific['tel_beneficiaire_fiche'];
    $num_fiche = $ific['num_fiche'];

    $whatsapp->sendConfirmationApprobation($whatsappNumber, $ific['beficiaire_fiche'], $ific['num_fiche'], $_SESSION['nom_adm_hop']);

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

unset($con);

header('Location: ../accueil_approbation.php');
?>

