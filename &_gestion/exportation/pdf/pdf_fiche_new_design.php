<?php

session_start();

$_SESSION['num_fiche'] = $_GET['num_fiche'];

include('../../../connex.php');
include("../../../pdf/phpToPDF.php");
require('../../../pdf/mysql_table.php');
require_once("phpqrcode/qrlib.php");

class ModernPDF extends PDF_MySQL_Table
{
    private $primaryColor = [41, 128, 185]; // Bleu moderne
    private $secondaryColor = [52, 73, 94]; // Gris foncé élégant
    private $accentColor = [231, 76, 60]; // Rouge accent
    private $successColor = [39, 174, 96]; // Vert succès
    private $lightGray = [236, 240, 241]; // Gris clair
    private $darkGray = [44, 62, 80]; // Gris très foncé

    function Header()
    {
        // Bannière colorée en haut
        $this->SetFillColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Rect(0, 0, 210, 25, 'F');
        
        // Logo et titre entreprise
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 16);
        $this->SetXY(10, 8);
        $this->Cell(0, 8, utf8_decode('FIDEST ENTREPRISES'), 0, 1, 'L');
        
        // Sous-titre moderne
        $this->SetFont('Arial', '', 9);
        $this->SetXY(10, 16);
        $this->Cell(0, 4, utf8_decode('Solutions Industrielles & Travaux Publics'), 0, 1, 'L');
        
