<?php
session_start();
if (isset($_SESSION['pass_hop']) && $_SESSION['pass_hop'] != '' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop'] != '') {
    include('../connex.php');

    //Enregistrememnt connexion
    $date = date("Y-m-d");
    $result = $con->prepare("INSERT INTO visite (ip, date, heure) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', '" . $date . "', '" . time() . "') ");
    $result->execute();

    $_SESSION['num_fiche'] = $_GET['num_fiche'];

?>
    <!doctype html>
    <html lang="en" id="all_page">

    <head>

        <meta charset="utf-8" />
        <title><?php include('titre_ent_1.php'); ?> | Modifier</title>
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
                                    <?php if ($_SESSION['is_valid'] == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="accepte.php" id="topnav-dashboard">
                                                <i class="icon nav-icon uil uil-check"></i>
                                                <span data-key="t-dashboards">acceptées</span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="refuse.php" id="topnav-dashboard">
                                                <i class="icon nav-icon uil uil-ban"></i>
                                                <span data-key="t-dashboards">réfusées</span>
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
                                    <?php } ?>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="point_financier.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-chart"></i>
                                            <span data-key="t-dashboards">Point financier</span>
                                        </a>
                                    </li>
                                    <?php if ($_SESSION['is_valid'] == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="point_chantier.php" id="topnav-dashboard">
                                                <i class="icon nav-icon uil uil-chart"></i>
                                                <span data-key="t-dashboards">Point chantier</span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($_SESSION['secur'] == 'melfst' || $_SESSION['secur'] == 'lol') { ?>
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
                                            <?php if ($_SESSION['is_valid'] == 1) { ?>
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

                            <?php

                            $rep = $con->prepare('SELECT * FROM fiche WHERE num_fiche=:A ORDER BY id_fiche ASC ');
                            $rep->execute(array('A' => $_SESSION['num_fiche']));


                            while ($repo = $rep->fetch()) {

                                $aff = $con->prepare('SELECT * FROM affectation WHERE id_affectation=:A');
                                $aff->execute(array('A' => $repo['affectation_id']));
                                $iaff = $aff->fetch();
                                $lib_aff = $iaff['lib_affectation'];


                                echo '
            <form name="form_modif_fiche" id="form_modif_fiche" class="form-horizontal" action="src/modif_fiche.php">
		
                <div class="row">
                <div class="col-md-4 col-xs-12">
                        <label>Fiche N° <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $repo['num_fiche'] . '"  />
                </div>
                <div class="col-md-8 col-xs-12">
                        <label>Affectation <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $lib_aff . '" />
                </div>
                </div>

                <div class="row">
                <div class="col-md-4 col-xs-12">
                        <label>Désignation <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $repo['designation_fiche'] . '"  />
                </div>
                <div class="col-md-8 col-xs-12">
                        <label>Montant <span class="semi_aste">*</span></label>
                        <input type="text" class="form-control" required id="montant_fiche" name="montant_fiche" value="' . $repo['montant_fiche'] . '" />
                </div>
                </div>

                <div class="row">
                <div class="col-md-8 col-xs-12">
                        <label>Bénéficiaire <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $repo['beficiaire_fiche'] . '"  />
                </div>
                <div class="col-md-4 col-xs-12">
                        <label>Mode de paiement <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $repo['num_piece'] . '" />
                </div>
                </div>

                <div class="row">
                <div class="col-md-6 col-xs-12">
                        <label>Téléphone <span class="semi_aste">*</span></label>
                        <input readonly type="text" class="form-control" required id="num_fiche" name="num_fiche" value="' . $repo['tel_beneficiaire_fiche'] . '"  />
                </div>
                <div class="col-md-6 col-xs-12">
                    &nbsp;
                </div>
                </div>
                
                <div class="row">&nbsp;</div>

                <div class="form-floating">
                    <textarea class="form-control" placeholder="Veuillez saisir vos commentaires ici" id="detail_refus" name="detail_refus" style="height: 100px"></textarea>
                    <label for="detail_refus">Vos commentaires</label>
                </div>
 
                
                <div class="modal-footer ajout-footer_file"> 
                <button type="submit" class="btn button_valid"><i class="fa fa-check"></i> Valider</button>&nbsp;&nbsp;
                <a href="accueil.php"><button type="button" class="btn button_annul_modif" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button></a>
                </div>
            </form>
            ';
                            }


                            ?>
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