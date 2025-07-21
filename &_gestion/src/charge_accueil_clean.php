<?php
session_start();

include('../connex.php');

ini_set('memory_limit', '512M');
ini_set('max_execution_time', 12000);

// Récupération des paramètres de recherche
$recher_date_debut = isset($_POST['recher_date_debut']) ? $_POST['recher_date_debut'] : '';
$recher_date_fin = isset($_POST['recher_date_fin']) ? $_POST['recher_date_fin'] : '';
$recher_demandeur = isset($_POST['recher_demandeur']) ? $_POST['recher_demandeur'] : '';
$recher_chantier = isset($_POST['recher_chantier']) ? $_POST['recher_chantier'] : '';
$recher_affectation = isset($_POST['recher_affectation']) ? $_POST['recher_affectation'] : '';
$recherche_inverse = isset($_POST['recherche_inverse']) ? $_POST['recherche_inverse'] : '';

// Pagination
$page_id = isset($_POST['page_id']) ? (int)$_POST['page_id'] : 0;
$records_per_page = 12;
$start = $page_id * $records_per_page;

// Sauvegarde des paramètres en session
$_SESSION["recher_date_debut"] = $recher_date_debut;
$_SESSION["recher_date_fin"] = $recher_date_fin;
$_SESSION["recher_demandeur"] = $recher_demandeur;
$_SESSION["recher_chantier"] = $recher_chantier;
$_SESSION["recher_affectation"] = $recher_affectation;
$_SESSION["recherche_inverse"] = $recherche_inverse;

// Construction de la requête
$has_filters = ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_chantier != '' || $recher_affectation != '');

if ($has_filters) {
    // Requête avec filtres
    $where_conditions = [];
    $params = [];

    if ($recher_affectation != '') {
        $operator = ($recherche_inverse == '1') ? '!=' : '=';
        $where_conditions[] = "affectation_id $operator ?";
        $params[] = $recher_affectation;
    }

    if ($recher_chantier != '') {
        $operator = ($recherche_inverse == '1') ? '!=' : '=';
        $where_conditions[] = "chantier_id $operator ?";
        $params[] = $recher_chantier;
    }

    if ($recher_demandeur != '') {
        $operator = ($recherche_inverse == '1') ? 'NOT LIKE' : 'LIKE';
        $where_conditions[] = "beficiaire_fiche $operator ?";
        $params[] = '%' . $recher_demandeur . '%';
    }

    if ($recher_date_debut != '') {
        $operator = ($recherche_inverse == '1') ? '<' : '>=';
        $where_conditions[] = "date_creat_fiche $operator ?";
        $params[] = $recher_date_debut;
    }

    if ($recher_date_fin != '') {
        $operator = ($recherche_inverse == '1') ? '>' : '<=';
        $where_conditions[] = "date_creat_fiche $operator ?";
        $params[] = $recher_date_fin;
    }

    $where_clause = implode(' AND ', $where_conditions);

    // Compter le total
    $count_query = "SELECT COUNT(*) as total FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE()";
    if (!empty($where_conditions)) {
        $count_query .= " AND " . $where_clause;
    }

    $count_stmt = $con->prepare($count_query);
    $count_stmt->execute($params);
    $count_1 = $count_stmt->fetch()['total'];

    // Récupérer les données
    $requete = "SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE()";
    if (!empty($where_conditions)) {
        $requete .= " AND " . $where_clause;
    }
    $requete .= " ORDER BY id_fiche DESC LIMIT $start, $records_per_page";

    $stmt = $con->prepare($requete);
    $stmt->execute($params);
    $records = $stmt->fetchAll();
} else {
    // Requête par défaut (toutes les fiches)
    $count_stmt = $con->query("SELECT COUNT(*) as total FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE()");
    $count_1 = $count_stmt->fetch()['total'];

    $records = $con->query("SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ORDER BY id_fiche DESC LIMIT $start, $records_per_page");
}

$count = count($records);
$HTML = '';

