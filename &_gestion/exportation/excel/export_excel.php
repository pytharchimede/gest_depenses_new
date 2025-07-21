<?php
session_start();
include('../../connex.php');

// Configuration de l'export Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="export_decaissement_' . date('Y-m-d_H-i-s') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');

// Récupération des variables de session
$recher_date_debut = isset($_SESSION['recher_date_debut']) ? $_SESSION['recher_date_debut'] : '';
$recher_date_fin = isset($_SESSION['recher_date_fin']) ? $_SESSION['recher_date_fin'] : '';
$recher_demandeur = isset($_SESSION['recher_demandeur']) ? $_SESSION['recher_demandeur'] : '';
$recher_chantier = isset($_SESSION['recher_chantier']) ? $_SESSION['recher_chantier'] : '';
$recher_affectation = isset($_SESSION['recher_affectation']) ? $_SESSION['recher_affectation'] : '';
$recherche_inverse = isset($_SESSION['recherche_inverse']) ? $_SESSION['recherche_inverse'] : '';

// Construction de la requête
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

echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Excel - Décaissements</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { background-color: #4CAF50; color: white; }
    </style>
</head>
<body>
    <h1>RAPPORT DE DÉCAISSEMENT - ' . date('d/m/Y') . '</h1>';

if (!empty($recher_demandeur)) {
    $mode = ($recherche_inverse == "1") ? "EXCLU" : "INCLUS";
    echo '<p>Bénéficiaire (' . $mode . ') : ' . htmlspecialchars($recher_demandeur) . '</p>';
}

echo '<table>
        <thead>
            <tr class="header">
                <th>N° Fiche</th>
                <th>Affectation</th>
                <th>Désignation</th>
                <th>Bénéficiaire</th>
                <th>Téléphone</th>
                <th>Montant</th>
                <th>Date Création</th>
                <th>Date Décaissement Min</th>
            </tr>
        </thead>
        <tbody>';

$reta = $con->prepare($req);
$reta->execute();

$total = 0;
while ($row = $reta->fetch()) {
    // Calcul du montant restant
    $montant_fiche = $row['montant_fiche'];
    $tot_dec = 0;

    $mdec = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
    $mdec->execute(array('A' => $row['num_fiche']));
    while ($imdec = $mdec->fetch()) {
        $tot_dec += $imdec['montant'];
    }

    $montant_restant = $montant_fiche - $tot_dec;
    $total += $montant_restant;

    // Récupération de l'affectation
    $affectation = "Bureau";
    if ($row['affectation_id'] == 1 && !empty($row['chantier_id'])) {
        $ch = $con->prepare('SELECT * FROM chantier WHERE id_chantier=:A');
        $ch->execute(array('A' => $row['chantier_id']));
        $ich = $ch->fetch();
        if ($ich) {
            $affectation = "Chantier " . $ich['lib_chantier'];
        }
    }

    echo '<tr>
            <td>' . htmlspecialchars($row['num_fiche']) . '</td>
            <td>' . htmlspecialchars($affectation) . '</td>
            <td>' . htmlspecialchars($row['designation_fiche']) . '</td>
            <td>' . htmlspecialchars($row['beficiaire_fiche']) . '</td>
            <td>' . htmlspecialchars($row['tel_beneficiaire_fiche']) . '</td>
            <td>' . number_format($montant_restant, 0, ',', ' ') . ' FCFA</td>
            <td>' . date('d/m/Y', strtotime($row['date_creat_fiche'])) . '</td>
            <td>' . date('d/m/Y', strtotime($row['date_decaissement_minimum'])) . '</td>
          </tr>';
}

echo '</tbody>
        <tfoot>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td colspan="5">TOTAL</td>
                <td>' . number_format($total, 0, ',', ' ') . ' FCFA</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
      </table>
</body>
</html>';
