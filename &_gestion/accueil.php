<?php
session_start();
if (isset($_SESSION['pass_hop']) && $_SESSION['pass_hop'] != '' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop'] != '') {
    include('../connex.php');
    if ($_SESSION['is_planif'] == 1) {
        header('Location: accueil_planning.php');
    }
    if ($_SESSION['is_resp'] == 1) {
        header('Location: accueil_approbation.php');
    }
    //Enregistrememnt connexion
    $date = date("Y-m-d");
    $result = $con->prepare("INSERT INTO visite (ip, date, heure) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', '" . $date . "', '" . time() . "') ");
    $result->execute();
?>
    <!doctype html>
    <html lang="en" id="all_page">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <title><?php include('titre_ent_1.php'); ?> | Accueil</title>
        <?php include('meta.php'); ?>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/jvectormap@2.0.5/jquery-jvectormap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min_horizontal.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>

    <body data-layout="horizontal">
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="accueil.php" class="logo logo-dark">
                                <span class="logo-sm">
                                </span>
                                <span class="logo-lg">
                                    <?php include('titre_ent_ac.php'); ?>
                                </span>
                            </a>
                            <a href="accueil.php" class="logo logo-light">
                                <span class="logo-lg">
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
                                        <a class="nav-link arrow-none" href="accueil.php" id="topnav-dashboard" style="background-color:#fabd02; color:#22254b;">
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
                                        <a class="nav-link arrow-none" href="sauvegarder.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-ban"></i>
                                            <span data-key="t-dashboards">Planifiées</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="decaisse.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-money-withdrawal"></i>
                                            <span data-key="t-dashboards">A Décaisser</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="point_financier.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-chart"></i>
                                            <span data-key="t-dashboards">Point financier</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="statistique.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-calculator"></i>
                                            <span data-key="t-dashboards">Statistique</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="point_chantier.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-chart"></i>
                                            <span data-key="t-dashboards">Point chantier</span>
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

                                    <?php if ($_SESSION['is_valid'] == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="accueil_approbation.php" id="topnav-dashboard">
                                                <i style="color:orange;" class="icon nav-icon fa fa-spinner fa-spin"></i>
                                                <span data-key="t-dashboards"></span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <?php if ($_SESSION['verif_conforme'] == 1) { ?>
                                        <li class="nav-item">
                                            <a class="nav-link arrow-none" href="accueil_verif_conforme.php" id="topnav-dashboard">
                                                <i style="color:orange;" class="icon nav-icon fa fa-spinner fa-spin"></i>
                                                <span data-key="t-dashboards"></span>
                                            </a>
                                        </li>
                                    <?php } ?>
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
                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Affectation</b></label>
                                            <select <?php if ($_SESSION['resp_logistique'] == 1 || $_SESSION['resp_technique'] == 1 || $_SESSION['resp_bureau'] == 1 || $_SESSION['resp_rh'] == 1) {
                                                        echo ' disabled ';
                                                    } ?> class="form-control" data-trigger id="recher_affectation" name="recher_affectation">
                                                <option value="">Choisir une affectation</option>
                                                <?php
                                                $red = $con->prepare("SELECT * FROM affectation ORDER BY lib_affectation ASC");
                                                $red->execute();
                                                while ($ro = $red->fetch()) {
                                                ?>
                                                    <option value="<?php echo '' . $ro['id_affectation'] . ''; ?>" <?php if ($_SESSION['resp_rh'] == 1 && $ro['id_affectation'] == 28) {
                                                                                                                        echo ' selected';
                                                                                                                    }
                                                                                                                    if ($_SESSION['resp_logistique'] == 1 && $ro['id_affectation'] == 20) {
                                                                                                                        echo ' selected';
                                                                                                                    }
                                                                                                                    if ($_SESSION['resp_technique'] == 1 && $ro['id_affectation'] == 1) {
                                                                                                                        echo ' selected';
                                                                                                                    }
                                                                                                                    if ($_SESSION['resp_bureau'] == 1 && ($ro['id_affectation'] == 18 || $ro['id_affectation'] == 19)) {
                                                                                                                        echo ' selected';
                                                                                                                    }  ?>><?php echo '' . stripslashes($ro['lib_affectation']) . ''; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Chantier</b></label>
                                            <select class="form-control" data-trigger id="recher_chantier" name="recher_chantier">
                                                <option value="">Choisir un chantier</option>

                                                <?php

                                                $red = $con->prepare("SELECT * FROM chantier ORDER BY lib_chantier ASC");
                                                $red->execute();
                                                while ($ro = $red->fetch()) {
                                                ?>
                                                    <option value="<?php echo '' . $ro['id_chantier'] . ''; ?>"><?php echo '' . stripslashes($ro['lib_chantier']) . ''; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Nom et Prénom(s)</b></label>
                                            <input type="text" class="form-control" name="recher_demandeur" id="recher_demandeur" placeholder="Nom et Prénom(s) du demandeur">
                                        </div>
                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Début</b></label>
                                            <input type="datetime-local" class="form-control" name="recher_date_debut" id="recher_date_debut" placeholder="Date de début">
                                        </div>
                                        <div class="col-lg-2 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Fin</b></label>
                                            <input type="datetime-local" class="form-control" name="recher_date_fin" id="recher_date_fin" placeholder="Date de fin">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/Formulaire de recherche-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <!--Contenu page-->
                                        <div class="chargement" style="text-align:center; margin-top:70px"></div>
                                        <div class="affiche_accueil row"></div>
                                        <!--/contenu page-->
                                    </div><!-- end row -->
                                </div><!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!--End Middle Col-->
                    </div> <!-- end row-->



                </div>
                <!-- container-fluid -->
                <!-- Popup Modal -->
                <div class="modal fade" id="reporterModal' . $row['num_fiche'] . '" tabindex="-1" aria-labelledby="reporterModalLabel' . $row['num_fiche'] . '" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="reporterModalLabel' . $row['num_fiche'] . '">Reporter la fiche N° ' . $row['num_fiche'] . '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="reportForm' . $row['num_fiche'] . '" method="POST" action="reporter_fiche.php">
                                    <div class="mb-3">
                                        <label for="reportDate' . $row['num_fiche'] . '" class="form-label">Nouvelle date de décaissement</label>
                                        <input type="date" class="form-control" id="reportDate' . $row['num_fiche'] . '" name="new_date" required>
                                    </div>
                                    <input type="hidden" name="num_fiche" value="' . $row['num_fiche'] . '">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                <!-- Inclure jQuery avant tout -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- jQuery UI pour les fonctionnalités comme draggable -->
                <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
                <!-- Inclure Bootstrap après jQuery -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                <!-- Autres bibliothèques comme Simplebar et Feather Icons -->
                <link href="https://cdn.jsdelivr.net/npm/simplebar@5.3.6/dist/simplebar.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/simplebar@5.3.6/dist/simplebar.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
                <!-- Scripts spécifiques à votre application -->
                <script src="assets/js/app_horizontal.js"></script>
                <script src="js/function_accueil.js"></script>

    </body>

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>