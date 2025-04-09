<?php
require_once 'model/Database.php';
require_once 'model/Affectation.php';
require_once 'tcpdf/tcpdf.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();
$affectationObj = new Affectation($pdo);

$data = json_decode(file_get_contents('php://input'), true);
$fiches = $data['fiches'] ?? [];

$total_a_decaisser = 0;

foreach ($fiches as $fiche) {
    $total_a_decaisser += $fiche['montant_fiche'];
}

$pdf = new TCPDF();

// En-tête de la page
$pdf->AddPage();

// Logo et titre de l'entête
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Image('../../../img/logo_veritas.jpg', 10, 10, 30); // Logo à gauche
$pdf->Cell(0, 10, 'Montant total à décaisser : ' . number_format($total_a_decaisser, 0, ',', ' ') . ' XOF', 0, 1, 'C');
$pdf->Ln(5); // Espacement entre le titre et le tableau

// Table des fiches
$pdf->SetFont('helvetica', 'B', 10); // Taille de police plus grande pour les entêtes
$html = '<table border="1" cellpadding="5" cellspacing="0">
    <tr style="background-color:#e0e0e0; color:#333; font-weight:bold;">
        <th>Bénéficiaire</th>
        <th>Montant</th>
        <th>Affectation</th>
        <th>N° Pièce</th>
        <th>Désignation</th>
        <th>Date</th>
    </tr>';

$pdf->SetFont('helvetica', '', 10); // Retour à la taille de police normale pour le contenu

foreach ($fiches as $fiche) {
    $html .= "<tr>
        <td>{$fiche['beficiaire_fiche']}</td>
        <td>{$fiche['montant_fiche']}</td>
        <td>{$affectationObj->getAffectationById($fiche['affectation_id'])['lib_affectation']}</td>
        <td>{$fiche['num_piece']}</td>
        <td>{$fiche['designation_fiche']}</td>
        <td>{$fiche['date_creat_fiche']}</td>
    </tr>";
}
$html .= '</table>';

// Écriture du contenu HTML du tableau dans le PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Pied de page
$pdf->SetY(-30); // Positionne le pied de page à 30mm du bas de la page
$pdf->SetFont('helvetica', 'I', 8);

// Informations d'entreprise
$pdf->Cell(0, 10, mb_convert_encoding('FOURNITURES INDUSTRIELLES, DEPANNAGE ET TRAVAUX PUBLIQUES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0, 10, mb_convert_encoding('Au capital de 10 000 000 F CFA - Siège Social : Abidjan, Koumassi, Zone industrielle', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0, 10, mb_convert_encoding('01 BP 1642 Abidjan 01 - Téléphone : (+225) 27-21-36-27-27 - Email : info@fidest.org', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$pdf->Cell(0, 10, mb_convert_encoding('RCCM : CI-ABJ-2017-B-20163 - N° CC : 010274200088', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

// Numéro de page
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');

// Génération du PDF
$pdf->Output('fiches_export.pdf', 'I');