        // QR Code dans header (si disponible)
        if (isset($_SESSION['num_fiche'])) {
            addImageSafely($this, "qr_code_" . $_SESSION['num_fiche'] . ".png", 170, 5, 15, 15, '', '', '');
        }
        
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-25);
        
        // Ligne de séparation moderne
        $this->SetDrawColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->SetLineWidth(0.5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        $this->Ln(3);
        
        // Informations de contact modernes
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor($this->darkGray[0], $this->darkGray[1], $this->darkGray[2]);
        
        $this->Cell(0, 3, utf8_decode('📍 Abidjan, Koumassi, Zone Industrielle • 📞 +225 27-21-36-27-27 • 📧 info@fidest.org'), 0, 1, 'C');
        $this->Cell(0, 3, utf8_decode('🏢 RCCM: CI-ABJ-2017-B-20163 • 💰 Capital: 10 000 000 F CFA'), 0, 1, 'C');
        
        // Numéro de page stylé
        $this->SetY(-8);
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Cell(0, 4, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function modernSection($title, $icon = '')
    {
        $this->Ln(5);
        
        // Fond coloré pour la section
        $this->SetFillColor($this->lightGray[0], $this->lightGray[1], $this->lightGray[2]);
        $this->Rect(10, $this->GetY(), 190, 8, 'F');
        
        // Bordure gauche colorée
        $this->SetFillColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Rect(10, $this->GetY(), 3, 8, 'F');
        
        // Titre de section
        $this->SetTextColor($this->darkGray[0], $this->darkGray[1], $this->darkGray[2]);
        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(16, $this->GetY() + 2);
        $this->Cell(0, 4, utf8_decode($icon . ' ' . $title), 0, 1, 'L');
        
        $this->Ln(3);
    }

    function modernField($label, $value, $width = 180)
    {
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor($this->secondaryColor[0], $this->secondaryColor[1], $this->secondaryColor[2]);
        $this->Cell($width, 4, utf8_decode($label), 0, 1, 'L');
        
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor($this->darkGray[0], $this->darkGray[1], $this->darkGray[2]);
        $this->Cell($width, 6, utf8_decode($value), 0, 1, 'L');
        $this->Ln(2);
    }

    function statusBadge($status, $color)
    {
        $this->SetFillColor($color[0], $color[1], $color[2]);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        
        // Rectangle arrondi simulé avec des rectangles
        $this->Rect($this->GetX(), $this->GetY(), 80, 8, 'F');
        $this->Cell(80, 8, utf8_decode($status), 0, 1, 'C');
    }

    function modernCard($x, $y, $w, $h, $title, $content, $bgColor = null)
    {
        if (!$bgColor) $bgColor = [255, 255, 255];
        
        // Ombre de carte (effet depth)
        $this->SetFillColor(200, 200, 200);
        $this->Rect($x + 1, $y + 1, $w, $h, 'F');
        
        // Carte principale
        $this->SetFillColor($bgColor[0], $bgColor[1], $bgColor[2]);
        $this->Rect($x, $y, $w, $h, 'F');
        
        // Bordure
        $this->SetDrawColor($this->lightGray[0], $this->lightGray[1], $this->lightGray[2]);
        $this->Rect($x, $y, $w, $h);
        
        // Titre de carte
        $this->SetXY($x + 5, $y + 3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor($this->primaryColor[0], $this->primaryColor[1], $this->primaryColor[2]);
        $this->Cell($w - 10, 5, utf8_decode($title), 0, 1, 'L');
        
        // Contenu
        $this->SetXY($x + 5, $y + 10);
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor($this->darkGray[0], $this->darkGray[1], $this->darkGray[2]);
        $this->MultiCell($w - 10, 4, utf8_decode($content), 0, 'L');
    }
}

// Fonction pour ajouter une image de manière sécurisée (réutilisée)
function addImageSafely($pdf, $file, $x, $y, $w, $h = 0, $type = '', $link = '', $errorMsg = '')
{
    if (!file_exists($file) || filesize($file) == 0) {
        return false;
    }

    if (filesize($file) < 10) {
        return false;
    }

    $imageInfo = @getimagesize($file);
    if ($imageInfo === false) {
        return false;
    }

    $supportedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
    if (!in_array($imageInfo[2], $supportedTypes)) {
        return false;
    }

    $previousErrorHandler = set_error_handler(function ($severity, $message, $file, $line) {
        return true;
    });

    try {
        $result = $pdf->Image($file, $x, $y, $w, $h, $type, $link);
        set_error_handler($previousErrorHandler);
        return true;
    } catch (Exception $e) {
        set_error_handler($previousErrorHandler);
        return false;
    } catch (Error $e) {
        set_error_handler($previousErrorHandler);
        return false;
    }
}

// Définir les couleurs globalement
$primaryColor = [41, 128, 185]; // Bleu moderne
$secondaryColor = [52, 73, 94]; // Gris foncé élégant
$accentColor = [231, 76, 60]; // Rouge accent
$successColor = [39, 174, 96]; // Vert succès
$lightGray = [236, 240, 241]; // Gris clair
$darkGray = [44, 62, 80]; // Gris très foncé

// Création du PDF moderne
$pdf = new ModernPDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

// Récupération des données
$req0 = $con->prepare("SELECT * FROM fiche LEFT JOIN utilisateur ON utilisateur.secur=fiche.secur_approuve WHERE num_fiche='" . $_SESSION['num_fiche'] . "'");
$req0->execute();
$info_fiche0 = $req0->fetch();

$req1 = $con->prepare("SELECT * FROM fiche LEFT JOIN affectation ON affectation.id_affectation=fiche.affectation_id LEFT JOIN chantier On chantier.id_chantier=fiche.chantier_id WHERE num_fiche='" . $_SESSION['num_fiche'] . "'");
$req1->execute();
$info_fiche = $req1->fetch();

// Générer QR Code
QRcode::png("https://fidest.ci/src/recup_dem.php?num_demande=" . $_SESSION['num_fiche'] . " ", "qr_code_" . $_SESSION['num_fiche'] . ".png");

// Calculs financiers
$fi = $con->prepare('SELECT * FROM fiche WHERE num_fiche=:A');
$fi->execute(array('A' => $_SESSION['num_fiche']));
$ifi = $fi->fetch();
$montant_fiche = $ifi['montant_fiche'];

$montant_den = 0;
$den = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
$den->execute(array('A' => $_SESSION['num_fiche']));
while ($iden = $den->fetch()) {
    $montant_den = $iden['montant'] + $montant_den;
}
$montant_dispo = $montant_fiche - $montant_den;

// TITRE PRINCIPAL MODERNE
$pdf->SetY(35);
$pdf->SetFont('Arial', 'B', 24);
$pdf->SetTextColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->Cell(0, 12, utf8_decode('FICHE D\'EXPRESSION DE BESOIN'), 0, 1, 'C');

// Sous-titre avec numéro
$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]);
$pdf->Cell(0, 8, utf8_decode('Référence: ' . $_SESSION['num_fiche'] . ' • ' . gmdate('d/m/Y')), 0, 1, 'C');

// STATUS BADGE
$pdf->Ln(5);
$pdf->SetX(65);

if ($montant_den == $montant_fiche) {
    $pdf->statusBadge('✅ FICHE DÉCAISSÉE TOTALEMENT', $successColor);
} elseif ($montant_den > 0 && $montant_dispo > 0) {
    $pdf->statusBadge('🔄 DÉCAISSEMENT PARTIEL', [243, 156, 18]);
} elseif ($montant_dispo == $montant_fiche && $info_fiche0['etat_fiche'] == 1) {
    $pdf->statusBadge('⏳ EN ATTENTE DE DÉCAISSEMENT', [52, 152, 219]);
} elseif ($info_fiche0['etat_fiche'] == 2) {
    $pdf->statusBadge('❌ DEMANDE REFUSÉE', $accentColor);
} else {
    $pdf->statusBadge('📋 EN COURS DE TRAITEMENT', [155, 89, 182]);
}

