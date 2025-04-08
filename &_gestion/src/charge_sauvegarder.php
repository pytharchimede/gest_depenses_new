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



if (isset($_POST['recher_etat']) && $_POST['recher_etat'] != '') {

    $recher_etat = $_POST['recher_etat'];
} else {

    $recher_etat = '';
}





if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_etat != '') {

?>

    <script>
        function change_page_sauvegarder(page_id) {



            var recher_date_debut = '<?php echo $recher_date_debut; ?>';

            var recher_date_fin = '<?php echo $recher_date_fin; ?>';

            var recher_demandeur = '<?php echo $recher_demandeur; ?>';

            var recher_chantier = '<?php echo $recher_etat; ?>';



            var dataString = 'page_id=' + page_id + '&recher_date_debut=' + recher_date_debut + '&recher_date_fin=' + recher_date_fin + '&recher_demandeur=' + recher_demandeur + '&recher_etat=' + recher_etat;



            $.ajax({

                type: "POST",

                url: "src/charge_sauvegarder.php",

                data: dataString,

                cache: false,

                beforeSend: function() {

                    $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').show();

                },

                success: function(result) {

                    $("div.chargement").html('<img src="../../img/giphy.gif" style="width:65px; height:65px;" />').hide();

                    $(".affiche_sauvegarder").html(result);

                }

            });

        }
    </script>

<?php

}



if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '' || $recher_etat != '') {



    $_SESSION["recher_date_debut"] = $recher_date_debut;

    $_SESSION["recher_date_fin"] = $recher_date_fin;

    $_SESSION["recher_demandeur"] = $recher_demandeur;

    $_SESSION["recher_etat"] = $recher_etat;





    $requete = "SELECT * FROM fiche WHERE id_fiche!=''AND etat_fiche=0 AND decaisse=0 AND  date_decaissement_minimum > CURDATE() ";



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

        $requete .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
    }



    /*

     if($recher_etat!=""){

        $requete.=" AND etat_fiche='".$recher_etat."' ";

     }

     */





    $sqlQuery = $con->query($requete);
} else {



    /*

	 $_SESSION["recher_etat"]='';

	$_SESSION["recher_date_debut"]='';

	$_SESSION["recher_date_fin"]='';

	$_SESSION["recher_statut"]='';

	$_SESSION["recher_sexe"]='';

	*/

    $sqlQuery     = $con->query("SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND  date_decaissement_minimum > CURDATE()  ");
}



$count    = $sqlQuery->rowCount();

$count_1    = $sqlQuery->rowCount();



$adjacents = 2;

$records_per_page = 12;



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

        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(1);'>&laquo; Debut</button>";

    else

        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Debut</button>";



    if ($page > 1)

        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($prev) . ");'>&laquo; Precedent&nbsp;&nbsp;</button>";

    else

        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>&laquo; Precedent&nbsp;&nbsp;</button>";



    if ($last_page < 7 + ($adjacents * 2)) {

        for ($counter = 1; $counter <= $last_page; $counter++) {

            if ($counter == $page)

                $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";

            else

                $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($counter) . ");'>$counter</button>";
        }
    } elseif ($last_page > 5 + ($adjacents * 2)) {

        if ($page < 1 + ($adjacents * 2)) {

            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {

                if ($counter == $page)

                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";

                else

                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($counter) . ");'>$counter</button>";
            }

            $pagination .= "...";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($second_last) . ");'> $second_last</button>";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($last_page) . ");'>$last_page</button>";
        } elseif ($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(1);'>1</button>";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(2);'>2</button>";

            $pagination .= "...";

            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {

                if ($counter == $page)

                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";

                else

                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($counter) . ");'>$counter</button>";
            }

            $pagination .= "..";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($second_last) . ");'>$second_last</button>";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($last_page) . ");'>$last_page</button>";
        } else {

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(1);'>1</button>";

            $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(2);'>2</button>";

            $pagination .= "..";

            for ($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++) {

                if ($counter == $page)

                    $pagination .= "<button tabindex='0' role='button' role='button' class='gridjs-currentPage'>$counter</button>";

                else

                    $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($counter) . ");'>$counter</button>";
            }
        }
    }

    if ($page < $counter - 1)

        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($next) . ");'>Suivant &raquo;</button>";

    else

        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Suivant &raquo;</span>";



    if ($page < $last_page)

        $pagination .= "<button tabindex='0' role='button' href='javascript:void(0);' onClick='change_page_sauvegarder(" . ($last_page) . ");'>Fin &raquo;</button>";

    else

        $pagination .= "<button tabindex='0' role='button' tabindex='0' role='button' title='Previous' aria-label='Previous' class='' disabled=''>Fin &raquo;</button>";



    $pagination .= "</div>";
}





if ($recher_date_debut != '' || $recher_date_fin != '' || $recher_demandeur != '') {



    $_SESSION["recher_date_debut"] = $recher_date_debut;

    $_SESSION["recher_date_fin"] = $recher_date_fin;

    $_SESSION["recher_demandeur"] = $recher_demandeur;

    $_SESSION["recher_etat"] = $recher_etat;



    $requete = "SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND  date_decaissement_minimum > CURDATE() ";



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

        $requete .= " AND beficiaire_fiche LIKE '%" . $recher_demandeur . "%' ";
    }



    /*

     if($recher_etat!=""){

        $requete.=" AND etat_fiche='".$recher_etat."' ";

     }

     */





    $requete .= " ORDER BY id_fiche DESC LIMIT $start, $records_per_page";

    $records = $con->query($requete);
} else {



    $_SESSION["recher_date_debut"] = '';

    $_SESSION["recher_date_fin"] = '';

    $_SESSION["recher_demandeur"] = '';

    $_SESSION["recher_etat"] = '';



    $records = $con->query("SELECT * FROM fiche WHERE id_fiche!='' AND etat_fiche=0 AND decaisse=0 AND  date_decaissement_minimum > CURDATE() ORDER BY id_fiche DESC LIMIT $start, $records_per_page");
}





