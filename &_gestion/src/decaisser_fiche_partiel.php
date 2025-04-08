<?php
session_start();
//$_SESSION['time']=time();
include '../../../logi/connex.php';

require 'Database.php'; // Inclure le fichier contenant la classe Database
require 'FicheManager.php'; // Inclure le fichier contenant la classe FicheManager

// Créer une instance de Database
$db = new Database();

// Créer une instance de FicheManager avec la connexion
$ficheManager = new FicheManager($db);

$num_fiche = $_SESSION['num_fiche_decaisse'];
$montant_decaisser = $_POST['montant_decaisser'];

$date_prochain_decaissement = $_POST['date_prochain_decaissement'];
$montant_restant_final = $_POST['montant_restant_final'];


$date_now = gmdate('Y-m-d');

$adec = $con->prepare('INSERT INTO decaissement(num_fiche_decaissement, montant, secur_decaissement, date_decaissement) VALUES(:A, :B, :C, :D)');
$adec->execute(array('A' => $num_fiche, 'B' => $montant_decaisser, 'C' => $_SESSION['secur_hop'], 'D' => $date_now));

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


//Mettre à jour si décaissement terminé
if ($montant_restant == 0) {
    $req = $con->prepare('UPDATE fiche SET decaisse=1, secur_decaisse="' . $_SESSION['secur_hop'] . '" WHERE num_fiche=:A');
    $req->execute(array('A' => $num_fiche));
} else {

    //Création de fiche fille si décaissement pas encore terminé

    $ficheMere = $con->prepare('SELECT * FROM fiche WHERE num_fiche =:A ');
    $ficheMere->execute(array('num_fiche' => $num_fiche));
    $infosFicheMere = $ficheMere->fetch();

    // Exemple de données pour créer une fiche
    $data = [
        'beficiaire_fiche' => $infosFicheMere['beficiaire_fiche'],
        'affectation_id' => $infosFicheMere['affectation_id'],
        'chantier_id' => $infosFicheMere['chantier_id'],
        'montant_fiche' => $montant_restant_final,
        'tel_beneficiaire_fiche' => $infosFicheMere['tel_beneficiaire_fiche'],
        'num_piece' => $infosFicheMere['num_piece'],
        'designation_fiche_bureau' => $infosFicheMere['designation_fiche_bureau'],
        'precision_fiche' => $infosFicheMere['precision_fiche'],
        'serv_bureau_banamur_id' => $infosFicheMere['serv_bureau_banamur_id'],
        'serv_bureau_fidest_id' => $infosFicheMere['serv_bureau_fidest_id'],
        'serv_rh_id' => $infosFicheMere['serv_rh_id'],
        'serv_log_id' => $infosFicheMere['serv_log_id'],
        'date_decaissement_minimum' => $date_prochain_decaissement,
        'code_parental' => $infosFicheMere['code_parental'] != "" ? $infosFicheMere['code_parental'] : $infosFicheMere['num_fiche'],
    ];

    // Appeler la méthode pour créer une fiche
    $ficheManager->createFiche($data);
}




//tra�abilite
$ip    = $_SERVER['REMOTE_ADDR'];
$port = $_SERVER['REMOTE_PORT'];
$adresse = 'Adresse IP: ' . $ip . ' Port: ' . $port;
$date_trace = gmdate('Y-m-d H:i:s');

$lib_trace = "Décaissement de la somme de  <b>" . $montant_decaisser . " a <b>" . $beneficiaire . "</b> pour <b>" . $designation_fiche . "</b> ";

$red = $con->prepare("INSERT INTO trace (lib_trace, date_trace, adresse_ip, secur) VALUES (:A, :B, :C, :D)");
$red->execute(array('A' => $lib_trace, 'B' => $date_trace, 'C' => $adresse, 'D' => $_SESSION['secur_hop']));


unset($con);