$pdf->Ln(15);

// SECTION BÉNÉFICIAIRE AVEC PHOTO
$pdf->modernSection('INFORMATIONS BÉNÉFICIAIRE', '👤');

// Photo du bénéficiaire moderne
$photo = $info_fiche0['photo_beneficiaire'] ?: 'default_picture.jpg';
$photoAdded = addImageSafely($pdf, "../../../../img_demande/" . $photo, 15, $pdf->GetY(), 25, 30);

if (!$photoAdded) {
    // Avatar par défaut stylé
    $pdf->SetFillColor(189, 195, 199);
    $pdf->Rect(15, $pdf->GetY(), 25, 30, 'F');
    $pdf->SetXY(15, $pdf->GetY() + 10);
    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(25, 10, '👤', 0, 0, 'C');
}

// Informations à droite de la photo
$startY = $pdf->GetY();
$pdf->SetXY(45, $startY);
$pdf->modernField('Nom et Prénom(s)', $info_fiche['beficiaire_fiche'], 140);

$pdf->SetXY(45, $startY + 15);
$pdf->modernField('Téléphone', $info_fiche['tel_beneficiaire_fiche'], 140);

$pdf->SetY($startY + 35);

// SECTION AFFECTATION
$pdf->modernSection('AFFECTATION & CATÉGORIE', '🏢');
$pdf->modernField('Libellé de l\'affectation', $info_fiche['lib_affectation'] . ' ' . $info_fiche['lib_chantier']);

// Gestion des catégories
$categorie = '';
if ($info_fiche['serv_bureau_banamur_id'] != 0) {
    $ser_ban = $con->prepare("SELECT * FROM serv_bureau_banamur WHERE id_serv_bureau_banamur=:A");
    $ser_ban->execute(array('A' => $info_fiche['serv_bureau_banamur_id']));
    $iser_ban = $ser_ban->fetch();
    $categorie = $iser_ban['lib_serv_bureau_banamur'];
}
if ($info_fiche['serv_bureau_fidest_id'] != 0) {
    $ser_fid = $con->prepare("SELECT * FROM serv_bureau_fidest WHERE id_serv_bureau_fidest=:A");
    $ser_fid->execute(array('A' => $info_fiche['serv_bureau_fidest_id']));
    $iser_fid = $ser_fid->fetch();
    $categorie = $iser_fid['lib_serv_bureau_fidest'];
}
if ($info_fiche['serv_rh_id'] != 0) {
    $ser_fid = $con->prepare("SELECT * FROM serv_rh WHERE id_serv_rh=:A");
    $ser_fid->execute(array('A' => $info_fiche['serv_rh_id']));
    $iser_fid = $ser_fid->fetch();
    $categorie = $iser_fid['lib_serv_rh'];
}
if ($info_fiche['serv_log_id'] != 0) {
    $ser_fid = $con->prepare("SELECT * FROM serv_log WHERE id_serv_log=:A");
    $ser_fid->execute(array('A' => $info_fiche['serv_log_id']));
    $iser_fid = $ser_fid->fetch();
    $categorie = $iser_fid['lib_serv_log'];
}

if ($categorie) {
    $pdf->modernField('Catégorie', $categorie);
}

// SECTION DESCRIPTION
$pdf->modernSection('DESCRIPTION DE LA DEMANDE', '📝');
$pdf->modernField('Désignation', $info_fiche['designation_fiche']);
$pdf->modernField('Description détaillée', $info_fiche['precision_fiche']);

// SECTION FINANCIÈRE MODERNE
$pdf->modernSection('RÉCAPITULATIF FINANCIER', '💰');

// Cartes financières côte à côte
$cardY = $pdf->GetY();

// Carte Montant Demandé
$pdf->modernCard(15, $cardY, 85, 25, '💵 Montant Demandé', 
    number_format($montant_fiche, 0, ',', ' ') . ' FCFA', 
    [236, 240, 241]);

// Carte Montant Décaissé
$pdf->modernCard(110, $cardY, 85, 25, '✅ Montant Décaissé', 
    number_format($montant_den, 0, ',', ' ') . ' FCFA', 
    $montant_den > 0 ? [46, 204, 113] : [236, 240, 241]);

$pdf->SetY($cardY + 30);

// Carte Montant Disponible
if ($montant_dispo > 0) {
    $pdf->modernCard(15, $pdf->GetY(), 180, 20, '💳 Montant Disponible', 
        number_format($montant_dispo, 0, ',', ' ') . ' FCFA', 
        [52, 152, 219]);
    $pdf->Ln(25);
}

