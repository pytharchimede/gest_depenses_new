<?php
session_start();

include('../../../logi/connex.php');



require_once '../../../OrangeSMS.php';
require_once '../../../WhatsAppSMS.php';





// Générer un code OTP aléatoire de 6 chiffres

$otp = rand(100000, 999999);


$num_fiche = $_SESSION['num_fiche'];
// $montant_decaisser = $_SESSION['montant_decaisser'];
// $date_prochain_decaissement = $_SESSION['date_prochain_decaissement'];
// $montant_restant_final = $_SESSION['montant_restant_final'];

$inf = $con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');

$inf->execute(array('A' => $num_fiche));

$info = $inf->fetch();



//var_dump($info['otp']);



try {



    if ($info['otp'] == 0) {

        // Préparer et exécuter la requête SQL pour mettre à jour le code OTP

        $stmt = $con->prepare("UPDATE fiche SET otp=:otp WHERE num_fiche=:num_fiche");

        $stmt->execute(array('otp' => $otp, 'num_fiche' => $num_fiche));



        // Récupérer le numéro de téléphone du bénéficiaire à partir de la table fiche

        $stmt = $con->prepare("SELECT tel_beneficiaire_fiche, beficiaire_fiche, montant_fiche FROM fiche WHERE num_fiche=:num_fiche");

        $stmt->execute(array('num_fiche' => $num_fiche));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);



        if ($row && isset($row['tel_beneficiaire_fiche'])) {

            $telephone_beneficiaire = $row['tel_beneficiaire_fiche'];

            $beneficiaire = $row['beficiaire_fiche'];

            $montant_fiche = $row['montant_fiche'];





            // Données pour l'envoi du SMS

            /*

$apiKey = "IbILNr1bs1sCV1RNuvaB7amMDS9cUGG3";

$apiToken = "bOdV1680020257";

$senderId = "FIDEST";

*/

            //$message = "Bonjour ".$beneficiaire.", Votre code OTP est : ".$otp;

            /*

$message = '

Votre somme de '.$montant_fiche.' a été décaissée. Veuillez transmettre votre OTP '.$otp.' pour finaliser. FIDEST-BANAMUR

';

*/



            // Encodez le message pour inclure des caractères spéciaux dans l'URL

            //$encodedMessage = urlencode($message);



            // URL pour l'envoi du SMS

            //$url = "https://panel.smsing.app/smsAPI?sendsms=null&apikey=".$apiKey."&apitoken=".$apiToken."&type=sms&from=".$senderId."&to=225".$telephone_beneficiaire."&text=".$message;



            //$url = 'https://panel.smsing.app/smsAPI?sendsms=null&apikey='.$apiKey.'&apitoken='.$apiToken.'&type=sms&from='.$senderId.'&to=225'.$telephone_beneficiaire.'&text='.$message;



            //Envoi sms NOTIF EXPEDITEUR

            /*

$curl = curl_init();



curl_setopt_array($curl, array(

CURLOPT_URL => 'https://panel.smsing.app/smsAPI?sendsms=null&apikey=IbILNr1bs1sCV1RNuvaB7amMDS9cUGG3&apitoken=bOdV1680020257&type=sms&from='.$senderId.'&to=225'.$telephone_beneficiaire.'&text='.$encodedMessage,

CURLOPT_RETURNTRANSFER => true,

CURLOPT_ENCODING => '',

CURLOPT_MAXREDIRS => 10,

CURLOPT_TIMEOUT => 0,

CURLOPT_FOLLOWLOCATION => true,

CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

CURLOPT_CUSTOMREQUEST => 'GET',

));



$response = curl_exec($curl);



curl_close($curl);



*/



            // Importation de la classe
/*
            $clientId = 'Xb6Wgzi9iCWFAJakdSNPCpMGBx9ixxF0';

            $clientSecret = 'xOXZ4QTDf7bLfGk3';



            try {

                // Instanciation de la classe OrangeSMS

                $orangeSMS = new OrangeSMS($clientId, $clientSecret);



                // Format du numéro de téléphone sans ajouter de 'tel:' supplémentaire

                $recipientPhoneNumber = '+225' . $telephone_beneficiaire;

                $senderPhoneNumber = '+2250748367710';



                // Envoi d'un SMS

                $message = 'Votre somme de ' . $montant_fiche . ' a été décaissée. Veuillez transmettre votre OTP ' . $otp . ' pour finaliser. FIDEST-BANAMUR';

                $response = $orangeSMS->sendSMS('tel:' . $recipientPhoneNumber, 'tel:' . $senderPhoneNumber, $message);

                print_r($response);



                // Vérification du solde SMS

                $balance = $orangeSMS->getSMSBalance();

                print_r($balance);



                // Vérification de l'usage des SMS

                $usage = $orangeSMS->getSMSUsage();

                print_r($usage);
            } catch (Exception $e) {

                echo 'Erreur: ' . $e->getMessage();
            }
*/

            //Fin sms NOTIF EXPEDITEUR



            //echo $response; // Affiche la réponse de l'envoi du SMS



//Fin sms NOTIF EXPEDITEUR

// Identifiants Twilio
$sid    = "ACded19f6cd55b2ba3d18c13f438f1e878"; // Remplacer par votre SID Twilio
$token  = "fea6684286c6b923e8ce0ce19bc48cb4"; // Remplacer par votre AuthToken Twilio
$from   = "whatsapp:+2250711048002"; // Remplacer par votre numéro WhatsApp validé
$retour = "";

$recipientPhoneNumber='0505055262';


$whatsAppMessage = new WhatsAppSMS($sid, $token, $from);
$whatsAppResponse = $whatsAppMessage->sendconfirmation_decaissementTemplateMessage($recipientPhoneNumber, $montant_fiche);

//Envoi message whatsApp





        } else {

            echo "Numéro de téléphone du bénéficiaire non trouvé dans la base de données.";
        }
    }
} catch (PDOException $e) {

    echo "Erreur : " . $e->getMessage();
}





