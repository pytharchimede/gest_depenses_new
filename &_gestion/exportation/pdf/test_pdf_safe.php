<?php
// Test des fonctions de sécurité PDF
session_start();

// Simuler un numéro de fiche pour le test
$_SESSION['num_fiche'] = '010158';

// Inclure le fichier principal pour tester
include('pdf_fiche.php');

echo "Test de génération PDF terminé. Vérifiez si le PDF a été généré sans erreur FPDF.";
