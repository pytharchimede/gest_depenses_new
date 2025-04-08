<?php
session_start();
if( isset($_SESSION['pass_hop']) && $_SESSION['pass_hop']!='' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop']!='')
{
?>
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title><?php include('titre_ent_1.php'); ?>  | Agenda</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Pichforest" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        
        <!-- plugin css -->
        <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet">

        <!-- fullcalendar css -->
        <link href="assets/libs/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    
    <body>

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

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>

                <div class="d-flex">

                

                    <a href="accueil_horizontal.php" title="Horizontal">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon" style="color:#fff;">
                            <i class="fa fa-exchange fa-3x"></i> Vue analyste
                        </button>
                    </div>
                    </a>


                    <a href="statistique/statistique.php" title="Statistiques">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon">
                            <i class="fa fa-chart-line fa-3x"></i>
                        </button>
                    </div>
                    </a>

                    <a href="evaluation/evaluation.php" title="Evaluations">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon">
                            <i class="fa fa-balance-scale fa-3x"></i>
                        </button>
                    </div>
                    </a>

                    <a href="formation/formation.php" title="Formations">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon">
                            <i class="fa fa-graduation-cap fa-3x"></i>
                        </button>
                    </div>
                    </a>

                    <a href="demande_formation/demande_formation.php" title="Demandes de formation">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon">
                            <i class="fa fa-comments fa-3x"></i>
                        </button>
                    </div>
                    </a>

                    <a href="personnel/personnel.php" title="Gestion du personnel">
                    <div class="d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle">
                            <i class="fa fa-users fa-3x"></i>
                        </button>
                    </div>
                    </a>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if($_SESSION['photo_hop']!=''){ ?>
                            <img class="rounded-circle header-profile-user" src="photo/<?php echo $_SESSION['photo_hop']; ?>" alt="Photo de profil"/>
							<?php }else{ ?> 
							<img class="rounded-circle header-profile-user" src="photo/profile-2398782.png" alt="Photo de profil">
							<?php } ?> 
                            <span class="ms-2 d-none d-sm-block user-item-desc">
                                <span class="user-name"><?php echo $_SESSION['nom_adm_hop']; ?></span>
                                <span class="user-sub-title"><?php echo $_SESSION['nom_type_groupe']; ?></span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <a class="dropdown-item" href="profil/profil.php"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="#"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Paramètres</span></a>
                            <a class="dropdown-item" href="deconex.php"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Déconexion</span></a>
                        </div>
                    </div>
                </div>

            </div>
        </header>
            <!-- ========== Left Sidebar Start ========== -->
         <div class="vertical-menu">

<!-- LOGO -->
<div class="navbar-brand-box">
    <a href="accueil.php" class="logo logo-dark">
        <span class="logo-sm">
            <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
            <?php //include('titre_ent.php'); ?>
        </span>
        <span class="logo-lg">
            <!--<img src="assets/images/logo-dark.png" alt="" height="22">-->
            <?php include('titre_ent_ac.php'); ?>
        </span>
    </a>

    <a href="accueil.php" class="logo logo-light">
        <span class="logo-lg">
            <!--<img src="assets/images/logo-light.png" alt="" height="22">-->
            <?php include('titre_ent_ac.php'); ?>
        </span>
        <span class="logo-sm">
            <!--<img src="assets/images/logo-sm-light.png" alt="" height="22">-->
            <?php //include('titre_ent.php'); ?>
            <?php //include('titre_ent_ac_sm.php'); ?>
        </span>
    </a>
</div>

<button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
    <i class="fa fa-fw fa-bars"></i>
</button>



<div data-simplebar class="sidebar-menu-scroll">



    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>

            <li class="mm-active">
                <a href="accueil.php" class="active">
                    <i class="icon nav-icon fa fa-home"></i>
                    <span class="menu-item">Tableau de bord</span>
                </a>
            </li>

            <?php if($_SESSION['id_type_groupe']<=2){ ?>

           <li class="menu-title">Ressources Humaines</li>

            <li>
                <a href="personnel/personnel.php">
                    <i class="icon nav-icon fa fa-user" ></i>
                    <span class="menu-item">Gestion du personnel</span>
                </a>
            </li>

            <li>
                <a href="organigramme/organigramme.php">
                    <i class="icon nav-icon fa fa-link" ></i>
                    <span class="menu-item">Organigramme</span>
                </a>
            </li>

            <li class="menu-title">Finances</li>

            <li>
                <a href="budget/budget.php">
                    <i class="icon nav-icon fa fa-credit-card"></i>
                    <span class="menu-item">Gestion du budget</span>
                </a>
            </li>

            <?php } ?>

            <li class="menu-title">Formation</li>

            <li>
                <a href="demande_formation/demande_formation.php">
                    <i class="icon nav-icon fa fa-comments" ></i>
                    <span class="menu-item">Demandes</span>
                </a>
            </li>
             
            <?php if($_SESSION['id_type_groupe']<=2){ ?>
            <li>
                <a href="formateur/formateur.php">
                    <i class="icon nav-icon fa fa-school" ></i>
                    <span class="menu-item">Formateur</span>
                </a>
            </li>
            <?php } ?>

            <li>
                <a href="formation/formation.php">
                    <i class="icon nav-icon fa fa-graduation-cap" ></i>
                    <span class="menu-item">Formation</span>
                </a>
            </li>

            <li class="menu-title">Evaluation</li>

            <li>
                <a href="evaluation/evaluation.php">
                    <i class="icon nav-icon fa fa-balance-scale" ></i>
                    <span class="menu-item">Evaluations</span>
                </a>
            </li>
            <?php if($_SESSION['id_type_groupe']<=2){ ?>
            <li>
                <a href="statistique/statistique.php">
                    <i class="icon nav-icon fa fa-chart-line"></i>
                    <span class="menu-item">Statistiques</span>
                </a>
            </li>

            <li>
                <a href="evaluation/fiche.php">
                    <i class="icon nav-icon fa fa-file-pdf"></i>
                    <span class="menu-item">Fiches d'évaluation</span>
                </a>
            </li>
           
            <li class="menu-title">Paramètres</li>

            <li>
                <a href="parametre/parametre.php">
                    <i class="icon nav-icon fa fa-gears"></i>
                    <span class="menu-item">Paramètres</span>
                </a>
            </li>
            <?php } ?>
            <li class="menu-title">Sécurité</li>

            <li>
                <a href="profil/profil.php">
                    <i class="icon nav-icon fa fa-user-circle"></i>
                    <span class="menu-item">Profile</span>
                </a>
            </li>
            <?php if($_SESSION['id_type_groupe']<=2){ ?>
            <li>
                <a href="utilisateur/utilisateur.php">
                    <i class="icon nav-icon fa fa-users"></i>
                    <span class="menu-item">Utilisateur</span>
                </a>
            </li>
            <li>
                <a href="historique/historique.php">
                    <i class="icon nav-icon fa fa-file-excel"></i>
                    <span class="menu-item">Traçabilité</span>
                </a>
            </li>
            <?php } ?>
         
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->


            

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
                                    <h4 class="mb-0">Agenda</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php include('titre_logi.php'); ?></a></li>
                                            <li class="breadcrumb-item active">Agenda</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="card card-h-100">
                                            <div class="card-body">
                                                <button class="btn btn-primary w-100" id="btn-new-event"><i class="mdi mdi-plus"></i> Créer une tâche</button>
                                                
                                                <div id="external-events">
                                                    <br>
                                                    <p class="text-muted">Cliquer pour ajouter</p>
                                                    <div class="external-event fc-event bg-success" data-class="bg-success">
                                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Demander une formation
                                                    </div>
                                                    <div class="external-event fc-event bg-info" data-class="bg-info">
                                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Créer une formation
                                                    </div>
                                                    <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Répondre à une demande
                                                    </div>
                                                    <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                                        <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Faire une évaluation
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- end col-->

                                    <div class="col-xl-9">
                                        <div class="card card-h-100">
                                            <div class="card-body">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> 

                                <div style='clear:both'></div>
                                    
                                <!-- Add New Event MODAL -->
                                <div class="modal fade" id="event-modal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header py-3 px-4 border-bottom-0">
                                                <h5 class="modal-title" id="modal-title">Tâche</h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-hidden="true"></button>

                                            </div>
                                            <div class="modal-body p-4">
                                                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Titre</label>
                                                                <input class="form-control" placeholder="Titre de la tâche"
                                                                    type="text" name="title" id="event-title" required value="" />
                                                                <div class="invalid-feedback">Veuillez entrer une valeur correcte svp</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label class="form-label">Categorie</label>
                                                                <select data-trigger class="form-control" name="category" id="event-category" required>
                                                                    <option value="bg-danger" selected>Urgent</option>
                                                                    <option value="bg-success">Très Important</option>
                                                                    <option value="bg-primary">Important</option>
                                                                </select>
                                                                <div class="invalid-feedback">Veuillez sélectionner une catégorie correcte</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-6">
                                                            <button type="button" class="btn btn-danger" id="btn-delete-event">Supprimer</button>
                                                        </div>
                                                        <div class="col-6 text-end">
                                                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Fermer</button>
                                                            <button type="submit" class="btn btn-success" id="btn-save-event">Enregistrer</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> <!-- end modal-content-->
                                    </div> <!-- end modal dialog-->
                                </div>
                                <!-- end modal-->
                            </div>
                        </div>
                        
                    </div> <!-- container-fluid -->
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

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenujs/metismenujs.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>

        <!-- plugins -->
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>

        <!-- plugin js -->
        <script src="assets/libs/fullcalendar/main.min.js"></script>

        <!-- Calendar init -->
        <script src="assets/js/pages/calendar.init.js"></script>
        <script src="assets/js/app.js"></script>

    </body>
</html>
<?php
}
else
{
 echo'<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>