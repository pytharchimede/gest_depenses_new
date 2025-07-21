<?php
session_start();

include('../../../logi/connex.php');

ini_set('memory_limit', '512M');
ini_set('max_execution_time', 12000);

if (isset($_POST['recher_date_debut']) && $_POST['recher_date_debut'] != '') {
    $recher_date_debut = $_POST['recher_date_debut'];
} else {
    $recher_date_debut = '';
}

if (isset($_POST['recher_date_fin']) && $_POST['recher_date_fin'] != '') {
    $recher_date_fin = $_POST['recher_date_fin'];
} else {
    $recher_date_fin = '';
}

if (isset($_POST['recher_demandeur']) && $_POST['recher_demandeur'] != '') {
    $recher_demandeur = $_POST['recher_demandeur'];
} else {
    $recher_demandeur = '';
}

if (isset($_POST['recher_chantier']) && $_POST['recher_chantier'] != '') {
    $recher_chantier = $_POST['recher_chantier'];
} else {
    $recher_chantier = '';
}

if (isset($_POST['recher_affectation']) && $_POST['recher_affectation'] != '') {
    $recher_affectation = $_POST['recher_affectation'];
} else {
    $recher_affectation = '';
}

if (isset($_POST['recherche_inverse']) && $_POST['recherche_inverse'] != '') {
    $recherche_inverse = $_POST['recherche_inverse'];
} else {
    $recherche_inverse = '';
}

if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_chantier != '' || $recher_affectation != '') {
?>
    <script>
        function change_page_accueil(page_id) {

            var recher_date_debut = '<?php echo $recher_date_debut; ?>';
            var recher_date_fin = '<?php echo $recher_date_fin; ?>';
            var recher_demandeur = '<?php echo $recher_demandeur; ?>';
            var recher_chantier = '<?php echo $recher_chantier; ?>';
            var recher_affectation = '<?php echo $recher_affectation; ?>';
            var recherche_inverse = '<?php echo $recherche_inverse; ?>';

            var dataString = 'page_id=' + page_id + '&recher_date_debut=' + recher_date_debut + '&recher_date_fin=' + recher_date_fin + '&recher_demandeur=' + recher_demandeur + '&recher_chantier=' + recher_chantier + '&recher_affectation=' + recher_affectation + '&recherche_inverse=' + recherche_inverse;

            $.ajax({
                type: "POST",
                url: "src/charge_accueil.php",
                data: dataString,
                cache: false,
                beforeSend: function() {
                    $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').show();
                },
                success: function(result) {
                    $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').hide();
                    $(".affiche_accueil").html(result);
                }
            });
        }
    </script>
<?php
}

if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_chantier != '' || $recher_affectation != '') {

    $_SESSION["recher_date_debut"] = $recher_date_debut;
    $_SESSION["recher_date_fin"] = $recher_date_fin;
    $_SESSION["recher_demandeur"] = $recher_demandeur;
    $_SESSION["recher_chantier"] = $recher_chantier;
    $_SESSION["recher_affectation"] = $recher_affectation;
    $_SESSION["recherche_inverse"] = $recherche_inverse;

    $requete = "SELECT * FROM fiche WHERE id_fiche!=''AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ";

    if ($_SESSION['secur_hop'] != 'dgfidest' && $_SESSION['secur_hop'] != 'lol') {
        $requete .= ' AND affectation_id!=29 AND affectation_id!=30 ';
    }

    if ($recher_date_debut != "") {
        $requete .= " AND date_creat_fiche>='" . $recher_date_debut . "'  ";
    }

    if ($recher_date_fin != "") {
        $requete .= " AND date_creat_fiche<='" . $recher_date_fin . "' ";
    }

    if ($recher_demandeur != "") {
        if ($recherche_inverse == "1") {
            $requete .= " AND beficiaire_fiche NOT LIKE '%" . $recher_demandeur . "%' ";
        } else {
            $requete .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
        }
    }

    if ($recher_chantier != "") {
        $requete .= " AND chantier_id='" . $recher_chantier . "' ";
    }

    if ($recher_affectation != "") {
        $requete .= " AND affectation_id='" . $recher_affectation . "' ";
    }

    $sqlQuery = $con->query($requete);
} else {
    $sqlQuery     = $con->query("SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ");
}

$count    = $sqlQuery->rowCount();
$count_1    = $sqlQuery->rowCount();

$adjacents = 2;
$records_per_page = 1000;

$page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);
$page = ($page == 0 ? 1 : $page);
$start = ($page - 1) * $records_per_page;

$next = $page + 1;
$prev = $page - 1;
$last_page = ceil($count / $records_per_page);
$second_last = $last_page - 1;

$pagination = "";

if ($last_page > 1) {

    $pagination .= "<div class='gridjs-pages'>";

    if ($page > 1)
        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(1);'>&laquo; Debut</button>";
    else
        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Debut</button>";

    if ($page > 1)
        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($prev) . ");'>&laquo; Precedent&nbsp;&nbsp;</button>";
    else
        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Precedent&nbsp;&nbsp;</button>";

    if ($last_page < 7 + ($adjacents * 2)) {
        for ($counter = 1; $counter <= $last_page; $counter++) {
            if ($counter == $page)
                $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
            else
                $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($counter) . ");'>$counter</button>";
        }
    } elseif ($last_page > 5 + ($adjacents * 2)) {
        if ($page < 1 + ($adjacents * 2)) {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                if ($counter == $page)
                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                else
                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($counter) . ");'>$counter</button>";
            }
            $pagination .= "...";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($second_last) . ");'> $second_last</button>";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($last_page) . ");'>$last_page</button>";
        } elseif ($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(1);'>1</button>";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(2);'>2</button>";
            $pagination .= "...";

            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                if ($counter == $page)
                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                else
                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($counter) . ");'>$counter</button>";
            }
            $pagination .= "..";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($second_last) . ");'>$second_last</button>";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($last_page) . ");'>$last_page</button>";
        } else {
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(1);'>1</button>";
            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(2);'>2</button>";
            $pagination .= "..";

            for ($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++) {
                if ($counter == $page)
                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";
                else
                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($counter) . ");'>$counter</button>";
            }
        }
    }

    if ($page < $counter - 1)
        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($next) . ");'>Suivant &raquo;</button>";
    else
        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Suivant &raquo;</span>";

    if ($page < $last_page)
        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_accueil(" . ($last_page) . ");'>Fin &raquo;</button>";
    else
        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Fin &raquo;</button>";

    $pagination .= "</div>";
}

