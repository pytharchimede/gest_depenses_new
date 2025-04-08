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
        <title><?php include('titre_ent_1.php'); ?> | Décaissement</title>
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


                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="point_financier.php" id="topnav-dashboard">
                                            <i class="icon nav-icon uil uil-chart"></i>
                                            <span data-key="t-dashboards">Point financier</span>
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


                            <div class="row">
                                &nbsp;
                            </div>

                            <?php
                            $num_fiche = $_GET['num_fiche'];

                            $rep = $con->prepare('SELECT * FROM fiche LEFT JOIN affectation On affectation.id_affectation=fiche.affectation_id WHERE num_fiche=:A ');
                            $rep->execute(array('A' => $num_fiche));
                            $irep = $rep->fetch();

                            $montant = number_format($irep['montant_fiche'], 0, ',', ' ');
                            $affectation = stripslashes($irep['lib_affectation']);
                            $beneficiaire = stripslashes($irep['beficiaire_fiche']);
                            $designation_fiche = stripslashes($irep['designation_fiche']);
                            $montant_fiche = $irep['montant_fiche'];
                            $otp_valide = $irep['otp_valide'];
                            $otp = $irep['otp'];
                            $otp_autorise = $irep['otp_autorise'];

                            //Calcul financier
                            $dec = $con->prepare('SELECT * FROM decaissement WHERE num_fiche_decaissement=:A');
                            $dec->execute(array('A' => $num_fiche));
                            $tot_dec = 0;
                            while ($idec = $dec->fetch()) {
                                $tot_dec = floatval($idec['montant']) + $tot_dec;
                            }
                            $total_decaisse = $tot_dec;
                            $montant_restant = $montant_fiche - $total_decaisse;

                            $_SESSION['num_fiche_decaisse'] = $num_fiche;

                            ?>

                            <div class="container row">
                                <div class="col-md-10">
                                    <!--Formulaire de décaissement-->
                                    <div class="card card-body">
                                        <form>
                                            <div class="msg_erreur" style="margin:2px; padding:5px;"></div>
                                            <label class="form-label">Fiche N° <?php echo $num_fiche; ?></label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="beneficiare_fiche">Bénéficiaire</label>
                                                    <input readonly type="text" class="form-control" id="beneficiare_fiche" value="<?php echo $beneficiaire; ?>">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label" for="designation_fiche">Désignation</label>
                                                    <input readonly type="text" class="form-control" id="designation_fiche" value="<?php echo $designation_fiche; ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="montant_total">Montant total</label>
                                                        <input readonly type="text" class="form-control" id="montant_total" value="<?php echo number_format($montant_fiche, 0, ',', ' '); ?> FCFA">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="montant_decaisse">Montant décaissé</label>
                                                        <input readonly type="text" class="form-control" id="montant_decaisse" value="<?php echo number_format($total_decaisse, 0, ',', ' '); ?> FCFA">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="montant_restant">Montant restant</label>
                                                        <input readonly type="text" class="form-control" id="montant_restant" value="<?php echo number_format($montant_restant, 0, ',', ' '); ?> FCFA">
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                            <hr>
                                            <div class="row">
                                                <div class="mb-3 row">
                                                    <label for="montant_decaisser" class="col-md-3 col-form-label">Montant à décaisser</label>
                                                    <div class="col-md-5">
                                                        <input class="form-control" type="text" value="<?php echo $montant_restant; ?>" id="montant_decaisser" placeholder="0 FCFA">
                                                        <?php //echo ' OTP = '.$otp.' otp_autorise = '.$otp_autorise.' OTP VALIDE =  '.$otp_valide; 
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4 btn_dec">
                                                        <a href="javascript:void();" class="btn btn-danger annul_decaisse"><i class="fa fa-ban"></i> Annuler</a>
                                                        &nbsp;
                                                        <?php if ($otp_valide == 1): ?>
                                                            <a href="javascript:void();" class="btn btn-success submit_decaisse"><i class="fa fa-sign-out"></i> Décaisser</a>
                                                        <?php elseif ($otp_autorise == 1 && $otp == 0): ?>
                                                            <a href="src/envoi_otp.php?id_fiche=<?php echo $num_fiche; ?>" class="btn btn-info"><i class="fa fa-gears"></i> Générer OTP</a>
                                                        <?php elseif ($otp_autorise == 1 && $otp != 0): ?>
                                                            <a href="src/envoi_otp.php?id_fiche=<?php echo $num_fiche; ?>" class="btn btn-success"><i class="fa fa-hourglass"></i> Valider votre OTP</a>
                                                        <?php else: ?>
                                                            <!-- Mettez ici ce que vous voulez afficher si aucune condition n'est remplie -->
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            </div><!-- end row -->
                                        </form>
                                    </div>
                                    <!--/formulaire de décaissement-->
                                </div>

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


                <!--Intégration de jquery/Ajax-->
                <script type="text/javascript" src="../js/jquery_1.7.1_jquery.min.js"></script>
                <script type="text/javascript" src="js/function_decaisse.js"></script>



    </body>

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>