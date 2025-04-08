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


                <input style="margin-top:10px; height:48px; background-color:#f9f9f9;" type="text" class="form-control" placeholder="Veuillez saisir votre recherche (Exple: Code de formation, Code de formateur, Code de demande ou matricule du personnel)"/>

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
                           
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                                <div class="p-3 bg-primary border-bottom">
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
                                          
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-users-alt" data-feather=""></i>
                                            <span data-key="t-rh">Ressources humaines</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="personnel/personnel.php" class="dropdown-item" data-key="t-gespers">Gestion du personnel</a>
                                            <a href="organigramme/organigramme.php" class="dropdown-item" data-key="t-organ">Organigramme</a>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-credit-card" data-feather=""></i>
                                            <span data-key="t-fin">Finances</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="budget/budget.php" class="dropdown-item" data-key="t-budg">Gestion du budget</a>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-book-reader" data-feather=""></i>
                                            <span data-key="t-form">Formation</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="demande_formation/demande_formation.php" class="dropdown-item" data-key="t-dem">Demandes</a>
                                            <a href="formateur/formateur.php" class="dropdown-item" data-key="t-forma">formateurs</a>
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
                                            <a href="evaluation/fiche.php" class="dropdown-item" data-key="t-fiche">Fiches d'évaluation</a>
                                            <a href="statistique/statistique.php" class="dropdown-item" data-key="t-stat">Statistiques</a>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-setting" data-feather=""></i>
                                            <span data-key="t-para">Paramètres</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="parametre/parametre.php" class="dropdown-item" data-key="t-para">Paramètres</a>
                                        </div>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-shield-plus" data-feather="shield"></i>
                                            <span data-key="t-secu">Sécurité</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                                            <a href="utilisateur/utilisateur.php" class="dropdown-item" data-key="t-eval">Utilisateurs</a>
                                            <a href="historique/historique.php" class="dropdown-item" data-key="t-eval">Traçabilité</a>
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
               
      
                <!--Left Col-->
                <div class="col-lg-2">
                            <div class="row">

                            <div id="budget_ex_rest" class="elmt col-lg-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">Budget <?php echo number_format($valeur_initiale_budget,0,',',' '); ?> FCFA</h5>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(budget_ex_rest);">Fermer</a>
                                                        <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request(document.getElementById('budget_ex_rest'));">
                                                            Plein écran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                               
                                    <div class="card-body">
                                        <div id="pie-chart" class="apex-charts" dir="ltr"></div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div id="budget_serv" class="col-lg-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">Budget / Service </h5>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(budget_serv);">Fermer</a>
                                                        <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request(document.getElementById('budget_serv'));">
                                                            Plein écran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="card-body">
                                        <div id="donut-chart" class="apex-charts"  dir="ltr"></div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            </div>
                </div>
                <!--/Left Col-->


                <!--Middle Col-->
                <div class="col-lg-8">
                
        <?php if($_SESSION['id_type_groupe']<=2){ ?>
        

                        <div class="row">
                           
                            <div id="part_form" class="col-lg-12 col-xs-12">
                                <div class="card">
                                     <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">Nombre de participants par formation </h5>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(part_form);">Fermer</a>
                                                        <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request(document.getElementById('part_form'));">
                                                            Plein écran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="card-body">                                        
                                        <div id="column_chart_datalabel" class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!--end card-->
                            </div><!--end col-->
                            <!-- end col -->

                        </div>
                        <!-- end row -->

                        <div class="row">
                           
                          
                        </div><!-- end row -->

                       

                        <div class="row">
                        <div class="col-xl-12" id="etat_bud_serv">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">Etat du budget par service </h5>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(etat_bud_serv);">Fermer</a>
                                                        <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request('#etat_bud_serv');">
                                                            Plein écran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                </div>
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Exporter vers :</span> <span class="text-muted">Choisir...<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="exportation/excel/excel_budget_par_service.php"><i class="fa fa-file-excel"></i> Feuille de calcul Excel</a>
                                                <a class="dropdown-item" target="_blank" href="exportation/pdf/pdf_budget_par_service.php"><i class="fa fa-file-pdf"></i> Fichier PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title mb-4"></h4>
                                        <div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover table-nowrap mb-0 align-middle table-check">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Date et heure</th>
                                                    <th>Service</th>
                                                    <th>Budget alloué</th>
                                                    <th>Budget exécutée</th>
                                                    <th>Budget disponible</th>
                                                </tr>
                                                <!-- end tr -->
                                            </thead>
                                            <!-- end thead -->
                                            <tbody>

                                                <!-- begin tr -->
                                                <?php
                        $valbud=$con->prepare('SELECT * FROM budget LEFT JOIN budget_service ON budget.code_budget=budget_service.budget_code_service LEFT JOIN service ON budget_service.service_id_budget=service.id_service WHERE actif_budget=0');
                        $valbud->execute();
                        $i=0;
                        while($ivalbud=$valbud->fetch()){
                            $i++;
                        $montant_restant=$ivalbud['montant_alloue']-$ivalbud['montant_execute'];
                                                ?>
                                                <tr>
                                                    <td class="fw-medium">
                                                        <?php echo $i; ?>
                                                    </td>
                                                    <td class="fw-medium" style="/*color:#f7b84b;*/">
                                                        <?php echo gmdate('d/m/Y H:i:s'); ?>
                                                    </td>
                                                    <td class="fw-medium" style="/*color:#f7b84b;*/">
                                                        <?php echo $ivalbud['lib_service']; ?>
                                                    </td>
                                                    <td style="color:#0379bb;">
                                                        <?php echo number_format($ivalbud['montant_alloue'],0,',',' ').' FCFA'; ?>
                                                    </td>

                                                    <td style="color:#f06548;">
                                                        <?php echo number_format($ivalbud['montant_execute'],0,',',' ').' FCFA'; ?>
                                                    </td>
                                                    <td style="color:#51d28c;">
                                                        <?php echo number_format($montant_restant,0,',',' ').' FCFA'; ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- end /tr -->

                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <?php } ?>

                   
                    <?php // include('stat_global.php'); ?>
                                          

                    <div class="row">
                        <div class="col-xl-12" id="list_form">
                            <div class="card">
                                <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">Liste des formations </h5>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="dropdown">
                                                    <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(list_form);">Fermer</a>
                                                        <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request('#list_form');">
                                                            Plein écran
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                </div>
                                <div class="card-body">
                                    <div class="float-end">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold">Exporter vers :</span> <span class="text-muted">Choisir...<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="exportation/excel/excel_formation.php"><i class="fa fa-file-excel"></i> Feuille de calcul Excel</a>
                                                <a class="dropdown-item" target="_blank" href="exportation/pdf/pdf_formation.php"><i class="fa fa-file-pdf"></i> Fichier PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h4 class="card-title mb-4"></h4>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-nowrap mb-0 align-middle table-check">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Thème</th>
                                                    <th>Montant</th>
                                                    <th>Début</th>
                                                    <th>Fin</th>
                                                </tr>
                                                <!-- end tr -->
                                            </thead>
                                            <!-- end thead -->
                                            <tbody>

                                                <!-- begin tr -->
                                                <?php
                        $lst_for=$con->prepare('SELECT * FROM formation LEFT JOIN demande_formation ON demande_formation.id_demande_formation=formation.demande_formation_id WHERE date_fin_formation<=:A');
                        $lst_for->execute(array('A'=>gmdate('Y-m-d')));
                        while($iform=$lst_for->fetch()){
                                                ?>
                                                <tr>
                                                    <td class="fw-medium">
                                                        <?php echo $iform['num_formation']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $iform['formation_demande']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo number_format($iform['montant_formation'],0,',',' ').' FCFA'; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo date("d/m/Y", strtotime($iform['date_debut_formation'])); ?>
                                                    </td>
                                                    <td>
                                                        <?php if($iform['date_fin_formation']!='0000-00-00'){echo date("d/m/Y", strtotime($iform['date_fin_formation'])); }else{ echo '<i style="color:orange">Pas encore définie</i>'; } ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <!-- end /tr -->

                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->

                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!--End Middle Col-->

                 <!--Right Col-->
                 <div class="col-lg-2">
                    <div class="row">
                    <div class="row">

<div class="col-lg-12 col-xs-12" id="partic">
    <div class="card">
        <div class="card-header border-bottom-0">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title">Participants </h5>
                        </div>

                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>
                                                
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(partic);">Fermer</a>
                                <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request('#partic');">
                                    Plein écran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <hr>
        </div>
         
        <div class="card-body">                                        
            <div id="line_chart_datalabel" class="apex-charts" dir="ltr"></div>                                      
        </div>
    </div><!--end card-->
</div><!--end col-->

<div class="col-lg-12 col-xs-12" id="prev_exec">
    <div class="card">
        <div class="card-header border-bottom-0">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title">Prévues | Exécutés </h5>
                        </div>

                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>
                                                
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(prev_exec);">Fermer</a>
                                <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request('#prev_exec');">
                                    Plein écran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <hr>
        </div>
        <div class="card-body">
            <div id="pie-chart-1" class="apex-charts" dir="ltr"></div>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end col -->

<div class="col-lg-12 col-xs-12" id="dem">
    <div class="card">
        <div class="card-header border-bottom-0">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="card-title">Demandes </h5>
                        </div>

                        <div class="flex-shrink-0">
                            <div class="dropdown">
                                <a class="font-size-16 text-muted dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal"></i>
                                </a>
                                                
                            <div class="dropdown-menu" style="">
                                <a class="dropdown-item" href="javascript:void();" style="color:black" onclick="Hide(dem);">Fermer</a>
                                <a class="dropdown-item" href="javascript:void();" onclick="FullScreenHelper.request('#dem');">
                                    Plein écran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <hr>
        </div>
        <div class="card-body">
            <div id="donut-chart-1" class="apex-charts"  dir="ltr"></div>
        </div>
        <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end col -->
</div>
<!-- end row -->
                    </div>
                </div>
                <!--/Right Col-->

                    
                    </div> <!-- end row-->

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
        legend: { position: "top", horizontalAlign: "right", floating: !0, offsetY: -25, offsetX: -5 },
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
          enabled: false
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
    colors: ["#f06548", "#51d28c"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
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
    colors: ["#51d28c", "#f7b84b"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
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
    colors: ["#5fd0f3", "#038edc", "#f06548", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
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
    colors: ["#5fd0f3", "#038edc", "#f06548", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
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