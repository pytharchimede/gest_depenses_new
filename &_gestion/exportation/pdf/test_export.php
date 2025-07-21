<?php
// Test simple de l'exportation PDF
session_start();

// Simuler des données de session pour le test
$_SESSION['recher_date_debut'] = '';
$_SESSION['recher_date_fin'] = '';
$_SESSION['recher_demandeur'] = '';
$_SESSION['recher_chantier'] = '';
$_SESSION['recher_affectation'] = '';
$_SESSION['recherche_inverse'] = '';

echo "<h2>Test de l'exportation PDF</h2>";
echo "<p>Vérification des fichiers nécessaires :</p>";

$files_to_check = [
    '../../../connex.php' => 'Fichier de connexion',
    '../../../pdf/phpToPDF.php' => 'Fichier phpToPDF',
    '../../../pdf/mysql_table.php' => 'Fichier mysql_table',
    '../../../img/logo_veritas.jpg' => 'Logo Veritas',
    '../../../img/logo_connex.jpg' => 'Logo Connex'
];

$all_ok = true;

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "✅ $description : OK<br>";
    } else {
        echo "❌ $description : MANQUANT ($file)<br>";
        $all_ok = false;
    }
}

if ($all_ok) {
    echo "<p style='color: green;'>✅ Tous les fichiers sont présents. L'exportation PDF devrait fonctionner.</p>";
    echo "<a href='pdf_liste.php' target='_blank' class='btn btn-primary'>Tester l'exportation PDF</a>";
} else {
    echo "<p style='color: red;'>❌ Certains fichiers sont manquants. Veuillez les vérifier.</p>";
}

echo "<hr>";
echo "<h3>Informations de session actuelles :</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
