<?php
// Test pour vérifier que le PDF fonctionne sans erreur

session_start();

// Simuler une session avec un numéro de fiche fictif pour test
$_SESSION['num_fiche'] = 'TEST_001';
$_GET['num_fiche'] = 'TEST_001';

// Rediriger les erreurs vers un buffer pour les capturer
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Variable pour capturer les erreurs FPDF
$fpdf_errors = [];
$original_error_handler = set_error_handler(function ($severity, $message, $file, $line) use (&$fpdf_errors) {
    $fpdf_errors[] = "Error: $message in $file on line $line";
    return true;
});

echo "Test de génération PDF démarré...\n";

try {
    include('pdf_fiche.php');
    echo "PDF généré avec succès !\n";
} catch (Exception $e) {
    echo "Erreur capturée : " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "Erreur fatale capturée : " . $e->getMessage() . "\n";
}

if (!empty($fpdf_errors)) {
    echo "Erreurs FPDF capturées :\n";
    foreach ($fpdf_errors as $error) {
        echo "- $error\n";
    }
}

// Restaurer le gestionnaire d'erreur
restore_error_handler();

$output = ob_get_clean();
echo $output;

echo "Test terminé.\n";