$myFiche = $con->prepare('SELECT * FROM fiche WHERE num_fiche=:num_fiche');

$myFiche->execute(array('num_fiche' => $num_fiche));

$iMyFiche = $myFiche->fetch();



$otp_send = $iMyFiche['otp'];



// Fermer la connexion à la base de données

$con = null;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>VALIDER OTP</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {

            background-image: url('background-image.jpg');
            /* Remplacez 'background-image.jpg' par votre image de fond */

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

            height: 100vh;

        }



        .otp-form {

            background-color: rgba(255, 255, 255, 0.8);
            /* Opacité du fond */

            padding: 20px;

            border-radius: 10px;

            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.75);

        }



        input[type="text"] {

            width: 60px;
            /* Largeur de la case de saisie */

            height: 60px;
            /* Hauteur de la case de saisie */

            text-align: center;
            /* Alignement du texte au centre */

            font-size: 2em;
            /* Taille de la police */

            margin: 10px;
            /* Marge autour de chaque case */

        }
    </style>

</head>

<body>




    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="otp-form mt-5">

                    <form action="verification_otp_partiel.php?id_fiche=<?php echo $num_fiche; ?>" method="POST">

                        <h2 class="text-center mb-4">Entrez votre code OTP <?php echo $otp_send; ?></h2>

                        <div class="d-flex justify-content-center">

                            <!-- Créer une case de saisie pour chaque chiffre de l'OTP --> <?php for ($i = 0; $i < 6; $i++) : ?>

                                <input type="text" class="form-control otp-input" name="otp[]" maxlength="1" autocomplete="off" oninput="moveToNext(this)" onkeydown="handleBackspace(event)" required>

                            <?php endfor; ?>

                        </div>

                        <div class="text-center mt-4">

                            <button type="submit" class="btn btn-primary">Valider</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>



    <script>
        function moveToNext(input) {

            if (input.value.length >= 1) {

                var nextInput = input.nextElementSibling;

                if (nextInput !== null) {

                    nextInput.focus();

                }

            }

        }



        function handleBackspace(event) {

            if (event.key === 'Backspace') {

                var previousInput = event.target.previousElementSibling;

                if (previousInput !== null) {

                    previousInput.focus();

                    previousInput.value = ''; // Effacer le contenu de la case précédente

                }

            }

        }
    </script>



</body>

</html>