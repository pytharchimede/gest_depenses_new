<?php
session_start();
//$_SESSION['time']=time();
include('../../../logi/connex.php');

$num_fiche = $_SESSION['num_fiche_decaisse'];
$montant_decaisse = $_POST['mont_dec'];



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



if ($montant_decaisse > $montant_restant) {
    echo '0';
} else {
    echo '1';
}



unset($con);
