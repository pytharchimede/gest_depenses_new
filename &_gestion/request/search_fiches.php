<?php
require_once '../model/Database.php';
require_once '../model/Fiche.php';

$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$ficheObj = new Fiche($pdo);

// Récupérer les paramètres de la requête
$beneficiaire = $_POST['beneficiaire'] ?? '';
$statut = $_POST['statut'] ?? '';
$date_debut = $_POST['date_debut'] ?? '';
$date_fin = $_POST['date_fin'] ?? '';
$date_decaissement = $_POST['date_decaissement'] ?? '';
$chantier = $_POST['chantier'] ?? '';
$affectation = $_POST['affectation'] ?? '';

// Appel de la méthode pour récupérer les fiches filtrées
$fiches = $ficheObj->searchFiches($beneficiaire, $statut, $date_debut, $date_fin, $date_decaissement, $chantier, $affectation);

echo json_encode(['success' => true, 'fiches' => $fiches]);
