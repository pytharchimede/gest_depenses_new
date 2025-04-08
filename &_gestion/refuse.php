<?php
session_start();
if (isset($_SESSION['pass_hop']) && $_SESSION['pass_hop'] != '' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop'] != '') {
    include('../connex.php');

    //Enregistrememnt connexion
    $date = date("Y-m-d");
    $result = $con->prepare("INSERT INTO visite (ip, date, heure) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', '" . $date . "', '" . time() . "') ");
    $result->execute();

?>
    <!doctype html>
    <html lang="en" id="all_page">

    <head>

        <meta charset="utf-8" />
        <title><?php include('titre_ent_1.php'); ?> | Accueil</title>
        <?php include('meta.php'); ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Sweet Alert-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />

        <!-- plugin css -->
        <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min_horizontal.css" id="app-style" rel="stylesheet" type="text/css" />
        <style>
            .card {
                /*position: absolute;*/
                z-index: 9;
                /*background-color: #f1f1f1;*/
                /*border: 1px solid #d3d3d3;*/
                text-align: center;
                cursor: move;
            }

            .card:hover {
                /*position: absolute;*/
                z-index: 10;
                /*background-color: #f1f1f1;*/
                /*border: 1px solid #d3d3d3;*/
                text-align: center;
                cursor: move;
            }
        </style>

        <link rel="stylesheet" href="design/full-screen-helper.css">

    </head>


    <body data-layout="horizontal">

        <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            <header id="page-topbar">

                <!-- Notre div entete -->

                <!-- /notre div entete -->

                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="accueil.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
                                    <?php //include('titre_ent.php'); 
                                    ?>
                                    <?php //include('titre_ent_ac_sm.php'); 
                                    ?>
                                </span>
                                <span class="logo-lg">
                                    <!--<img src="assets/images/logo-dark.png" alt="" height="22">-->
                                    <?php include('titre_ent_ac.php'); ?>
                                </span>
                            </a>

                            <a href="accueil.php" class="logo logo-light">
                                <span class="logo-sm">
                                    <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
                                    <?php //include('titre_ent.php'); 
                                    ?>
                                </span>
                                <span class="logo-lg">
                                    <!--<img src="assets/images/logo-light.png" alt="" height="22">-->
                                    <?php include('titre_ent_ac.php'); ?>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>


                    <input style="margin-top:10px; height:30px; background-color:#f9f9f9; opacity:0;" type="text" class="form-control" placeholder="Veuillez saisir votre recherche (Exple: Code de formation, Code de formateur, Code de demande ou matricule du personnel)" />

                    <div class="d-flex">
                        <!--
                                                <div class="dropdown d-inline">
                                                    <a class="dropdown-toggle text-muted me-3 mb-3 align-middle" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class='bx bx-search font-size-16'></i>
                                                    </a>
    
                                                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                                                        <form class="p-2">
                                                            <div class="search-box">
                                                                <div class="position-relative">
                                                                    <input type="text"
                                                                        class="form-control rounded bg-light border-0"
                                                                        placeholder="Search...">
                                                                    <i class="bx bx-search font-size-16 search-icon"></i>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
-->
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if ($_SESSION['photo_hop'] != '') { ?>
                                    <img class="rounded-circle header-profile-user" src="photo/<?php echo $_SESSION['photo_hop']; ?>" alt="Photo de profil" />
                                <?php } else { ?>
                                    <img class="rounded-circle header-profile-user" src="photo/profile-2398782.png" alt="Photo de profil">
                                <?php } ?>
                                <span class="user-name"><?php echo $_SESSION['nom_adm_hop']; ?></span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="p-3 border-bottom fond_nom">
                                    <h6 class="mb-0 text-white"><?php echo $_SESSION['nom_adm_hop']; ?></h6>
                                    <p class="mb-0 font-size-11 text-white-50 fw-semibold"><?php echo $_SESSION['nom_type_groupe']; ?></p>
                                </div>
                                <a class="dropdown-item" href="profil/profil.php"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="parametre/parametre.php"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Paramètres</span></a>
                                <a class="dropdown-item" href="deconex.php"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Déconexion</span></a>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="topnav">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                            <div class="collapse navbar-collapse" id="topnav-menu-content">
                                <ul class="navbar-nav">

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="accueil.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-monitor"></i>
                                            <span data-key="t-dashboards">Tableau de bord</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="accepte.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-check"></i>
                                            <span data-key="t-dashboards">acceptées</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="decaisse.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-money-withdrawal"></i>
                                            <span data-key="t-dashboards">A Décaisser</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="sauvegarder.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-money-withdrawal"></i>
                                            <span data-key="t-dashboards">planifiées</span>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="point_financier.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-chart"></i>
                                            <span data-key="t-dashboards">Point financier</span>
                                        </a>
                                    </li>

                                    <?php if ($_SESSION['id_type_groupe'] == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="parametre/parametre.php" id="topnav-pages">
                                                <i class="icon nav-icon uil uil-setting" data-feather=""></i>
                                                <span data-key="t-para">Paramètres</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-shield-plus" data-feather="shield"></i>
                                            <span data-key="t-secu">Sécurité</span>
                                            <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                                            <?php if ($_SESSION['id_type_groupe'] <= 2) { ?>
                                                <a href="utilisateur/utilisateur.php" class="dropdown-item" data-key="t-eval">Utilisateurs</a>
                                                <a href="historique/historique.php" class="dropdown-item" data-key="t-eval">Traçabilité</a>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <!--
                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="javascript:void();" onclick="FullScreenHelper.request('#all_page');">
                                            <i class="icon nav-icon fa fa-arrows fa-3x"></i>&nbsp;
                                            <span>Plein écran</span> 
                                        </a>
                                    </li>
                            -->

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="row">

                        <!--Middle Col-->
                        <div class="col-lg-12">


                            <!--Formulaire de recherche-->
                            <div class="card">
                                <div class="card-body" style="position: relative;">

                                    <div class="row">

                                        <div class="col-lg-5 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Nom et Prénom(s)</b><span class="rouge">*</span></label>
                                            <input type="text" class="form-control" name="recher_demandeur" id="recher_demandeur" placeholder="Nom et Prénom(s) du demandeur">
                                        </div>

                                        <div class="col-lg-3 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Etat</b><span class="rouge">*</span></label>
                                            <select class="form-control" data-trigger id="recher_etat" name="recher_etat">
                                                <option value="0">Etat de la fiche</option>
                                                <option value="1">Acceptée</option>
                                                <option value="2">Réfusée</option>
                                                <option value="3">Sauvegardée</option>
                                                <option value="4">Décaissé</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Début</b><span class="rouge">*</span></label>
                                            <input type="datetime-local" class="form-control" name="recher_date_debut" id="recher_date_debut" placeholder="Date de début">
                                        </div>

                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Fin</b><span class="rouge">*</span></label>
                                            <input type="datetime-local" class="form-control" name="recher_date_fin" id="recher_date_fin" placeholder="Date de fin">
                                        </div>

                                        <!--<div class="col-lg-2" style="margin-top:10px; text-align:center;"><button type="submit" id="envoie_recher_pers" class="btn btn-warning envoie_recher_pers"><i class="fa fa-search"></i> Rechercher</button></div>-->
                                    </div>

                                </div>
                            </div>
                            <!--/Formulaire de recherche-->


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <h5 class="card-title">Liste des demandes
                                                            <span class="text-muted fw-normal ms-2">
                                                                (
                                                                <?php
                                                                $nf = $con->prepare('
                                                SELECT * FROM fiche WHERE etat_fiche=1 AND decaisse=0 AND sauvegarder=0 AND date_decaissement!="0000-00-00" AND date_decaissement!=""  ORDER BY id_fiche ASC 
                                                ');
                                                                $nf->execute();
                                                                $qnf = $nf->rowcount();
                                                                echo $qnf;
                                                                ?>
                                                                )</span>
                                                        </h5>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-wrap align-items-start justify-content-md-end mt-2 mt-md-0 gap-2 mb-3">

                                                        <div class="dropdown">
                                                            Exportations
                                                            <a class="btn btn-link text-dark dropdown-toggle shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="uil uil-ellipsis-h"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" target="_blank" title="exporter en pdf" href="exportation/pdf/pdf_liste_refuse.php"><i class="fa fa-file-pdf"></i> Liste des demandes refusées</a></li>
                                                            </ul>
                                                            <!-- end ul -->
                                                        </div>
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->

                                            <div class="row">
                                                <?php

                                                $rep = $con->prepare('
                SELECT * FROM fiche WHERE etat_fiche=1 AND decaisse=0 AND sauvegarder=0 AND date_decaissement!="0000-00-00" AND date_decaissement!=""  ORDER BY id_fiche ASC 
                        ');
                                                $rep->execute();


                                                while ($repo = $rep->fetch()) {

                                                    $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
                                                    $aff->execute(array('A' => $repo['affectation_id']));
                                                    $iaff = $aff->fetch();
                                                    $lib_aff = $iaff['lib_affectation'];

                                                    echo '
                                            <div class="col-xl-4 col-sm-6">
                                          
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <div class="row">
                                                        <h4>Fiche N° <b>' . $repo['num_fiche'] . '</b></h4>
                                                    </div>
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-shrink-0 avatar rounded-circle me-4">
                                                            <img style="height:100px; width:100px;" src="../../img_demande/';
                                                    if ($repo['photo_beneficiaire'] != '') {
                                                        echo $repo['photo_beneficiaire'];
                                                    } else {
                                                        echo 'default_picture.png';
                                                    }
                                                    echo '" alt="" class="img-fluid rounded-circle">
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="font-size-15 mb-1 text-truncate"><a href="pages-profile.html" class="text-dark">
                                                            ' . $repo['beficiaire_fiche'] . ' (' . $lib_aff . ')
                                                            </a></h5>
                                                            <p class="text-muted text-truncate mb-0" style="text-align:left;">
                                                            ' . $repo['designation_fiche'] . '
                                                            <br>
                                                            <i class="fa fa-phone"></i> Téléphone : ' . $repo['tel_beneficiaire_fiche'] . ' 
                                                            <br>
                                                            Mode de paiement : <b>' . $repo['num_piece'] . '</b> 
                                                            <br>
                                                            Montant : <b style="color:green;">' . number_format($repo['montant_fiche'], 0, ',', ' ') . ' FCFA</b>
                                                            <br>
                                                            <i> Fait le ' . date("d/m/Y H:i:s", strtotime($repo['date_creat_fiche'])) . ' </i>
                                                            </p>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown">
                                                            <a class="text-body dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-xs"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a target="_blank" href="exportation/pdf/pdf_fiche.php?num_fiche=' . $repo['num_fiche'] . '" class="dropdown-item"> <i class="fa fa-file-pdf"></i> Voir la fiche</a>
                                                            </div>
                                                        </div><!-- end dropdown -->
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                                <div class="btn-group btn-icon" role="group">
                                                </div>
                                            </div><!-- end card -->
                                        </div><!-- end col -->';

                                                    /*
            $aff=$con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
            $aff->execute(array('A'=>$repo['affectation_id']));
            $iaff=$aff->fetch();
            $lib_aff=$iaff['lib_affectation'];


            echo '
            <tr>
                <td>
                    '.$repo['num_fiche'].'
                </td>
                <td>
                    '.$lib_aff.'
                </td>
                <td>
                    '.$repo['designation_fiche'].'
                </td>
                <td>
                    '.number_format($repo['montant_fiche'],0,',',' ').' FCFA
                </td>
                <td>
                    '.$repo['beficiaire_fiche'].'
                </td>
                <td>
                    '.$repo['num_piece'].'
                </td>
                <td>
                    '.$repo['tel_beneficiaire_fiche'].'
                </td>
                <td>
                    <a target="_blank" href="exportation/pdf/pdf_fiche.php?num_fiche='.$repo['num_fiche'].'" class="btn btn-info"><i class="fa fa-eye"></i> Détails</a>
                </td>
            </tr>
            ';
            */
                                                }


                                                ?>
                                                </tbody>
                                                </table>
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <!--End Middle Col-->



                                    </div> <!-- end row-->

                                </div>
                                <!-- container-fluid -->
                            </div>
                            <!-- End Page-content -->

                            <footer class="footer">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <script>
                                                document.write(new Date().getFullYear())
                                            </script> &copy; BANAMUR.
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="text-sm-end d-none d-sm-block">
                                                Découvrez nos solution en <i class="mdi mdi-cubes text-danger"></i> <a href="https://www.fidest.org" target="_blank" class="text-reset">cliquant ici</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </footer>

                        </div>
                        <!-- end main content-->

                    </div>
                    <!-- END layout-wrapper -->

                    <!-- Right Sidebar -->
                    <div class="right-bar">
                        <div data-simplebar class="h-100">
                            <div class="rightbar-title d-flex align-items-center bg-dark p-3">

                                <a href="javascript:void(0);" class="right-bar-toggle-close ms-auto">
                                    <i class="mdi mdi-close noti-icon"></i>
                                </a>
                            </div>

                            <!-- Settings -->
                            <hr class="m-0" />

                            <!-- Right bar overlay-->
                            <div class="rightbar-overlay"></div>

                            <!-- JAVASCRIPT -->

                            <!-- JAVASCRIPT -->
                            <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
                            <script src="assets/libs/simplebar/simplebar.min.js"></script>
                            <script src="assets/libs/feather-icons/feather.min.js"></script>
                            <!--<script src="assets/js/pages/dashboard-sales.init.js"></script>-->

                            <script src="assets/js/app_horizontal.js"></script>

                            <!--Draggable-->
                            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                            <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
                            <script>
                                $(function() {
                                    $(".card").draggable();
                                });

                                function Hide(HideID) {
                                    HideID.style.display = "none";
                                }
                            </script>




    </body>

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>