$count  = $records->rowCount();

$HTML = '';



$HTML .= '<p class="col_titre">Nombre de fiches trouvées : <b>' . $count_1 . '</b>&nbsp;&nbsp;';



$HTML .= '

    <!--

    <a href="exportation/pdf/pdf_liste.php" target="_blank" style="font-size:20px; font-weight:600; color: #da0909" title="Générer le fichier pdf">

        <i class="fa fa-file-pdf"></i>

    </a>  &nbsp;&nbsp;&nbsp;



    <a href="exportation/excel/excel_fiche.php" target="_blank" style="font-size:20px; font-weight:600; color: #006f38" title="Générer le fichier excel">

        <i class="fa fa-file-excel"></i>

    </a> &nbsp;&nbsp;

    <a href="javascript:void()" target="_blank" style="font-size:20px; font-weight:600; color: #000000" title="Imprimer">

        <i class="fa fa-print"></i>

    </a>

    -->

</p>

<br/>

';





if ($count > 0) {





    $i = 1;

    $couleur[0] = "#ffffff";

    $couleur[1] = "#f6f6f6";

    $k = 0;





    foreach ($records as $row) {



        $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');

        $aff->execute(array('A' => $row['affectation_id']));

        $iaff = $aff->fetch();

        $lib_aff = $iaff['lib_affectation'];





        $HTML .= '

        

        <div class="col-xl-4 col-sm-6">

        <div class="card border shadow-none">

            <div class="card-body p-4">

            <div class="row">

                <h4>Fiche N° <b>' . $row['num_fiche'] . '</b></h4>

            </div>

                <div class="d-flex align-items-start">

                    <div class="flex-shrink-0 avatar rounded-circle me-4">

                        <img style="height:100px; width:100px;" src="../../img_demande/';
        if ($row['photo_beneficiaire'] != '') {
            $HTML .= $row['photo_beneficiaire'];
        } else {
            $HTML .= 'default_picture.png';
        }
        $HTML .= '" alt="" class="img-fluid rounded-circle">

                    </div>

                    <div class="flex-grow-1 overflow-hidden">

                        <h5 class="font-size-15 mb-1 text-truncate"><a href="javascript:void();" class="text-dark">

                        ' . $row['beficiaire_fiche'] . ' (' . $lib_aff . ')

                        </a></h5>

                        <h5 style="color:red;"> Décaissement prévu pour le ' . date("d/m/Y", strtotime($row['date_decaissement_minimum'])) . '</h5>

                        <p class="text-muted text-truncate mb-0" style="text-align:left;">

                        ' . $row['designation_fiche'] . '

                        <br>

                        <i class="fa fa-phone"></i> Téléphone : ' . $row['tel_beneficiaire_fiche'] . ' 

                        <br>

                        Mode de paiement : <b>' . $row['num_piece'] . '</b> 

                        <br>

                        Montant : <b style="color:green;">' . number_format($row['montant_fiche'], 0, ',', ' ') . ' FCFA</b>

                        <br>

                        <i> Fait le ' . date("d/m/Y H:i:s", strtotime($row['date_creat_fiche'])) . ' </i>

                        </p>

                    </div>

                    <div class="flex-shrink-0 dropdown">

                        <a class="text-body dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-xs"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>

                        </a>

                        <div class="dropdown-menu dropdown-menu-end">

                            <a target="_blank" href="exportation/pdf/pdf_fiche.php?num_fiche=' . $row['num_fiche'] . '" class="dropdown-item"> <i class="fa fa-file-pdf"></i> Voir la fiche</a>

                            <a target="_blank" href="exportation/pdf/pdf_detail.php?num_fiche=' . $row['num_fiche'] . '&montant=' . $row['montant_fiche'] . '&designation=' . $row['designation_fiche'] . '" class="dropdown-item"> <i class="fa fa-list"></i> Voir details</a>

                        </div>

                    </div><!-- end dropdown -->

                </div>

            </div>

            <!-- end card body -->

            <div class="btn-group btn-icon" role="group">';

        if ($_SESSION['is_valid'] == 1) {
            $HTML .= '
                    <a href="src/valider_fiche.php?num_fiche_valide=' . $row['num_fiche'] . '" class="btn btn-success"><button type="button" class="btn btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Profile"><i class="uil uil-check"></i> Anticiper le décaissement</button></a>
                     <a href="src/annuler_report.php?num_fiche_valide=' . $row['num_fiche'] . '" class="btn btn-danger"><button type="button" class="btn btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Profile"><i class="uil uil-check"></i> Annuler report</button></a>

                ';
        }

        $HTML .= '

            </div>

        </div><!-- end card -->

    </div><!-- end col -->

        

        ';



        $i++;

        $k++;
    }
} else {

    $titre = '<br />Aucune fiche trouv&eacute;e';

    $donnee = mb_convert_encoding($titre, 'UTF-8', 'ISO-8859-1');

    $HTML .= '<div align="center"><font color="#990000" style="font-size:11px;">' . $donnee . '</font></div>';
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