// Section d'en-tête avec compteur et boutons d'export
$HTML .= '<div class="flex justify-between items-center mb-6">';
$HTML .= '<div>';
$HTML .= '<p class="text-lg font-semibold text-gray-700">Nombre de fiches trouvées : <span class="text-indigo-600 font-bold">' . $count_1 . '</span></p>';
$HTML .= '</div>';
$HTML .= '<div class="flex space-x-3">';
$HTML .= '<a href="exportation/pdf/pdf_liste.php" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">';
$HTML .= '<i class="fas fa-file-pdf mr-2"></i> Export PDF';
$HTML .= '</a>';
$HTML .= '<a href="exportation/excel/export_excel.php" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">';
$HTML .= '<i class="fas fa-file-excel mr-2"></i> Export Excel';
$HTML .= '</a>';
$HTML .= '</div>';
$HTML .= '</div>';

if ($count > 0) {
    $HTML .= '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">';

    foreach ($records as $row) {
        // Récupérer l'affectation
        $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=?');
        $aff->execute([$row['affectation_id']]);
        $iaff = $aff->fetch();
        $lib_aff = $iaff ? $iaff['lib_affectation'] : 'Non définie';

        $HTML .= '<div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">';
        $HTML .= '<div class="p-6">';

        // En-tête de la carte
        $HTML .= '<div class="flex justify-between items-start mb-4">';
        $HTML .= '<h3 class="text-lg font-bold text-gray-800">Fiche N° ' . $row['num_fiche'] . '</h3>';

        // Menu déroulant
        $HTML .= '<div class="relative">';
        $HTML .= '<button onclick="toggleMenu(\'menu-' . $row['num_fiche'] . '\')" class="text-gray-400 hover:text-gray-600">';
        $HTML .= '<i class="fas fa-ellipsis-v"></i>';
        $HTML .= '</button>';
        $HTML .= '<div id="menu-' . $row['num_fiche'] . '" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">';
        $HTML .= '<a target="_blank" href="exportation/pdf/pdf_fiche.php?num_fiche=' . $row['num_fiche'] . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">';
        $HTML .= '<i class="fas fa-file-pdf mr-2"></i> Voir la fiche';
        $HTML .= '</a>';
        $HTML .= '<a target="_blank" href="exportation/pdf/pdf_detail.php?num_fiche=' . $row['num_fiche'] . '&montant=' . $row['montant_fiche'] . '&designation=' . urlencode($row['designation_fiche']) . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">';
        $HTML .= '<i class="fas fa-list mr-2"></i> Voir détails';
        $HTML .= '</a>';
        $HTML .= '</div>';
        $HTML .= '</div>';
        $HTML .= '</div>';

        // Contenu principal
        $HTML .= '<div class="flex items-start space-x-4">';

        // Photo
        $HTML .= '<div class="flex-shrink-0">';
        $photo = ($row['photo_beneficiaire'] != '') ? $row['photo_beneficiaire'] : 'default_picture.png';
        $HTML .= '<img class="w-16 h-16 rounded-full object-cover border-2 border-gray-200" src="../../img_demande/' . $photo . '" alt="Photo bénéficiaire">';
        $HTML .= '</div>';

        // Informations
        $HTML .= '<div class="flex-1">';
        $HTML .= '<h4 class="font-semibold text-gray-800 mb-1">' . htmlspecialchars($row['beficiaire_fiche']) . '</h4>';
        $HTML .= '<p class="text-sm text-indigo-600 mb-2">' . htmlspecialchars($lib_aff) . '</p>';
        $HTML .= '<p class="text-sm text-gray-600 mb-3">' . htmlspecialchars($row['designation_fiche']) . '</p>';

        // Détails en badges
        $HTML .= '<div class="space-y-2">';
        $HTML .= '<div class="flex items-center text-sm text-gray-600">';
        $HTML .= '<i class="fas fa-phone w-4 mr-2"></i>';
        $HTML .= '<span>' . htmlspecialchars($row['tel_beneficiaire_fiche']) . '</span>';
        $HTML .= '</div>';

        $HTML .= '<div class="flex items-center text-sm text-gray-600">';
        $HTML .= '<i class="fas fa-credit-card w-4 mr-2"></i>';
        $HTML .= '<span>' . htmlspecialchars($row['num_piece']) . '</span>';
        $HTML .= '</div>';

        $HTML .= '<div class="flex items-center text-sm">';
        $HTML .= '<i class="fas fa-money-bill-wave w-4 mr-2 text-green-600"></i>';
        $HTML .= '<span class="font-semibold text-green-600">' . number_format($row['montant_fiche'], 0, ',', ' ') . ' FCFA</span>';
        $HTML .= '</div>';

        $HTML .= '<div class="flex items-center text-xs text-gray-500">';
        $HTML .= '<i class="fas fa-clock w-4 mr-2"></i>';
        $HTML .= '<span>Créé le ' . date("d/m/Y H:i:s", strtotime($row['date_creat_fiche'])) . '</span>';
        $HTML .= '</div>';
        $HTML .= '</div>';

        $HTML .= '</div>';
        $HTML .= '</div>';

        // Boutons d'action
        $HTML .= '<div class="mt-4 pt-4 border-t border-gray-200">';
        $HTML .= '<div class="flex space-x-2">';

        if ($_SESSION['is_valid'] == 1) {
            $HTML .= '<a href="src/valider_fiche.php?num_fiche_valide=' . $row['num_fiche'] . '" class="flex-1 bg-green-600 text-white text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-green-700 transition-colors">';
            $HTML .= '<i class="fas fa-check mr-1"></i> Valider';
            $HTML .= '</a>';

            $HTML .= '<button onclick="reporterFiche(\'' . $row['num_fiche'] . '\')" class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">';
            $HTML .= '<i class="fas fa-flag mr-1"></i> Reporter';
            $HTML .= '</button>';

            $HTML .= '<a href="detail_refus.php?num_fiche_refuse=' . $row['num_fiche'] . '" class="flex-1 bg-red-600 text-white text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">';
            $HTML .= '<i class="fas fa-times mr-1"></i> Refuser';
            $HTML .= '</a>';
        }

        if ($_SESSION['is_modif'] == 1) {
            $HTML .= '<a target="_blank" href="modifier_fiche.php?num_fiche=' . $row['num_fiche'] . '" class="bg-orange-600 text-white text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-orange-700 transition-colors">';
            $HTML .= '<i class="fas fa-edit mr-1"></i> Modifier';
            $HTML .= '</a>';
        }

        $HTML .= '</div>';
        $HTML .= '</div>';
        $HTML .= '</div>';
        $HTML .= '</div>';
    }

    $HTML .= '</div>';
} else {
    $HTML .= '<div class="text-center py-12">';
    $HTML .= '<div class="text-gray-500">';
    $HTML .= '<i class="fas fa-inbox text-4xl mb-4"></i>';
    $HTML .= '<p class="text-lg font-medium">Aucune fiche trouvée</p>';
    $HTML .= '<p class="text-sm">Essayez de modifier vos critères de recherche</p>';
    $HTML .= '</div>';
    $HTML .= '</div>';
}