if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_chantier != '' || $recher_affectation != '') {

    $_SESSION["recher_date_debut"] = $recher_date_debut;
    $_SESSION["recher_date_fin"] = $recher_date_fin;
    $_SESSION["recher_demandeur"] = $recher_demandeur;
    $_SESSION["recher_chantier"] = $recher_chantier;
    $_SESSION["recher_affectation"] = $recher_affectation;
    $_SESSION["recherche_inverse"] = $recherche_inverse;

    $requete = "SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ";

    if ($_SESSION['secur_hop'] != 'dgfidest' && $_SESSION['secur_hop'] != 'lol') {
        $requete .= ' AND affectation_id!=29 AND affectation_id!=30 ';
    }

    if ($recher_date_debut != "") {
        $requete .= " AND date_creat_fiche>='" . $recher_date_debut . "'  ";
    }

    if ($recher_date_fin != "") {
        $requete .= " AND date_creat_fiche<='" . $recher_date_fin . "' ";
    }

    if ($recher_demandeur != "") {
        if ($recherche_inverse == "1") {
            $requete .= " AND beficiaire_fiche NOT LIKE '%" . $recher_demandeur . "%' ";
        } else {
            $requete .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
        }
    }

    if ($recher_chantier != "") {
        $requete .= " AND chantier_id='" . $recher_chantier . "' ";
    }

    if ($recher_affectation != "") {
        $requete .= " AND affectation_id='" . $recher_affectation . "' ";
    }

    $requete .= " ORDER BY id_fiche DESC LIMIT $start, $records_per_page";
    $records = $con->query($requete);
} else {

    $_SESSION["recher_date_debut"] = '';
    $_SESSION["recher_date_fin"] = '';
    $_SESSION["recher_demandeur"] = '';
    $_SESSION["recher_chantier"] = '';
    $_SESSION["recher_affectation"] = '';
    $_SESSION["recherche_inverse"] = '';

    $records = $con->query("SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND sauvegarder=0 AND approuve=1 AND date_decaissement_minimum <= CURDATE() ORDER BY id_fiche DESC LIMIT $start, $records_per_page");
}

$count  = $records->rowCount();
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

    $i = 1;
    $k = 0;

    foreach ($records as $row) {

        $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
        $aff->execute(array('A' => $row['affectation_id']));
        $iaff = $aff->fetch();
        $lib_aff = $iaff['lib_affectation'];

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
        $HTML .= '<a target="_blank" href="exportation/pdf/pdf_detail.php?num_fiche=' . $row['num_fiche'] . '&montant=' . $row['montant_fiche'] . '&designation=' . $row['designation_fiche'] . '" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">';
        $HTML .= '<i class="fas fa-list mr-2"></i> Voir détails';
        $HTML .= '</a>';
        $HTML .= '</div>';
        $HTML .= '</div>';
        $HTML .= '</div>';
        
        // Contenu principal
        $HTML .= '<div class="flex items-start space-x-4">';
        
        // Photo
        $HTML .= '<div class="flex-shrink-0">';
        $HTML .= '<img class="w-16 h-16 rounded-full object-cover border-2 border-gray-200" src="../../img_demande/';
        if ($row['photo_beneficiaire'] != '') {
            $HTML .= $row['photo_beneficiaire'];
        } else {
            $HTML .= 'default_picture.png';
        }
        $HTML .= '" alt="Photo bénéficiaire">';
        $HTML .= '</div>';
        
        // Informations
        $HTML .= '<div class="flex-1">';
        $HTML .= '<h4 class="font-semibold text-gray-800 mb-1">' . $row['beficiaire_fiche'] . '</h4>';
        $HTML .= '<p class="text-sm text-indigo-600 mb-2">' . $lib_aff . '</p>';
        $HTML .= '<p class="text-sm text-gray-600 mb-3">' . $row['designation_fiche'] . '</p>';
        
        // Détails en badges
        $HTML .= '<div class="space-y-2">';
        $HTML .= '<div class="flex items-center text-sm text-gray-600">';
        $HTML .= '<i class="fas fa-phone w-4 mr-2"></i>';
        $HTML .= '<span>' . $row['tel_beneficiaire_fiche'] . '</span>';
        $HTML .= '</div>';
        
        $HTML .= '<div class="flex items-center text-sm text-gray-600">';
        $HTML .= '<i class="fas fa-credit-card w-4 mr-2"></i>';
        $HTML .= '<span>' . $row['num_piece'] . '</span>';
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
                ';
        }
        
        $HTML .= '</div>';
        $HTML .= '</div>';
        $HTML .= '</div>';
        
        $i++;
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

$HTML .= '</div>';

echo $HTML;
echo $pagination;
echo '<br /><br />';
unset($con);

?>

<script src="../assets/libs/tabletolist/tableToList.js"></script>
<script>
    $(function() {
        getList('#list_trait', '#parent');
    });
</script>