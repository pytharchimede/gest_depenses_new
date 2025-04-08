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
                                    <span data-key="t-dashboards">réfusées</span>
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

                                        <a class="nav-link arrow-none" href="refuse.php" id="topnav-dashboard">

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

                                        <a class="nav-link arrow-none" href="sauvegarder.php" id="topnav-dashboard">

                                            <i class="icon nav-icon uil uil-money-withdrawal"></i>

                                            <span data-key="t-dashboards">Planifiées</span>

                                        </a>

                                    </li>





                                    <li class="nav-item">

                                        <a class="nav-link arrow-none" href="point_financier.php" id="topnav-dashboard">

                                            <i class="icon nav-icon uil uil-chart"></i>

                                            <span data-key="t-dashboards">Point financier</span>

                                        </a>

                                    </li>



                                    <li class="nav-item">

                                        <a class="nav-link arrow-none" href="statistique.php" id="topnav-dashboard" style="background-color:#fabd02; color:#22254b;">

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

                                    <!--

                                    <li class="nav-item">

                                        <a class="nav-link arrow-none" href="javascript:void();" onclick="FullScreenHelper.request('#all_page');">

                                            <i class="icon nav-icon fa fa-arrows fa-3x"></i>&nbsp;

                                            <span>Plein écran</span> 

                                        </a>

                                    </li>

                            -->

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

                    <div class="container-fluid">

                        <!-- start page title -->

                        <div class="row">

                            <div class="col-12">

                                <div class="page-title-box d-flex align-items-center justify-content-between">

                                    <h4 class="mb-0">Sales Analytics</h4>



                                    <div class="page-title-right">

                                        <ol class="breadcrumb m-0">

                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashonic</a></li>

                                            <li class="breadcrumb-item active">Sales Analytics</li>

                                        </ol>

                                    </div>



                                </div>

                            </div>

                        </div>

                        <!-- end page title -->



                        <div class="row">

                            <div class="col-xl-3 col-sm-6">

                                <!-- Card -->

                                <div class="card">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <div>

                                                <h6 class="font-size-xs text-uppercase">Total Entrées</h6>

                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">

                                                    $46.34k

                                                </h4>

                                                <div class="text-muted">Tiré du déboursé</div>

                                            </div>

                                            <div>

                                                <div class="dropdown">

                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"

                                                        aria-expanded="false"><span class="text-muted">Monthly<i

                                                                class="mdi mdi-chevron-down ms-1"></i></span>

                                                    </a>



                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item" href="#">Monthly</a>

                                                        <a class="dropdown-item" href="#">Yearly</a>

                                                        <a class="dropdown-item" href="#">Weekly</a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="apex-charts mt-3" id="sparkline-chart-1"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-sm-6">

                                <!-- Card -->

                                <div class="card">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <div>

                                                <h6 class="font-size-xs text-uppercase">Total Charges</h6>

                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">

                                                    $895.02

                                                </h4>

                                                <div class="text-muted">Salaires, Décaissements etc.</div>

                                            </div>

                                            <div>

                                                <div class="dropdown">

                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"

                                                        aria-expanded="false"><span class="text-muted">Monthly<i

                                                                class="mdi mdi-chevron-down ms-1"></i></span>

                                                    </a>



                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item" href="#">Monthly</a>

                                                        <a class="dropdown-item" href="#">Yearly</a>

                                                        <a class="dropdown-item" href="#">Weekly</a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="apex-charts mt-3" id="sparkline-chart-2"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-sm-6">

                                <!-- Card -->

                                <div class="card">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <div>

                                                <h6 class="font-size-xs text-uppercase">Pointage personnel</h6>

                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">

                                                    6,985

                                                </h4>

                                                <div class="text-muted">Présences au travail</div>

                                            </div>

                                            <div>

                                                <div class="dropdown">

                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"

                                                        aria-expanded="false"><span class="text-muted">Weekly<i

                                                                class="mdi mdi-chevron-down ms-1"></i></span>

                                                    </a>



                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item" href="#">Monthly</a>

                                                        <a class="dropdown-item" href="#">Yearly</a>

                                                        <a class="dropdown-item" href="#">Weekly</a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="apex-charts mt-3" id="sparkline-chart-3"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-xl-3 col-sm-6">

                                <!-- Card -->

                                <div class="card">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <div>

                                                <h6 class="font-size-xs text-uppercase">Demandes de décaissement</h6>

                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">

                                                    12,584

                                                </h4>

                                                <div class="text-muted">Montant total des demandes</div>

                                            </div>

                                            <div>

                                                <div class="dropdown">

                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"

                                                        aria-expanded="false"><span class="text-muted">Yearly<i

                                                                class="mdi mdi-chevron-down ms-1"></i></span>

                                                    </a>



                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item" href="#">Monthly</a>

                                                        <a class="dropdown-item" href="#">Yearly</a>

                                                        <a class="dropdown-item" href="#">Weekly</a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="apex-charts mt-3" id="sparkline-chart-4"></div>

                                    </div>

                                </div>

                            </div>

                        </div> <!-- end row-->



                        <div class="row">

                            <div class="col-xl-4">

                                <div class="card">

                                    <div class="card-body">

                                        <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">

                                            <i class="uil uil-exclamation-triangle font-size-16 text-warning me-2"></i>

                                            <div class="flex-grow-1 text-truncate">

                                                Your free trial expired in <b>21</b> days.

                                            </div>

                                            <div class="flex-shrink-0">

                                                <a href="pricing-basic.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>

                                            </div>

                                        </div>



                                        <div class="row align-items-center">

                                            <div class="col-sm-7">

                                                <p class="font-size-18">Upgrade your plan from a <span class="fw-semibold">Free

                                                        trial</span>, to ‘Premium Plan’ <i class="mdi mdi-arrow-right"></i></p>

                                                <div class="mt-4">

                                                    <a href="pricing-basic.html" class="btn btn-primary">Upgrade Account!</a>

                                                </div>

                                            </div>

                                            <div class="col-sm-5">

                                                <img src="assets/images/illustrator/2.png" class="img-fluid" alt="">

                                            </div>

                                        </div>

                                    </div> <!-- end card-body-->

                                </div>

                                <!-- end card -->



                                <div class="card">

                                    <div class="card-body">

                                        <div class="float-end">

                                            <div class="dropdown">

                                                <a class="dropdown-toggle text-reset" href="#"

                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                    <span class="fw-semibold">Report By:</span> <span

                                                        class="text-muted">Monthly<i

                                                            class="mdi mdi-chevron-down ms-1"></i></span>

                                                </a>



                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <a class="dropdown-item" href="#">Yearly</a>

                                                    <a class="dropdown-item" href="#">Monthly</a>

                                                    <a class="dropdown-item" href="#">Weekly</a>

                                                    <a class="dropdown-item" href="#">Today</a>

                                                </div>

                                            </div>

                                        </div>



                                        <h4 class="card-title mb-4">Earning Reports</h4>



                                        <div class="row align-items-center">

                                            <div class="col-sm-7">

                                                <div class="row mb-3">

                                                    <div class="col-6">

                                                        <p class="text-muted mb-2">This Month</p>

                                                        <h5>$12,582<small

                                                                class="badge badge-success-subtle font-13 ms-2">+15%</small></h5>

                                                    </div>



                                                    <div class="col-6">

                                                        <p class="text-muted mb-2">Last Month</p>

                                                        <h5>$98,741</h5>

                                                    </div>

                                                </div>

                                                <p class="text-muted"><span class="text-success me-1"> 25.2%<i

                                                            class="mdi mdi-arrow-up"></i></span>From previous period</p>



                                                <div class="mt-4">

                                                    <a href="" class="btn btn-secondary-subtle btn-sm">Generate Reports <i

                                                            class="mdi mdi-arrow-right ms-1"></i></a>

                                                </div>

                                            </div> <!-- end col-->

                                            <div class="col-sm-5">

                                                <div class="mt-4 mt-0">

                                                    <div id="donut_chart" class="apex-charts" dir="ltr"></div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div> <!-- end card -->

                            </div> <!-- end col-->



                            <div class="col-xl-8">

                                <div class="card card-h-100">

                                    <div class="card-body">

                                        <div class="float-end">

                                            <div class="dropdown">

                                                <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"

                                                    aria-haspopup="true" aria-expanded="false">

                                                    <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i

                                                            class="mdi mdi-chevron-down ms-1"></i></span>

                                                </a>



                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <a class="dropdown-item" href="#">Yearly</a>

                                                    <a class="dropdown-item" href="#">Monthly</a>

                                                    <a class="dropdown-item" href="#">Weekly</a>

                                                    <a class="dropdown-item" href="#">Today</a>

                                                </div>

                                            </div>

                                        </div>

                                        <h4 class="card-title mb-4">Sales Analytics</h4>



                                        <div class="mt-1">

                                            <ul class="list-inline main-chart mb-0 text-center">

                                                <li class="list-inline-item chart-border-left me-0 border-0">

                                                    <h3 class="text-primary">$<span data-plugin="counterup">3.85k</span><span

                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Income</span>

                                                    </h3>

                                                </li>

                                                <li class="list-inline-item chart-border-left me-0">

                                                    <h3><span data-plugin="counterup">258</span><span

                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Sales</span>

                                                    </h3>

                                                </li>

                                                <li class="list-inline-item chart-border-left me-0">

                                                    <h3><span data-plugin="counterup">52</span>k<span

                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Users</span>

                                                    </h3>

                                                </li>

                                            </ul>

                                        </div>



                                        <div class="mt-3">

                                            <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>

                                        </div>

                                    </div> <!-- end card-body-->

                                </div> <!-- end card-->

                            </div> <!-- end col-->

                        </div>

                        <!-- end row -->



                        <div class="row">

                            <div class="col-xl-8">

                                <div class="card card-h-100">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <h4 class="card-title mb-4">Orders</h4>



                                            <div>

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



                                                <div class="dropdown d-inline">

                                                    <a class="dropdown-toggle text-reset mb-3" href="#"

                                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                        <span class="fw-semibold">Report By:</span> <span

                                                            class="text-muted">Monthly<i

                                                                class="mdi mdi-chevron-down ms-1"></i></span>

                                                    </a>



                                                    <div class="dropdown-menu dropdown-menu-end">

                                                        <a class="dropdown-item" href="#">Yearly</a>

                                                        <a class="dropdown-item" href="#">Monthly</a>

                                                        <a class="dropdown-item" href="#">Weekly</a>

                                                        <a class="dropdown-item" href="#">Today</a>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                        <div class="table-responsive">

                                            <table class="table table-hover table-nowrap mb-0 align-middle table-check">

                                                <thead class="table-light">

                                                    <tr>

                                                        <th class="rounded-start" style="width: 15px;">

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="checkAll">

                                                                <label class="form-check-label" for="checkAll"> </label>

                                                            </div>

                                                        </th>

                                                        <th>ID</th>

                                                        <th>Date</th>

                                                        <th>Status</th>

                                                        <th>Customer</th>

                                                        <th>Purchased</th>

                                                        <th colspan="2" class="rounded-end">Revenue</th>

                                                    </tr>

                                                    <!-- end tr -->

                                                </thead>

                                                <!-- end thead -->

                                                <tbody>

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexampleone">

                                                                <label class="form-check-label" for="flexCheckexampleone">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1018

                                                        </td>

                                                        <td>

                                                            1 Jun, 11:21

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-check-circle-outline text-success"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Paid</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-2.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Alex Fox</a>

                                                                    </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Wireframing Kit for Figma

                                                        </td>



                                                        <td>

                                                            $129.99

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexamplethree">

                                                                <label class="form-check-label" for="flexCheckexamplethree">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1017

                                                        </td>

                                                        <td>

                                                            29 May, 18:36

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-check-circle-outline text-success"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Paid</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-3.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Joya Calvert</a>

                                                                    </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Mastering the Grid <span class="text-muted">+2 more</span>

                                                        </td>



                                                        <td>

                                                            $228.88

                                                        </td>



                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexamplefour">

                                                                <label class="form-check-label" for="flexCheckexamplefour">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1016

                                                        </td>

                                                        <td>

                                                            25 May , 08:09

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i

                                                                        class="mdi mdi-arrow-left-thin-circle-outline text-warning"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Refunded</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-4.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Gracyn Make</a>

                                                                    </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Wireframing Kit for Figma

                                                        </td>



                                                        <td>

                                                            $9.99

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexamplefive">

                                                                <label class="form-check-label" for="flexCheckexamplefive">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1015

                                                        </td>

                                                        <td>

                                                            19 May , 14:09

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-check-circle-outline text-success"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Paid</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-5.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Monroe Mock</a>

                                                                    </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Spiashify 2.0

                                                        </td>



                                                        <td>

                                                            $44.00

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexamplesix">

                                                                <label class="form-check-label" for="flexCheckexamplesix">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1014

                                                        </td>

                                                        <td>

                                                            10 May , 10:00

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-check-circle-outline text-success"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Paid</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-6.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Lauren Bond</a>

                                                                    </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Mastering the Grid

                                                        </td>



                                                        <td>

                                                            $75.87

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckexamplenine">

                                                                <label class="form-check-label" for="flexCheckexamplenine">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1011

                                                        </td>

                                                        <td>

                                                            29 Apr , 12:46

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-close-circle-outline text-danger"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Changeback</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-9.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Ricardo Schaefer</a> </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Spiashify 2.0

                                                        </td>



                                                        <td>

                                                            $63.99

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->

                                                    <tr>

                                                        <td>

                                                            <div class="form-check">

                                                                <input class="form-check-input font-size-16" type="checkbox"

                                                                    value="" id="flexCheckDefaultexample">

                                                                <label class="form-check-label" for="flexCheckDefaultexample">

                                                                </label>

                                                            </div>

                                                        </td>

                                                        <td class="fw-medium">

                                                            #DK1010

                                                        </td>

                                                        <td>

                                                            27 Apr , 10:53

                                                        </td>



                                                        <td>

                                                            <div class="d-flex">

                                                                <div class="me-2">

                                                                    <i class="mdi mdi-check-circle-outline text-success"></i>

                                                                </div>

                                                                <div>

                                                                    <p class="mb-0">Paid</p>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            <div class="d-flex align-items-center">

                                                                <div class="me-2">

                                                                    <img src="assets/images/users/avatar-10.jpg"

                                                                        class="avatar-sm img-thumbnail h-auto rounded-circle"

                                                                        alt="Error">

                                                                </div>

                                                                <div>

                                                                    <h5 class="font-size-14 text-truncate mb-0"><a href="#"

                                                                            class="text-reset">Arvi Hasan</a> </h5>

                                                                </div>

                                                            </div>

                                                        </td>

                                                        <td>

                                                            Wireframing Kit for Figma

                                                        </td>



                                                        <td>

                                                            $51.00

                                                        </td>

                                                        <td>

                                                            <div class="dropdown">

                                                                <a href="#" class="dropdown-toggle card-drop"

                                                                    data-bs-toggle="dropdown" aria-expanded="false">

                                                                    <i

                                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>

                                                                </a>

                                                                <ul class="dropdown-menu dropdown-menu-end">

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-pencil font-size-16 text-success me-1"></i>

                                                                            Edit</a></li>

                                                                    <li><a href="#" class="dropdown-item"><i

                                                                                class="mdi mdi-trash-can font-size-16 text-danger me-1"></i>

                                                                            Delete</a></li>

                                                                </ul>

                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <!-- end /tr -->



                                                </tbody><!-- end tbody -->

                                            </table><!-- end table -->

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <div class="col-xl-4">

                                <div class="card card-h-100">

                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">

                                            <h4 class="card-title mb-4">Sales by County</h4>

                                            <div class="dropdown">

                                                <a class="dropdown-toggle text-reset" href="#"

                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                                    <span class="fw-semibold">Report By:</span> <span

                                                        class="text-muted">Monthly<i

                                                            class="mdi mdi-chevron-down ms-1"></i></span>

                                                </a>



                                                <div class="dropdown-menu dropdown-menu-end">

                                                    <a class="dropdown-item" href="#">Yearly</a>

                                                    <a class="dropdown-item" href="#">Monthly</a>

                                                    <a class="dropdown-item" href="#">Weekly</a>

                                                    <a class="dropdown-item" href="#">Today</a>

                                                </div>

                                            </div>

                                        </div>



                                        <div id="world-map-markers" style="height: 242px;"></div>



                                        <div class="pt-3 pb-2">

                                            <p class="mb-0 fw-medium">USA <span class="float-end">75%</span></p>

                                            <div class="progress animated-progess custom-progress mt-2">

                                                <div class="progress-bar" role="progressbar"

                                                    style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="75">

                                                </div>

                                            </div>



                                            <p class="mt-4 mb-0 fw-medium">Russia <span class="float-end">55%</span></p>

                                            <div class="progress animated-progess custom-progress mt-2">

                                                <div class="progress-bar" role="progressbar"

                                                    style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="55">

                                                </div>

                                            </div>



                                            <p class="mt-4 mb-0 fw-medium">Australia <span class="float-end">85%</span></p>

                                            <div class="progress animated-progess custom-progress mt-2">

                                                <div class="progress-bar" role="progressbar"

                                                    style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="85">

                                                </div>

                                            </div>

                                        </div>



                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- end row -->



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





                <!-- apexcharts -->

                <script src="assets/libs/apexcharts/apexcharts.min.js"></script>



                <!-- Vector map-->

                <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

                <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>



                <script src="assets/js/pages/dashboard-sales.init.js"></script>



                <!--Intégration de jquery/Ajax-->

                <script type="text/javascript" src="../js/jquery_1.7.1_jquery.min.js"></script>

                <script type="text/javascript" src="js/function_accueil.js"></script>





    </body>



    </html>

<?php

} else {

    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}

?>