// Pagination (simple)
if ($count_1 > $records_per_page) {
    $total_pages = ceil($count_1 / $records_per_page);
    $HTML .= '<div class="mt-8 flex justify-center">';
    $HTML .= '<nav class="flex space-x-2">';

    for ($i = 0; $i < $total_pages; $i++) {
        $active_class = ($i == $page_id) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50';
        $HTML .= '<button onclick="change_page_accueil(' . $i . ')" class="px-3 py-2 text-sm font-medium rounded-md border ' . $active_class . '">' . ($i + 1) . '</button>';
    }

    $HTML .= '</nav>';
    $HTML .= '</div>';
}

echo $HTML;

// JavaScript pour la pagination
if ($has_filters) {
    echo '<script>
    function change_page_accueil(page_id) {
        var recher_date_debut = "' . $recher_date_debut . '";
        var recher_date_fin = "' . $recher_date_fin . '";
        var recher_demandeur = "' . $recher_demandeur . '";
        var recher_chantier = "' . $recher_chantier . '";
        var recher_affectation = "' . $recher_affectation . '";
        var recherche_inverse = "' . $recherche_inverse . '";

        var dataString = "page_id=" + page_id + "&recher_date_debut=" + recher_date_debut + "&recher_date_fin=" + recher_date_fin + "&recher_demandeur=" + recher_demandeur + "&recher_chantier=" + recher_chantier + "&recher_affectation=" + recher_affectation + "&recherche_inverse=" + recherche_inverse;

        $.ajax({
            type: "POST",
            url: "src/charge_accueil.php",
            data: dataString,
            cache: false,
            beforeSend: function() {
                $(".chargement").removeClass("hidden").show();
                $(".affiche_accueil").hide();
            },
            success: function(result) {
                $(".chargement").addClass("hidden").hide();
                $(".affiche_accueil").html(result).show();
            }
        });
    }
    </script>';
}

unset($con);
