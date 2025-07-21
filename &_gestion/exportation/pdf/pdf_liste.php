<?php
// Démarrage de la session et gestion des erreurs
session_start();

// Gestion des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérification et inclusion des fichiers nécessaires
$connex_path = '../../../connex.php';
$pdf_path = "../../../pdf/phpToPDF.php";
$mysql_table_path = '../../../pdf/mysql_table.php';

if (!file_exists($connex_path)) {
    die("Erreur: Fichier de connexion non trouvé ($connex_path)");
}

if (!file_exists($pdf_path)) {
    die("Erreur: Fichier phpToPDF non trouvé ($pdf_path)");
}

if (!file_exists($mysql_table_path)) {
    die("Erreur: Fichier mysql_table non trouvé ($mysql_table_path)");
}

include $connex_path;

// Vérification de la connexion à la base de données
if (!isset($con) || $con === null) {
    die("Erreur: Connexion à la base de données non établie. Vérifiez le fichier de connexion.");
}

include $pdf_path;
require $mysql_table_path;



class PDF extends PDF_MySQL_Table
{
    function Header()
    {
        // Logo et en-tête améliorés
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(0, 51, 102); // Bleu foncé

        // Titre principal
        $this->Cell(0, 10, mb_convert_encoding('FIDEST ENTREPRISES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(100, 100, 100); // Gris
        $this->Cell(0, 6, mb_convert_encoding('Système de Gestion des Décaissements', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        $this->Ln(5);

        // Ligne de séparation
        $this->SetDrawColor(0, 51, 102);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Ln(8);
    }

    // Pied de page amélioré
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);

        // Ligne de séparation
        $this->SetDrawColor(0, 51, 102);
        $this->SetLineWidth(0.3);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Ln(2);

        // Vérification de l'existence des images avant de les inclure
        $logo_veritas = '../../../img/logo_veritas.jpg';
        $logo_connex = '../../../img/logo_connex.jpg';

        if (file_exists($logo_veritas)) {
            $this->Image($logo_veritas, 10, $this->GetY(), 25);
        }

        // Informations de l'entreprise
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(80, 80, 80);

        $this->Cell(0, 3.5, mb_convert_encoding("FOURNITURES INDUSTRIELLES, DEPANNAGE ET TRAVAUX PUBLIQUES", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 3.5, mb_convert_encoding('Au capital de 10 000 000 F CFA - Siège Social : Abidjan, Koumassi, Zone industrielle', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 3.5, mb_convert_encoding("01 BP 1642 Abidjan 01 - Téléphone : (+225) 27-21-36-27-27 - Email : info@fidest.org", 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 3.5, mb_convert_encoding('RCCM : CI-ABJ-2017-B-20163 - N° CC : 010274200088', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        if (file_exists($logo_connex)) {
            $this->Image($logo_connex, 172, $this->GetY() - 12, 25);
        }

        // Numéro de page avec style
        $this->SetY(-8);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');

        // Date et heure de génération
        $this->SetFont('Arial', '', 7);
        $this->Cell(0, 5, mb_convert_encoding('Généré le ' . date('d/m/Y à H:i'), 'ISO-8859-1', 'UTF-8'), 0, 0, 'R');
    }
}



//Paramètres du fichier PDF avec nom dynamique
$date_filename = date('Y-m-d_H-i-s');
$pdffilename = "liste_decaissement_{$date_filename}.pdf";

// Nettoyage des anciens fichiers
clearstatcache();
if (file_exists($pdffilename)) {
    unlink($pdffilename);
}

// Création du fichier PDF avec orientation paysage pour plus d'espace
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 30); // Marge pour le footer
$pdf->AddPage();

// Configuration des couleurs et polices
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);

// === TITRE PRINCIPAL AVEC DESIGN MODERNE ===
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(0, 51, 102); // Bleu foncé
$pdf->Cell(0, 8, mb_convert_encoding('RAPPORT DE DÉCAISSEMENT', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(100, 100, 100);
$pdf->Cell(0, 6, mb_convert_encoding('Demandes à analyser', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$pdf->Ln(8);

// === INFORMATIONS DE FILTRAGE ===
$today = date("d/m/Y");
$dateText = '';
$filterInfo = array();

// Gestion des dates
if (empty($recher_date_debut) || empty($recher_date_fin)) {
    $dateText = "Rapport généré le : $today";
    $filterInfo[] = "⚠️ Aucun intervalle de date sélectionné";
} else {
    $debut = date("d/m/Y", strtotime($recher_date_debut));
    $fin = date("d/m/Y", strtotime($recher_date_fin));
    $dateText = "Période : du $debut au $fin";
}

// Informations de filtrage
if (!empty($recher_demandeur)) {
    $mode = ($recherche_inverse == "1") ? "EXCLU" : "INCLUS";
    $filterInfo[] = "👤 Bénéficiaire ($mode) : " . $recher_demandeur;
}

if (!empty($recher_affectation)) {
    $filterInfo[] = "🏢 Affectation : " . $lib_affectation;
}

if (!empty($recher_chantier)) {
    $filterInfo[] = "🏗️ Chantier : " . $lib_chantier;
}

// Affichage des informations dans un encadré
$pdf->SetDrawColor(200, 200, 200);
$pdf->SetFillColor(248, 249, 250);
$pdf->Rect(10, $pdf->GetY(), 277, 25, 'DF');

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(0, 6, mb_convert_encoding($dateText, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

if (!empty($filterInfo)) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(80, 80, 80);
    foreach ($filterInfo as $info) {
        $pdf->Cell(0, 5, mb_convert_encoding($info, 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
    }
}

$pdf->Ln(8);


// === RÉCUPÉRATION DES INFORMATIONS DE FILTRAGE ===

// Récupération de l'affectation
$lib_affectation = '';
if (!empty($recher_affectation)) {
    $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
    $aff->execute(array('A' => $recher_affectation));
    $iaff = $aff->fetch();
    $lib_affectation = ($iaff && isset($iaff['lib_affectation'])) ? $iaff['lib_affectation'] : '';
}

// Récupération du chantier
$lib_chantier = '';
if (!empty($recher_chantier)) {
    $cha = $con->prepare('SELECT * FROM chantier WHERE id_chantier=:A');
    $cha->execute(array('A' => $recher_chantier));
    $icha = $cha->fetch();
    $lib_chantier = ($icha && isset($icha['lib_chantier'])) ? $icha['lib_chantier'] : '';
}
$recher_date_debut    = isset($_SESSION['recher_date_debut'])    ? $_SESSION['recher_date_debut']    : '';
$recher_date_fin      = isset($_SESSION['recher_date_fin'])      ? $_SESSION['recher_date_fin']      : '';
$recher_demandeur     = isset($_SESSION['recher_demandeur'])     ? $_SESSION['recher_demandeur']     : '';
$recher_chantier      = isset($_SESSION['recher_chantier'])      ? $_SESSION['recher_chantier']      : '';
$recher_affectation   = isset($_SESSION['recher_affectation'])   ? $_SESSION['recher_affectation']   : '';
$recherche_inverse    = isset($_SESSION['recherche_inverse'])    ? $_SESSION['recherche_inverse']    : '';


$req = "SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ";

if ($recher_date_debut != "") {
    $req .= " AND date_creat_fiche>='" . $recher_date_debut . "'  ";
}

if ($recher_date_fin != "") {
    $req .= " AND date_creat_fiche<='" . $recher_date_fin . "' ";
}

if ($recher_demandeur != "") {
    if ($recherche_inverse == "1") {
        $req .= " AND beficiaire_fiche NOT LIKE '%" . $recher_demandeur . "%' ";
    } else {
        $req .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
    }
}

if ($recher_chantier != "") {
    $req .= " AND chantier_id='" . $recher_chantier . "' ";
}

if ($recher_affectation != "") {
    $req .= " AND affectation_id='" . $recher_affectation . "' ";
}

$req .= " ORDER BY id_fiche DESC";



// === TABLEAU DES DONNÉES AVEC DESIGN MODERNE ===

// Récupération du nombre d'éléments
$reta = $con->prepare($req);
$reta->execute();
$nbre_serv = $reta->rowcount();

// Affichage du nombre d'éléments
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 51, 102);
$pdf->Cell(0, 6, mb_convert_encoding("Nombre d'éléments trouvés : $nbre_serv", 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
$pdf->Ln(5);

// Configuration du tableau avec design moderne
$width_cell = array(15, 65, 65, 45, 35, 30, 25);
$pdf->SetFont('Arial', 'B', 9);

// En-tête du tableau avec dégradé
$pdf->SetFillColor(0, 51, 102); // Bleu foncé
$pdf->SetTextColor(255, 255, 255); // Texte blanc
$pdf->SetDrawColor(255, 255, 255); // Bordures blanches

// En-têtes de colonnes
$headers = array('N°', 'Affectation', 'Désignation', 'Détail', 'Bénéficiaire', 'Téléphone', 'Montant');
for ($i = 0; $i < count($headers); $i++) {
    $pdf->Cell($width_cell[$i], 8, mb_convert_encoding($headers[$i], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
}
$pdf->Ln();

// Configuration pour les lignes de données
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(200, 200, 200);
$fill = false;

$i = 0;

$k = 0;

if (isset($affectation)) {
    $affectation_i = $affectation;
} else {
    $affectation_i = '';
}

foreach ($reta as $row) {

    $i++;



    $designation = isset($row['designation_fiche']) ? $row['designation_fiche'] : '';

    if (isset($row['affectation_id']) && $row['affectation_id'] == 1 && !empty($row['chantier_id'])) {
        // CHANTIER
        $affectation = "Chantier";
        $ch = $con->prepare('SELECT * FROM chantier WHERE id_chantier=:A');
        $ch->execute(array('A' => $row['chantier_id']));
        $ich = $ch->fetch();
        if ($ich && !empty($ich['lib_chantier'])) {
            $affectation .= ' ' . $ich['lib_chantier'];
        }
    } else {
        // TOUT CE QUI N'EST PAS CHANTIER = BUREAU
        $affectation = "Bureau";
        if (isset($row['affectation_id']) && $row['affectation_id'] == 19 && !empty($row['serv_bureau_banamur_id'])) {
            $affec_bur = $con->prepare('SELECT * FROM serv_bureau_banamur WHERE id_serv_bureau_banamur=:A');
            $affec_bur->execute(array('A' => $row['serv_bureau_banamur_id']));
            $iaffec = $affec_bur->fetch();
            if ($iaffec && !empty($iaffec['lib_serv_bureau_banamur'])) {
                // $affectation .= ' ' . $iaffec['lib_serv_bureau_banamur'];
                $affectation .= '';
            }
        }
    }


    //Calcul montant restant

    $montant_fiche = $row['montant_fiche'];



    $tot_dec = 0;



    $mdec = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');

    $mdec->execute(array('A' => $row['num_fiche']));

    while ($imdec = $mdec->fetch()) {

        $tot_dec = $tot_dec + $imdec['montant'];
    }



    $montant_restant = $montant_fiche - $tot_dec;







    $pdf->Cell($width_cell[0], 7, mb_convert_encoding(substr($row['num_fiche'], 0, 45), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    $pdf->Cell($width_cell[1], 7, mb_convert_encoding(substr($affectation, 0, 45), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    $pdf->Cell($width_cell[2], 7, mb_convert_encoding(substr($designation, 0, 45), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    if ($row['affectation_id'] == 1) {

        $pdf->Cell($width_cell[3], 7, mb_convert_encoding(substr($row['precision_fiche'], 0, 45), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
    } else if ($row['affectation_id'] == 19) {

        $affec_bur = $con->prepare('SELECT * FROM serv_bureau_banamur WHERE id_serv_bureau_banamur=:A');
        $affec_bur->execute(array('A' => $row['serv_bureau_banamur_id']));
        $iaffec = $affec_bur->fetch();

        $pdf->Cell($width_cell[3], 7, mb_convert_encoding(substr($iaffec['lib_serv_bureau_banamur'], 0, 45), 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
    }


    $pdf->Cell($width_cell[4], 7, mb_convert_encoding($row['beficiaire_fiche'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    $pdf->Cell($width_cell[5], 7, mb_convert_encoding($row['tel_beneficiaire_fiche'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);

    $pdf->Cell($width_cell[6], 7, mb_convert_encoding($montant_restant, 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', false);



    $k++;

    $affectation_k = $affectation;





    $fill = !$fill;
}



//Calcul Total

$tota = ' SELECT * FROM fiche WHERE etat_fiche=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE()';


if ($recher_date_debut != "") {

    $tota .= " AND date_creat_fiche>='" . $recher_date_debut . "'  ";
}



if ($recher_date_fin != "") {

    $tota .= " AND date_creat_fiche<='" . $recher_date_fin . "' ";
}



if ($recher_demandeur != "") {

    if ($recherche_inverse == "1") {
        $tota .= " AND beficiaire_fiche NOT LIKE '%" . $recher_demandeur . "%' ";
    } else {
        $tota .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
    }
}



if ($recher_chantier != "") {

    $tota .= " AND chantier_id='" . $recher_chantier . "' ";
}



if ($recher_affectation != "") {

    $tota .= " AND affectation_id='" . $recher_affectation . "' ";
}





$tot = $con->prepare($tota);



$tot->execute();

$montant_total = 0;

while ($itot = $tot->fetch()) {



    //Calcul montant restant

    $montant_fiche = $itot['montant_fiche'];



    $tot_dec = 0;



    $mdec = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');

    $mdec->execute(array('A' => $itot['num_fiche']));

    while ($imdec = $mdec->fetch()) {

        $tot_dec = $tot_dec + $imdec['montant'];
    }



    $montant_restant = $montant_fiche - $tot_dec;



    $montant_total = $montant_total + ($montant_restant);
}



//Affiche Total

$pdf->SetFillColor(255, 255, 255);

$pdf->Cell($width_cell[0], 7, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);

$pdf->Cell($width_cell[1], 7, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);

$pdf->Cell($width_cell[2], 7, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);

$pdf->Cell($width_cell[3], 7, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);

$pdf->Cell($width_cell[4], 7, mb_convert_encoding('', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C', false);

$pdf->SetFont('Arial', 'B', 9);

$pdf->Cell($width_cell[5], 7, mb_convert_encoding('TOTAL', 'ISO-8859-1', 'UTF-8'), 1, 0, 'R', false);

$pdf->Cell($width_cell[6], 7, mb_convert_encoding(number_format($montant_total, 0, ',', ' ') . ' FCFA', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 7);

$fill = !$fill;



$pdf->Ln(8);



$pdf->SetFont('Arial', 'I', 10);

$pdf->Cell(0, 4, mb_convert_encoding('                                                                                                                                          Le Directeur Général (nom, date et visa) ', 'ISO-8859-1', 'UTF-8'), 0, 1, 'R');

$pdf->Ln(149);

$pdf->Line(10, 272, 200, 272);



//Sauvegarde du fichier PDF généré

$pdf->Output($pdffilename);



echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=$pdffilename'>";
