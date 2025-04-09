<?php
$data = json_decode(file_get_contents('php://input'), true);
$fiches = $data['fiches'] ?? [];

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="fiches_export.csv"');

// Ouvre la sortie
$output = fopen('php://output', 'w');

// Écrit les entêtes
fputcsv($output, ['Bénéficiaire', 'Montant', 'Affectation', 'N° Pièce', 'Désignation', 'Date']);

// Écrit les données
foreach ($fiches as $fiche) {
    fputcsv($output, [
        $fiche['beficiaire_fiche'],
        $fiche['montant_fiche'],
        $fiche['affectation'],
        $fiche['num_piece'],
        $fiche['designation_fiche'],
        $fiche['date_creat_fiche']
    ]);
}

fclose($output);
exit;
