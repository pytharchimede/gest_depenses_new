<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

//Reporter fiche
include '../../../decaissement/model/WhatsAppSMS.php';

// Envoi notification whatsapp
$sid = "ACded19f6cd55b2ba3d18c13f438f1e878"; // Votre SID Twilio
$token = "fea6684286c6b923e8ce0ce19bc48cb4"; // Remplacez par votre AuthToken
$from = "whatsapp:+2250711048002"; // Numéro WhatsApp Twilio

$whatsapp = new WhatsAppSMS($sid, $token, $from);


if (isset($_POST['num_fiche']) && isset($_POST['new_date'])) {
    $num_fiche = $_POST['num_fiche'];
    $new_date = $_POST['new_date'];

    // Connexion à la base de données
    $fic=$con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
    $fic->execute(array('A'=>$num_fiche));
    $ific=$fic->fetch();

    // Mise à jour de la date de décaissement minimale
    $updateQuery = $con->prepare('UPDATE fiche SET date_decaissement_minimum = :new_date WHERE num_fiche = :num_fiche');
    $updateQuery->execute(array(
        'new_date' => $new_date,
        'num_fiche' => $num_fiche
    ));
    
    //Envoi notif whatsapp
    $whatsappNumber = "+225" . $ific['tel_beneficiaire_fiche'];
    $num_fiche = $ific['num_fiche'];
    
    setlocale(LC_TIME, 'fr_FR.utf8'); // Définit la langue en français
    $date_en_francais = strftime('%A %d %B %Y', strtotime($new_date)); // Formate la date

    $whatsapp->sendInformReport($whatsappNumber, $ific['beficiaire_fiche'], $ific['num_fiche'], $_SESSION['nom_adm_hop'], $date_en_francais);

    // Redirection après la mise à jour
    header('Location: ../accueil.php?message=Fiche reportée avec succès');
    exit();
}
