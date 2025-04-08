<!DOCTYPE html>
<?php
session_start();


//Decaissement fiche

include('../../../logi/connex.php');
include '../../../decaissement/model/WhatsAppSMS.php';

// Envoi notification whatsapp
$sid = "ACded19f6cd55b2ba3d18c13f438f1e878"; // Votre SID Twilio
$token = "fea6684286c6b923e8ce0ce19bc48cb4"; // Remplacez par votre AuthToken
$from = "whatsapp:+2250711048002"; // Numéro WhatsApp Twilio

$whatsapp = new WhatsAppSMS($sid, $token, $from);


//Envoyer Mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/phpmailer/src/Exception.php';
require_once __DIR__ . '/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/phpmailer/src/SMTP.php';

require_once 'nuts.php';

require 'Database.php'; // Inclure le fichier contenant la classe Database
require 'FicheManager.php'; // Inclure le fichier contenant la classe FicheManager

// Créer une instance de Database
$db = new Database();

// Créer une instance de FicheManager avec la connexion
$ficheManager = new FicheManager($db);
$num_fiche = $_GET['num_fiche'];

//Infos fiche
$rep1 = $con->prepare('SELECT * FROM fiche WHERE num_fiche=:A ');
$rep1->execute(array('A' => $num_fiche));
$irep1 = $rep1->fetch();

$montant_decaisser = $_SESSION['montant_decaisser'];
$date_prochain_decaissement = $_SESSION['date_prochain_decaissement'];
$date_now = gmdate('Y-m-d');

$dp = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
$dp->execute(array('A' => $num_fiche));
$smdp = 0;

while ($idp = $dp->fetch()) {

  $smdp += floatval($idp['montant']);
}

$adec = $con->prepare('INSERT INTO decaissement(num_fiche_decaissement, montant, date_decaissement) VALUES(:A, :B, :D)');
$adec->execute(array('A' => $num_fiche, 'B' => $montant_decaisser, 'D' => $date_now));

//Infos fiche
$rep = $con->prepare('SELECT * FROM fiche LEFT JOIN affectation On affectation.id_affectation=fiche.affectation_id WHERE num_fiche=:A ');
$rep->execute(array('A' => $num_fiche));
$irep = $rep->fetch();

$montant = number_format($irep['montant_fiche'], 0, ',', ' ');
$affectation = stripslashes($irep['lib_affectation']);
$beneficiaire = stripslashes($irep['beficiaire_fiche']);
$designation_fiche = stripslashes($irep['designation_fiche']);
$montant_fiche = $irep['montant_fiche'];




//Calcul financier
$dec = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
$dec->execute(array('A' => $num_fiche));
$tot_dec = 0;

while ($idec = $dec->fetch()) {

  $tot_dec = floatval($idec['montant']) + $tot_dec;
}

$total_decaisse = $tot_dec;
$montant_restant = $montant_fiche - $total_decaisse;


    //Envoi notif whatsapp
    
     $whatsappNumber = "+225" . $irep['tel_beneficiaire_fiche'];
    $num_fiche = $irep['num_fiche'];

    $whatsapp->sendConfirmationDecaissement($whatsappNumber, $irep['beficiaire_fiche'], $irep['num_fiche'], $irep['precision_fiche']);

//Mettre à jour si décaissement terminé
$req = $con->prepare('UPDATE fiche SET decaisse=1, montant_fiche=:B, sauvegarder=0, secur_decaisse="dgfidest", secur_valid="dgfidest", etat_fiche=1 WHERE num_fiche=:A');
$req->execute(array('A' => $num_fiche, 'B' => $montant_decaisser));

$num_fiche = $_SESSION['num_fiche'];
$date_prochain_decaissement = $_SESSION['date_prochain_decaissement'];
$montant_restant_final = $_SESSION['montant_restant_final'];

if ($montant_restant_final > 0) {
  //Création de fiche fille si décaissement pas encore terminé
  $ficheMere = $con->prepare('SELECT * FROM fiche WHERE num_fiche =:A ');
  $ficheMere->execute(array('A' => $num_fiche));
  $infosFicheMere = $ficheMere->fetch();

  // Exemple de données pour créer une fiche
  $data = [
    'beficiaire_fiche' => $infosFicheMere['beficiaire_fiche'],
    'affectation_id' => $infosFicheMere['affectation_id'],
    'chantier_id' => $infosFicheMere['chantier_id'],
    'montant_fiche' => $montant_restant_final,
    'tel_beneficiaire_fiche' => $infosFicheMere['tel_beneficiaire_fiche'],
    'num_piece' => $infosFicheMere['num_piece'],
    'designation_fiche' => $infosFicheMere['designation_fiche'],
    'precision_fiche' => $infosFicheMere['precision_fiche'],
    'serv_bureau_banamur_id' => $infosFicheMere['serv_bureau_banamur_id'],
    'serv_bureau_fidest_id' => $infosFicheMere['serv_bureau_fidest_id'],
    'serv_rh_id' => $infosFicheMere['serv_rh_id'],
    'serv_log_id' => $infosFicheMere['serv_log_id'],
    'date_decaissement_minimum' => $date_prochain_decaissement,
    'code_parental' => $infosFicheMere['code_parental'] != "" ? $infosFicheMere['code_parental'] : $infosFicheMere['num_fiche'],
    // Nouveaux champs
    'etat_fiche' => $infosFicheMere['etat_fiche'],
    'secur_valid' => $infosFicheMere['secur_valid'],
    'photo_beneficiaire' => $infosFicheMere['photo_beneficiaire'],
    'secur_decaisse' => $infosFicheMere['secur_decaisse'],
    'cni_beneficiaire' => $infosFicheMere['cni_beneficiaire'],
    'secur_approuve' => $infosFicheMere['secur_approuve'],
    'date_approuve' => $infosFicheMere['date_approuve'],
    'approuve' => $infosFicheMere['approuve'],
    'signature_beneficiaire' => $infosFicheMere['signature_beneficiaire'],
    'conforme' => $infosFicheMere['conforme'],
    'secur_conforme' => $infosFicheMere['secur_conforme'],
    'date_conforme' => $infosFicheMere['date_conforme']
  ];

  // Appeler la méthode pour créer une fiche
  $ficheManager->createFiche($data);
}

