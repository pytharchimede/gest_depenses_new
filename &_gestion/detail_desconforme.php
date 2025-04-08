<?php
session_start();
if( isset($_SESSION['pass_hop']) && $_SESSION['pass_hop']!='' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop']!='')
{
include('../connex.php');

//Enregistrememnt connexion
$date=date("Y-m-d");
$result= $con->prepare("INSERT INTO visite (ip, date, heure) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$date."', '".time()."') ");      
$result->execute();


$_SESSION['num_fiche_desconforme']=$_GET['num_fiche_desconforme'];
?>
<!doctype html>
<html lang="en" id="all_page">

    <head>

        <meta charset="utf-8" />
         <title><?php include('titre_ent_1.php'); ?>  | Désapprobation</title>
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

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                                            <i class="icon nav-icon uil uil-shield-plus" data-feather="shield"></i>
                                            <span data-key="t-secu">Sécurité</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                            <a href="profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                                          
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
                

        <div class="row">
   &nbsp;
        </div>

        <?php
        $num_fiche=$_GET['num_fiche_desconforme'];

        $rep=$con->prepare('SELECT * FROM fiche LEFT JOIN affectation On affectation.id_affectation=fiche.affectation_id WHERE num_fiche=:A ');
        $rep->execute(array('A'=>$num_fiche));
        $irep=$rep->fetch();

        $montant=number_format($irep['montant_fiche'],0,',',' ');
        $affectation=stripslashes($irep['lib_affectation']);
        $beneficiaire=stripslashes($irep['beficiaire_fiche']);
        ?>

                    <div class="container row">
                        <div class="col-md-12">
                            <p style="text-align:center;">
                                <p>
                                    <h3>Veuillez entrer la raison du refus de la fiche N° <b><?php echo $num_fiche; ?></b></h3>
                                </p>

                                <p>
                                    <h4>Détails</h4>
                                    Montant : <b><?php echo $montant; ?> FCFA</b><br>
                                    Affectation : <b><?php echo $affectation; ?></b><br>
                                    Bénéficiaire : <b><?php echo $beneficiaire; ?></b><br>
                                </p>

                                <form action="src/desconforme_fiche.php" method="post">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Veuillez saisir vos commentaires ici" id="detail_desconforme" name="detail_desconforme" style="height: 100px"></textarea>
                                            <label for="detail_desconforme">Vos commentaires</label>
                                        </div>
                             
                                <div class="row">&nbsp;</div>
                                <a href="accueil.php" class="btn btn-danger"><i class="fa fa-ban"></i> Annuler cette action</a>
                                &nbsp;
                                <a class="btn btn-success"><button type="submit"><i class="fa fa-check"></i> Confirmer le refus</button></a>
                                </form>
                            </p>
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
                            <script>document.write(new Date().getFullYear())</script> &copy; BANAMUR.
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