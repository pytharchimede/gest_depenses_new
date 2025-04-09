<?php

require_once 'tcpdf/tcpdf.php';

$data = json_decode(file_get_contents('php://input'), true);
$fiches = $data['fiches'] ?? [];

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);


$html = '<h2>Liste des Fiches à Décaisser</h2>';
$html .= '<table border="1" cellpadding="4">
    <tr>
        <th>Bénéficiaire</th>
        <th>Montant</th>
        <th>Affectation</th>
        <th>N° Pièce</th>
        <th>Désignation</th>
        <th>Date</th>
    </tr>';

foreach ($fiches as $fiche) {
    $html .= "<tr>
        <td>{$fiche['beficiaire_fiche']}</td>
        <td>{$fiche['montant_fiche']}</td>
        <td>{$fiche['affectation']}</td>
        <td>{$fiche['num_piece']}</td>
        <td>{$fiche['designation_fiche']}</td>
        <td>{$fiche['date_creat_fiche']}</td>
    </tr>";
}
$html .= '
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('fiches_export.pdf', 'I');
