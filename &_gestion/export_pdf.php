<?php
require_once 'model/Database.php';
require_once 'model/Affectation.php';
require_once 'tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    // En-tête
    public function Header()
    {

        // Positionner plus bas
        $this->SetY(15); // décaler le header un peu vers le bas
        // Logo
        $image_file = '../../../img/logo_veritas.jpg';
        $this->Image($image_file, 10, 10, 30, 25, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Titre
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 15, 'RECAP FICHES A DECAISSER', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
    }

    // Pied de page
    public function Footer()
    {
        $this->SetY(-15); // remonter un peu le pied de page
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 5, mb_convert_encoding('FOURNITURES INDUSTRIELLES, DEPANNAGE ET TRAVAUX PUBLIQUES', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding('Au capital de 10 000 000 F CFA - Siège Social : Abidjan, Koumassi, Zone industrielle', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding('01 BP 1642 Abidjan 01 - Téléphone : (+225) 27-21-36-27-27 - Email : info@fidest.org', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding('RCCM : CI-ABJ-2017-B-20163 - N° CC : 010274200088', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        // Numéro de page
        $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

// Initialisation
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();
$affectationObj = new Affectation($pdo);

$data = json_decode(file_get_contents('php://input'), true);
$fiches = $data['fiches'] ?? [];

$total_a_decaisser = 0;
foreach ($fiches as $fiche) {
    $total_a_decaisser += $fiche['montant_fiche'];
}

// Création du PDF
$pdf = new MYPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('FIDEST');
$pdf->SetTitle('Fiche de décaissement');
$pdf->SetMargins(10, 30, 10); // Marge supérieure augmentée à cause du header
$pdf->SetAutoPageBreak(TRUE, 35); // Marge inférieure pour le pied de page
$pdf->AddPage();

// Titre avec montant total
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Ln(5); // petit espacement
$pdf->Cell(0, 10, 'Montant total à décaisser : ' . number_format($total_a_decaisser, 0, ',', ' ') . ' XOF', 0, 1, 'C');
$pdf->Ln(5);

// Construction du tableau
$pdf->SetFont('helvetica', '', 10);
$html = '<table border="1" cellpadding="5" cellspacing="0">
    <thead>
    <tr style="background-color:#e0e0e0; color:#333; font-weight:bold;">
        <th>Bénéficiaire</th>
        <th>Montant</th>
        <th>Affectation</th>
        <th>N° Pièce</th>
        <th>Désignation</th>
        <th>Date</th>
    </tr>
    </thead><tbody>';

foreach ($fiches as $fiche) {
    $html .= "<tr>
        <td>{$fiche['beficiaire_fiche']}</td>
        <td>" . number_format($fiche['montant_fiche'], 0, ',', ' ') . " XOF</td>
        <td>{$affectationObj->getAffectationById($fiche['affectation_id'])['lib_affectation']}</td>
        <td>{$fiche['num_piece']}</td>
        <td>{$fiche['designation_fiche']}</td>
        <td>{$fiche['date_creat_fiche']}</td>
    </tr>";
}

$html .= '</tbody></table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Génération du PDF
$pdf->Output('fiches_export.pdf', 'I');
