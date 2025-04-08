<?php
session_start();
if( isset($_SESSION['pass_hop']) && $_SESSION['pass_hop']!='' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop']!='')
{
include('../connex.php');

//Enregistrememnt connexion
$date=date("Y-m-d");
$result= $con->prepare("INSERT INTO visite (ip, date, heure) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$date."', '".time()."') ");      
$result->execute();

//Usage global du budget
$bud=$con->prepare('SELECT * FROM budget LEFT JOIN budget_service ON budget.code_budget=budget_service.budget_code_service LEFT JOIN service ON budget_service.service_id_budget=service.id_service WHERE actif_budget=0');
$bud->execute();
$ibud=$bud->fetch();

$valeur_initiale_budget=$ibud['valeur_initiale_budget'];
$valeur_actuelle_budget=$ibud['valeur_actuelle_budget'];

//Répartition du budget par service
$bud_serv=$con->prepare('SELECT * FROM budget LEFT JOIN budget_service ON budget.code_budget=budget_service.budget_code_service LEFT JOIN service ON budget_service.service_id_budget=service.id_service WHERE actif_budget=0');
$bud_serv->execute();

/*
while($ibud_serv=$bud_serv->fetch())
{
   
    if($ibud_serv['id_service']==1)
    {
        $serv_commercial=floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
    }

    if($ibud_serv['id_service']==2)
    {
        $serv_comptable=floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
    }

    if($ibud_serv['id_service']==3)
    {
        $serv_GRH=floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
    }

    if($ibud_serv['id_service']==4)
    {
        $serv_informatique=floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
    }

    if($ibud_serv['id_service']==5)
    {
        $direction=floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
    }
}
*/


?>
<!doctype html>
<html lang="en" id="all_page">

    <head>

        <meta charset="utf-8" />
         <title><?php include('titre_ent_1.php'); ?>  | Accueil</title>
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
        .card{
            /*position: absolute;*/
            z-index: 9;
            /*background-color: #f1f1f1;*/
            /*border: 1px solid #d3d3d3;*/
            text-align: center;
            cursor: move;
        }    
        .card:hover{
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

            <div class="navbar-header" >
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="accueil.php" class="logo logo-dark">
                            <span class="logo-sm">
                                <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
                                <?php //include('titre_ent.php'); ?>
                                <?php //include('titre_ent_ac_sm.php'); ?>
                            </span>
                            <span class="logo-lg">
                                <!--<img src="assets/images/logo-dark.png" alt="" height="22">-->
                                <?php include('titre_ent_ac.php'); ?> 
                            </span>
                        </a>

                        <a href="accueil.php" class="logo logo-light">
                            <span class="logo-sm">
                                <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
                                <?php //include('titre_ent.php'); ?>
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

                
                <input style="margin-top:10px; height:30px; background-color:#f9f9f9; opacity:0;" type="text" class="form-control" placeholder="Veuillez saisir votre recherche (Exple: Code de formation, Code de formateur, Code de demande ou matricule du personnel)"/>

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
                            <?php if($_SESSION['photo_hop']!=''){ ?>
                            <img class="rounded-circle header-profile-user" src="photo/<?php echo $_SESSION['photo_hop']; ?>" alt="Photo de profil"/>
							<?php }else{ ?> 
							<img class="rounded-circle header-profile-user" src="photo/profile-2398782.png" alt="Photo de profil">
							<?php } ?> 
                            <span class="user-name"><?php echo $_SESSION['nom_adm_hop']; ?></span>
                        </button>
                        
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="p-3 border-bottom fond_nom" >
                                    <h6 class="mb-0 text-white"><?php echo $_SESSION['nom_adm_hop']; ?></h6>
                                    <p class="mb-0 font-size-11 text-white-50 fw-semibold"><?php echo $_SESSION['nom_type_groupe']; ?></p>
                                </div>
                            <a class="dropdown-item" href="profil/profil.php"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Paramètres</span></a>
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
                                    <?php if($_SESSION['id_type_groupe']<=2){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="personnel/personnel.php" id="topnav-pages" >
                                            <i class="icon nav-icon uil uil-users-alt" data-feather=""></i>
                                            <span data-key="t-rh">Ressources humaines</span> 
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link arrow-none" href="budget/budget.php" id="topnav-pages">
                                            <i class="icon nav-icon uil uil-credit-card" data-feather=""></i>
                                            <span data-key="t-fin">Budget</span> 
                                        </a>
                                    </li>
                                    <?php } ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-book-reader" data-feather=""></i>
                                            <span data-key="t-form">Formation</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="demande_formation/demande_formation.php" class="dropdown-item" data-key="t-dem">Demandes</a>
                                            <?php if($_SESSION['id_type_groupe']<=2){ ?>
                                            <a href="formateur/formateur.php" class="dropdown-item" data-key="t-forma">formateurs</a>
                                            <?php } ?>
                                            <a href="formation/formation.php" class="dropdown-item" data-key="t-form">formations</a>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-star" data-feather=""></i>
                                            <span data-key="t-form">Evaluation</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="evaluation/evaluation.php" class="dropdown-item" data-key="t-eval">Evaluations</a>
                                            <?php if($_SESSION['id_type_groupe']<=2){ ?>
                                            <a href="evaluation/fiche.php" class="dropdown-item" data-key="t-fiche">Fiches d'évaluation</a>
                                            <a href="statistique/statistique.php" class="dropdown-item" data-key="t-stat">Statistiques</a>
                                            <?php } ?>
                                        </div>
                                    </li>
                                    <?php if($_SESSION['id_type_groupe']==1){ ?>
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
                                            <span data-key="t-secu">Sécurité</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                                            <?php if($_SESSION['id_type_groupe']<=2){ ?>
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

                    <!--Contenu de la page-->
                    <!--
                    <div class="row" style="background-color:green__;">
                        <div class="progress" style="height: 30px; margin:5px;">
                            <div class="progress-bar" role="progressbar" style="width: 80%; background-color:#16424d;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80 %</div>
                        </div>
                    </div>
                                            -->
                    <div class="row">
                     <!--col right -->
                            <div class="col-lg-4">
                            <ul class="list-group">
                                <a href="javascript:void();"><li class="list-group-item mod_termine" style="opacity:0.7;"><i class="uil uil-check-circle"></i>&nbsp;Module 1 : <b>INTRODUCTION</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item " style="opacity:0.7;"><i class="uil uil-check-circle"></i>&nbsp;Module 2 : <b>LES BASES</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item mod_encours" style="background-color:#ffa829; color:#fff; "><i class="uil uil-check-circle"></i>&nbsp;Module 3 : <b>LA PRATIQUE</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item mod_avenir" style=" "><i class="uil uil-circle"></i>&nbsp;Module 4 : <b>MISE EN SITUATION FICTIVE</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item " style=" "><i class="uil uil-circle"></i>&nbsp;Module 5 : <b>MISE EN SITUATION FICTIVE</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item " style=" "><i class="uil uil-circle"></i>&nbsp;Module 5 : <b>MISE EN SITUATION FICTIVE</b></li></a>
                                <a href="javascript:void();"><li class="list-group-item " style=" "><i class="uil uil-circle"></i>&nbsp;Module 6 : <b>MISE EN SITUATION FICTIVE</b></li></a>
                            </ul>
                            </div>
                            <!--/end col right -->
                            <!--Col left-->
                            <div class="col-lg-8">
                                <div class="p-4">
                                    <div class="verti-timeline left-timeline">
                                        <div class="timeline-item left">
                                            <div class="timeline-block">
                                                <div class="time-show-btn mt-0">
                                                    <a href="#" class="btn btn-info btn-rounded w-lg" style="background-color:#16424d;">Titre de la formation : LES BASES DU UX DESIGN</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Item-->
                                        <div class="timeline-item">
                                            <div class="timeline-block">
                                                <div class="timeline-box card">
                                                    <div class="card-body">
                                                        <div class="timeline-date">Introduction</div>
                                                        <h5 class="mt-3 font-size-16"> Module I </h5>
                                                        <div class="card-body">
                                                            <!-- 16:9 aspect ratio -->
                                                            <div class="ratio ratio-21x9">
                                                                    <iframe src="https://www.youtube.com/embed/KU88o67vDM8" title="YouTube video" allowfullscreen=""></iframe>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12">
                                                            <div class="p-4 text-center border h-100">
                                                                <h5 class="font-size-15 mb-4">Votre avis sur le module</h5>
                                                                <div id="basic-rater" dir="ltr" class="star-rating" data-rating="5" style="width: 110px; height: 22px; background-size: 22px;" title="5/5"><div class="star-value" style="background-size: 22px; width: 100%;"></div></div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header justify-content-between d-flex align-items-center">
                                                                <!--<h4 class="card-title">INTRODUCTION</h4>-->
                                                                <p style="text-align:justify; margin-left:5px;">
                                                                LES PRINCIPES FONDAMENTAUX DU MARKETING
§     Le besoin : une sensation de privatisation.
§     Le désir : un moyen privilégié de satisfaire un besoin.
§     La demande : c’est le nombre d’unité d’un bien particulier que les consommateurs sont disposés à acheter durant une période de temps donnée sous des conditions déterminées.
§     Le produit : est tout ce qui peut être offert sur le marché et qui est apte à satisfaire un besoin ou un désir.
§     L’échange : une opération qui consiste à obtenir de quelqu’un un produit désiré en lui en offrant quelque chose en retour.
§     La transaction : un acte par lequel au moins deux parties concrétisent un accort d’échange de valeur.
§     La relation : la manière de concevoir l’échange de valeur avec un client dans le but d’établir, d’enrichir et de consolider les liens d’affaires personnalisés et durables pour mieux répondre à l’ensemble de ses besoins.
§     La valeur d’un bien ou d’un service : est sa capacité à satisfaire les besoins à n prix raisonnable.
§     La qualité totale : consiste pour l’entreprise à améliorer ses procédés de fabrication dans le but d’offrir un produit ou service exempte de tout défaut.
§     Le marché : est l’ensemble des acheteurs actuels et potentiels d’un produit.          C’est la relation d’offre et la demande.  
§     Potentiels : les personnes qui sont susceptible d’acheter le produit.
                                                                    </p>
                                                            </div><!-- end card header -->
                                                        </div>
                                                        <div class="btn-group btn-icon" role="group">
                                                            <button type="button" class="btn btn-outline-light_" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Profile" aria-label="Profile"><i class="uil uil-angle-double-left"></i> Précédent</button>
                                                            &nbsp;&nbsp;
                                                            <button type="button" class="btn btn-outline-light_" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Message" aria-label="Message">Suivant <i class="uil uil-angle-double-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/ End item-->
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- end col left -->
                            
                        </div>
                    <!--/Contenu de la page-->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> &copy; Yadec Consulting.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                               Découvrez nos solution en <i class="mdi mdi-cubes text-danger"></i> <a href="https://www.yadecdigital.com" target="_blank" class="text-reset">cliquant ici</a> 
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


    <!-- apexcharts -->
      <!-- apexcharts -->
      <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- areacharts init -->
<!--<script src="assets/js/pages/apexcharts.init.js"></script>-->

<script>
     //Personnes formées par service
    var options = {
        chart: { height: 250, type: "line", zoom: { enabled: !1 }, toolbar: { show: !1 } },
        colors: ["#038edc", "#5fd0f3"],
        dataLabels: { enabled: !1 },
        stroke: { width: [3, 3], curve: "straight" },
        series: [
            { name: "Effectif", data: [
                <?php
                
                $ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount();

                $i=0;
                $se=$con->prepare('SELECT * FROM service ');
                $se->execute();
                while($ise=$se->fetch())
                {
                    $i++;
                    $pe=$con->prepare('SELECT * FROM personnel_soignant WHERE service_id=:A');
                    $pe->execute(array('A'=>$ise['id_service']));
                    $np=$pe->rowcount();
                    echo $np;
                    if($i<$nser){ echo ','; }
                }
                
                ?>
            ] },
            { name: "Personnes formées", 
                data: [
                    <?php
                
                $ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount();

                $i=0;
                $se=$con->prepare('SELECT * FROM service ');
                $se->execute();
                while($ise=$se->fetch())
                {
                    $i++;
                    $pe=$con->prepare('SELECT * FROM personnel_soignant LEFT JOIN participe_formation ON participe_formation.personnel_id=personnel_soignant.id_personnel_soignant WHERE service_id=:A AND id_participe_formation!="" ');
                    $pe->execute(array('A'=>$ise['id_service']));
                    $np=$pe->rowcount();
                    echo $np;
                    if($i<$nser){ echo ','; }
                }
                
                ?>
             
            ] },
        ],
        grid: { row: { colors: ["transparent", "transparent"], opacity: 0.2 }, borderColor: "#f1f1f1" },
        markers: { style: "inverted", size: 4, hover: { size: 6 } },
        xaxis: { categories: [
            <?php 

//Répartition du budget par service
$ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount(); 

$bud_serv_1=$con->prepare('SELECT * FROM service ');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>

        ], title: { text: "Service", style: { fontWeight: 500 } } },
        yaxis: { title: { text: "Effectif | Personnes formées", style: { fontWeight: 500 } }, min: 0, max: 40 },
        legend: { position: "top", horizontalAlign: "left", floating: !0, offsetY: -25, offsetX: -5 },
        responsive: [{ breakpoint: 600, options: { chart: { toolbar: { show: !1 } }, legend: { show: !1 } } }],
    },
    chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
    chart.render();

    //
    options = {
    chart: { height: 900, type: "area", toolbar: { show: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { curve: "smooth", width: 3 },
    series: [
        { name: "series1", data: [34, 40, 28, 52, 42, 109, 100] },
        { name: "series2", data: [32, 60, 34, 46, 34, 52, 41] },
    ],
    colors: ["#038edc", "#5fd0f3"],
    xaxis: { type: "datetime", categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"] },
    grid: { borderColor: "#f1f1f1" },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100, 100, 100] } },
    tooltip: { x: { format: "dd/MM/yy HH:mm" } },
    };

    //Nombre de participants par formation
    options = {
          series: [{  name: "Participants",
          data: [
              
            <?php 

//Participants 
$ser=$con->prepare('SELECT * FROM formation ');
$ser->execute();
$nser=$ser->rowcount(); 

$for=$con->prepare('SELECT * FROM formation LEFT JOIN demande_formation ON formation.demande_formation_id=demande_formation.id_demande_formation ');
$for->execute();
$i=0;
while($ifor=$for->fetch())
{
    $i++;
    $pe=$con->prepare('SELECT * FROM personnel_soignant LEFT JOIN participe_formation ON participe_formation.personnel_id=personnel_soignant.id_personnel_soignant LEFT JOIN demande_formation ON demande_formation.num_demande_formation=participe_formation.formation_code LEFT JOIN formation ON formation.demande_formation_id=demande_formation.id_demande_formation WHERE formation_code=:A');
    $pe->execute(array('A'=>$ifor['num_demande_formation']));
    $np=$pe->rowcount();
    echo $np;
    if($i<$nser){ echo ','; }
}
?>
        
        ]
        }],
          chart: {
          type: 'bar',
          height: 290
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: true
        },        
        xaxis: {
          categories: [
              
            <?php 

                //Formations
                $ser=$con->prepare('SELECT * FROM formation ');
                $ser->execute();
                $nser=$ser->rowcount(); 

                $bud_serv_1=$con->prepare('SELECT * FROM formation LEFT JOIN demande_formation ON formation.demande_formation_id=demande_formation.id_demande_formation');
                $bud_serv_1->execute(); 

                $i=0;
                while($ibud_serv_1=$bud_serv_1->fetch())
                {
                    $i++;
                    echo "'".$ibud_serv_1['formation_demande']."'";
                if($i<$nser){ echo ', '; }
                }
        ?>

          ],
        }
        };

        var chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options);
        chart.render();

     //Camember - Représentation du Budget global Exécuté/Disponible
     <?php
     $bud_rest=floatval($valeur_actuelle_budget/$valeur_initiale_budget)*100;
     $bud_exec=100-$bud_rest;
     ?>
    (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render();
    var bud_exec=<?php echo floatval($bud_exec); ?>;
    var bud_rest=<?php echo floatval($bud_rest); ?>;
    options = {
    chart: { height: 900, type: "pie" },
    series: [bud_exec,bud_rest],
    labels: ["Budget exécuté", "Budget disponible"],
    //colors: ["#D1620D", "#51d28c"],
    colors: ["#D1620D", "#205236"],
    legend: { show: !0, position: "bottom", horizontalAlign: "left", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };

    (chart = new ApexCharts(document.querySelector("#pie-chart"), options)).render();

       //Camember - Représentation formations Exécuté/Prévues
       <?php
    $prev=$con->prepare('SELECT * FROM demande_formation');
    $prev->execute();
    $nprev=$prev->rowcount();

    $exef=$con->prepare('SELECT * FROM formation');
    $exef->execute();
    $nexef=$exef->rowcount();
     ?>
    (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render();
    var bud_exec=<?php echo floatval($nexef); ?>;
    var bud_rest=<?php echo floatval($nprev); ?>;
    options = {
    chart: { height: 900, type: "pie" },
    series: [bud_exec,bud_rest],
    labels: ["Formations effectuées", "Formations prévues"],
    //colors: ["#51d28c", "#f7b84b"],
    colors: ["#D1620D", "#205236"],
    legend: { show: !0, position: "bottom", horizontalAlign: "left", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };

    (chart = new ApexCharts(document.querySelector("#pie-chart-1"), options)).render();


    
    //Camember - Représentation de la répartition du budget par service
    options = {
    chart: { height: 900, type: "donut" },
    series: [
             
        <?php

        $ser=$con->query('SELECT * FROM service');
        $ser->execute();
        $nser=$ser->rowcount();

        $i=0;
        while($ibud_serv=$bud_serv->fetch())
        {
            $i++;
            echo floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
           if($i<$nser){ echo ', '; }
        }
        
        ?>
    ],
    labels: [
        <?php 

//Répartition du budget par service
$bud_serv_1=$con->prepare('SELECT * FROM budget LEFT JOIN budget_service ON budget.code_budget=budget_service.budget_code_service LEFT JOIN service ON budget_service.service_id_budget=service.id_service WHERE actif_budget=0');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>
    ],
    colors: ["#5fd0f3", "#038edc", "#D1620D", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "left", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };
    (chart = new ApexCharts(document.querySelector("#donut-chart"), options)).render();

     //Camember - Demandes de formations par service
     options = {
    chart: { height: 900, type: "donut" },
    series: [
             
        <?php

        $ser=$con->query('SELECT * FROM service ');
        $ser->execute();
        $nser=$ser->rowcount();


        $ser=$con->query('SELECT * FROM service ');
        $ser->execute();
        $i=0;
        while($ibud_serv=$ser->fetch())
        {
            $i++;
            $dem=$con->prepare('SELECT * FROM demande_formation LEFT JOIN utilisateur ON utilisateur.secur=demande_formation.secur_ajout_demande LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id LEFT JOIN service ON service.id_service=personnel_soignant.service_id WHERE service_id=:A');
            $dem->execute(array('A'=>$ibud_serv['id_service']));
            $ndem=$dem->rowcount();
            echo floatval($ndem);
           if($i<$nser){ echo ', '; }
        }
        
        ?>
    ],
    labels: [
        <?php 
$bud_serv_1=$con->prepare('SELECT * FROM service ');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>
    ],
    colors: ["#5fd0f3", "#038edc", "#D1620D", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "left", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };
    (chart = new ApexCharts(document.querySelector("#donut-chart-1"), options)).render();


            var options5 = {
        series: [{ data: [10, 20, 15, 40, 20, 50, 70, 60, 90, 70, 110] }],
        chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
        plotOptions: { bar: { columnWidth: "50%" } },
        tooltip: {
            fixed: { enabled: !1 },
            y: {
                title: {
                    formatter: function (e) {
                        return "";
                    },
                },
            },
        },
        colors: ["#038edc"],
    },
    chart5 = new ApexCharts(document.querySelector("#sparkline-chart-1"), options5);
    chart5.render();
    var options = {
        series: [{ name: "Series A", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
        chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2 },
        fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
        colors: ["#038edc", "transparent"],
    },

    
    chart = new ApexCharts(document.querySelector("#sparkline-chart-2"), options);
    chart.render();
    options5 = {
    series: [{  data: [40, 20, 30, 40, 20, 60, 55, 70, 95, 65, 110] }],
    chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "50%" } },
    tooltip: {
        fixed: { enabled: !1 },
        y: {
            title: {
                formatter: function (e) {
                    return "";
                },
            },
        },
    },
    colors: ["#038edc"],
    };

    //Personnes formées 
    (chart5 = new ApexCharts(document.querySelector("#sparkline-chart-3"), options5)).render();
    options = {
    series: [{ name: "Personnes formées", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
    chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { curve: "smooth", width: 2 },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
    colors: ["#038edc", "transparent"],
    };


    (chart = new ApexCharts(document.querySelector("#sparkline-chart-4"), options)).render();
    options = {
    chart: { height: 900, type: "line", stacked: !1, offsetY: -5, toolbar: { show: !1 } },
    stroke: { width: [0, 0, 0, 1], curve: "smooth" },
    plotOptions: { bar: { columnWidth: "30%" } },
    colors: ["#5fd0f3", "#038edc", "#dfe2e6", "#51d28c"],
    series: [
        { name: "Formations effectuées", type: "column", data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30] },
        { name: "Personnes formées", type: "column", data: [19, 8, 26, 21, 18, 36, 30, 28, 40, 39, 15] },
        { name: "Budget par personne", type: "area", data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43] },
        { name: "Formateurs", type: "line", data: [9, 11, 13, 12, 10, 8, 6, 9, 14, 17, 22] },
    ],
    fill: { opacity: [0.85, 1, 0.25, 1], gradient: { inverseColors: !1, shade: "light", type: "vertical", opacityFrom: 0.85, opacityTo: 0.55, stops: [0, 100, 100, 100] } },
    labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003", "08/01/2003", "09/01/2003", "10/01/2003", "11/01/2003"],
    markers: { size: 0 },
    xaxis: { type: "datetime" },
    yaxis: { title: { text: "Analyse Financière", style: { fontWeight: 500 } } },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e;
            },
        },
    },
    grid: { borderColor: "#f1f1f1", padding: { bottom: 15 } },
    };
    (chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();


</script>

    <script src="//code.jquery.com/jquery.min.js"></script>
    <script type="text/javascript" src="design/full-screen-helper.min.js"></script>

    <script type="text/javascript">
    if (typeof FullScreenHelper === "undefined") {
        document.write("<p>FullScreenHelper is not loaded</p>");
    } else if (FullScreenHelper.supported()) {
        document.write("<p>Le mode plein écran est supporté</p>");
    } else {
        document.write("<p>Votre navigateur ne supporte pas le mode plein écran</p>");
    }

    FullScreenHelper.on(function () {
        if (FullScreenHelper.state()) {
            console.log("In fullscreen", FullScreenHelper.current());
        } else {
            console.log("Not in fullscreen");
        }
    });
    </script>



    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <!--<script src="assets/js/pages/dashboard-sales.init.js"></script>-->

    <script src="assets/js/app_horizontal.js"></script>

    <!-- rater-js plugin -->
    <script src="assets/libs/rater-js/index.js"></script>

    <script src="assets/js/pages/rating.init.js"></script>
  
        <!--Draggable-->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".card" ).draggable();
        } );

        function Hide(HideID) 
        {
        HideID.style.display = "none"; 
        }

    </script>


  

    </body>

</html>
<?php
}
else
{
 echo'<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>