//traçabilite

$ip = $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse = 'Adresse IP: ' . $ip . ' Port: ' . $port;
$date_trace = gmdate('Y-m-d H:i:s');
$secur = "dgfidest";

$lib_trace = "Décaissement de la somme de  <b>" . $montant_decaisser . " a <b>" . $beneficiaire . "</b> pour <b>" . $designation_fiche . "</b> ";

$red = $con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A' => $lib_trace, 'B' => $date_trace, 'C' => $adresse, 'D' => $secur));

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host = 'mail.fidest.ci';
$mail->SMTPAuth = true;
$mail->Username = "support@fidest.ci";
$mail->Password = "@Succes2019";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
$mail->From = "support@fidest.ci";
$mail->FromName = "SUPPORT FIDEST";
$mail->AddBCC("amani_ulrich@outlook.fr", "Ulrich AMANI");
$mail->AddCC("babymelissa777@gmail.com", "Baby HONOKA");

// méthode avec la classe nuts
$nuts = new nuts($montant_decaisser, 'FCFA');
$mail->isHTML(true);

$mail->Subject = "RAPPORT ENCAISSEMENT";
$mail->Body = "
    <table>
      <thead>
        <tr>
          <th style='border: 1px solid black'>Beneficiaire</th>
          <td style='border: 1px solid black'>" . $beneficiaire . "</td>
        </tr>
      </thead>

      <tbody>
        <tr>
          <th style='border: 1px solid black'>Montant</th>
          <td style='border: 1px solid black'>" . number_format($montant_decaisser, 0, ',', ' ') . " FCFA</td>
        </tr>
        <tr>
          <th style='border: 1px solid black'>Designation</th>
          <td style='border: 1px solid black'>" . $designation_fiche . "</td>
        </tr>
        <tr>
          <th style='border: 1px solid black'>Lien vers la fiche</th>
          <td style='border: 1px solid black'><a href='https://fidest.ci/logi/&_gestion/exportation/pdf/pdf_fiche.php?num_fiche=" . $num_fiche . "'>https://fidest.ci/logi/&_gestion/exportation/pdf/pdf_fiche.php?num_fiche=" . $num_fiche . "</a></td>
        </tr>
      </tbody>
    </table>
    <i><b>Soit la somme de " . $nuts->convert('fr-FR') . " Francs CFA</b></i>
    ";

$mail->AltBody = "DETAILS";

try {

  $mail->send();
  echo "Message envoyé avec succes";

  try {

    // Récupérer le numéro de téléphone du bénéficiaire à partir de la table fiche
    $stmt = $con->prepare("SELECT tel_beneficiaire_fiche, beficiaire_fiche, montant_fiche, designation_fiche  FROM fiche WHERE num_fiche=:num_fiche");
    $stmt->execute(array('num_fiche' => $num_fiche));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && isset($row['tel_beneficiaire_fiche'])) {

      $telephone_beneficiaire = $row['tel_beneficiaire_fiche'];
      $beneficiaire = $row['beficiaire_fiche'];
      $montant_fiche = $row['montant_fiche'];
      $designation_fiche = $row['designation_fiche'];

      // Données pour l'envoi du SMS
      $response = "";
      $apiKey = "IbILNr1bs1sCV1RNuvaB7amMDS9cUGG3";
      $apiToken = "bOdV1680020257";
      $senderId = "FIDEST";
      $message = " " . $beneficiaire . ", Votre decaissement de la somme de " . $montant_fiche . " FCFA pour " . $designation_fiche . " a bien ete effectue par FIDEST-BANAMUR https://fidest.org/ ";

      // Encodez le message pour inclure des caractères spéciaux dans l'URL
      $encodedMessage = urlencode($message);

      // URL pour l'envoi du SMS
      $url = 'https://panel.smsing.app/smsAPI?sendsms=null&apikey=' . $apiKey . '&apitoken=' . $apiToken . '&type=sms&from=' . $senderId . '&to=225' . $telephone_beneficiaire . '&text=' . $message;

      echo $response; //Affiche la réponse de l'envoi du SMS

    } else {

      echo "Numéro de téléphone du bénéficiaire non trouvé dans la base de données.";
    }
  } catch (PDOException $e) {

    echo "Erreur : " . $e->getMessage();
  }
  // Fermer la connexion à la base de données
  $con = null;
} catch (Exception $e) {
  echo "Erreur d'envoi du mail: " . $mail->ErrorInfo;
}

?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Succès de la vérification d'OTP</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .container {
      margin-top: 100px;
      text-align: center;
    }

    .success-message {
      color: #28a745;
      font-size: 24px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1 class="success-message">Félicitations ! Votre code OTP est correct.</h1>
    <p>Vous pouvez maintenant décaisser la somme de <?php echo number_format($montant_decaisser, 0, ',', ' '); ?> FCFA.
    </p>
    <p>
      <a class="btn btn-danger" href="../decaisse.php">Effectuer un autre décaissement</a>
    </p>
  </div>
</body>

</html>