// SECTION PAIEMENT
$pdf->modernSection('MODE DE PAIEMENT', '💳');
$pdf->modernField('Numéro de pièce / Méthode', $info_fiche['num_piece']);

// SECTION SIGNATURES MODERNE
$pdf->Ln(10);
$pdf->modernSection('SIGNATURES & VALIDATIONS', '✍️');

$signY = $pdf->GetY();

// Zone signatures avec style moderne
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor($darkGray[0], $darkGray[1], $darkGray[2]);

// Signature bénéficiaire
$pdf->SetXY(15, $signY);
$pdf->Cell(55, 5, utf8_decode('Signature Bénéficiaire'), 0, 1, 'C');
$pdf->Rect(15, $signY + 7, 55, 25);

if ($info_fiche0['signature_beneficiaire']) {
    addImageSafely($pdf, "../../signature/" . $info_fiche0['signature_beneficiaire'], 20, $signY + 10, 45, 20);
}

// Signature Directeur
$pdf->SetXY(80, $signY);
$pdf->Cell(55, 5, utf8_decode('Approbation Directeur'), 0, 1, 'C');
$pdf->Rect(80, $signY + 7, 55, 25);

if ($info_fiche0['etat_fiche'] != 0) {
    addImageSafely($pdf, "../../../img/signature_small.jpg", 85, $signY + 10, 45, 20);
}

// Signature DG
$pdf->SetXY(145, $signY);
$pdf->Cell(50, 5, utf8_decode('Approbation DG'), 0, 1, 'C');
$pdf->Rect(145, $signY + 7, 50, 25);

if ($info_fiche0['approuve'] == 1) {
    addImageSafely($pdf, "../../../img_sign/" . $info_fiche0['signature_util'], 150, $signY + 10, 40, 20);
}

// Noms sous les signatures
$pdf->SetY($signY + 35);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]);

$pdf->SetX(15);
$pdf->Cell(55, 4, utf8_decode($info_fiche['beficiaire_fiche']), 0, 0, 'C');

$pdf->SetX(80);
$pdf->Cell(55, 4, utf8_decode('M. ' . strtoupper($info_fiche0['nom_utilisateur'] ?? '')), 0, 0, 'C');

$pdf->SetX(145);
$pdf->Cell(50, 4, utf8_decode('Paul Alex BRAUD'), 0, 1, 'C');

// Cachet payé si nécessaire
if ($info_fiche0['signature_beneficiaire'] != '' && $montant_dispo == 0 && ($montant_fiche == $montant_den)) {
    addImageSafely($pdf, "../../../images/cachet_paye.jpg", 90, $signY - 30, 60, 20);
}

// Informations validateur en bas
$va1 = $con->prepare('SELECT * from fiche LEFT JOIN utilisateur ON fiche.secur_valid=utilisateur.secur WHERE num_fiche="' . $_SESSION['num_fiche'] . '"');
$va1->execute();
$iva1 = $va1->fetch();

$note_1 = 'En attente de décision';
$validateur_1 = $iva1['nom_utilisateur'] ?? '';

if ($iva1['secur_valid'] != '' && $iva1['secur_refus'] == '') {
    $note_1 = 'Validée par';
}

$va1 = $con->prepare('SELECT * from fiche LEFT JOIN utilisateur ON fiche.secur_refus=utilisateur.secur WHERE num_fiche="' . $_SESSION['num_fiche'] . '"');
$va1->execute();
$iva1 = $va1->fetch();

if ($iva1['secur_valid'] == '' && $iva1['secur_refus'] != '') {
    $validateur_1 = $iva1['nom_utilisateur'];
    $note_1 = 'Réfusée par';
}

if ($validateur_1) {
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetTextColor($secondaryColor[0], $secondaryColor[1], $secondaryColor[2]);
    $pdf->Cell(0, 4, utf8_decode('Status: ' . $note_1 . ' ' . $validateur_1), 0, 1, 'C');
}

// Ligne finale moderne
$pdf->SetY(270);
$pdf->SetDrawColor($primaryColor[0], $primaryColor[1], $primaryColor[2]);
$pdf->SetLineWidth(1);
$pdf->Line(10, 270, 200, 270);

// Sauvegarde
$pdffilename = 'fiche_expression_besoin_modern.pdf';
clearstatcache();
if (file_exists($pdffilename)) {
    unlink($pdffilename);
}

$pdf->Output($pdffilename);
echo "<META HTTP-EQUIV='Refresh' CONTENT='2;URL=$pdffilename'>";

?>
