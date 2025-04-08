<?php
session_start();
if( isset($_SESSION['pass_hop']) && $_SESSION['pass_hop']!='' && isset($_SESSION['secur_hop']) && $_SESSION['secur_hop']!='')
{
include('../../connex.php');

?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title><?php include('../titre_ent_1.php'); ?> | Traçabilité</title>

        <?php include('../meta.php'); ?>
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- plugin css -->
        <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet">

        <!-- One of the following themes -->
        <link rel="stylesheet" href="../assets/libs/@simonwep/pickr/themes/classic.min.css"/> <!-- 'classic' theme -->
        <link rel="stylesheet" href="../assets/libs/@simonwep/pickr/themes/monolith.min.css"/> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="../assets/libs/@simonwep/pickr/themes/nano.min.css"/> <!-- 'nano' theme -->

        <!-- Bootstrap Css -->
        <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../assets/css/app.min_horizontal.css" id="app-style" rel="stylesheet" type="text/css" />

         <!--Intégration de jquery/Ajax-->
         <script type="text/javascript" src="../../js/jquery_1.7.1_jquery.min.js"></script>
	    <script type="text/javascript" src="js/function.js"></script> 

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
                                <?php //include('titre_ent_sm.php'); ?>
                            </span>
                            <span class="logo-lg">
                                <!--<img src="assets/images/logo-dark.png" alt="" height="22">-->
                                <?php include('../titre_ent.php'); ?> 
                            </span>
                        </a>

                        <a href="../accueil.php" class="logo logo-light">
                            <span class="logo-sm">
                                <!--<img src="assets/images/logo-sm.png" alt="" height="22">-->
                                <?php //include('titre_ent.php'); ?>
                            </span>
                            <span class="logo-lg">
                                <!--<img src="assets/images/logo-light.png" alt="" height="22">-->
                                <?php include('../titre_ent.php'); ?>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                </div>


                 <input style="margin-top:10px; height:30px; background-color:#f9f9f9; opacity:0;" type="text" class="form-control" placeholder="Veuillez saisir votre recherche (Exple: Code de formation, Code de formateur, Code de demande ou matricule du personnel)"/>

                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php if($_SESSION['photo_hop']!=''){ ?>
                            <img class="rounded-circle header-profile-user" src="../photo/<?php echo $_SESSION['photo_hop']; ?>" alt="Photo de profil"/>
							<?php }else{ ?> 
							<img class="rounded-circle header-profile-user" src="../photo/profile-2398782.png" alt="Photo de profil">
							<?php } ?> 
                            <span class="user-name"><?php echo $_SESSION['nom_adm_hop']; ?></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                        <div class="p-3 border-bottom fond_nom">
                                    <h6 class="mb-0 text-white"><?php echo $_SESSION['nom_adm_hop']; ?></h6>
                                    <p class="mb-0 font-size-11 text-white-50 fw-semibold"><?php echo $_SESSION['nom_type_groupe']; ?></p>
                                </div>
                            <a class="dropdown-item" href="../profil/profil.php"><i class="mdi mdi-account-circle text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="parametre/parametre.php"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Paramètres</span></a>
                            <a class="dropdown-item" href="../deconex.php"><i class="mdi mdi-logout text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Déconexion</span></a>
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
                <a class="nav-link arrow-none" href="../accueil.php" id="topnav-dashboard">
                    <i class="icon nav-icon uil uil-monitor"></i>
                    <span data-key="t-dashboards">Tableau de bord</span> 
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link arrow-none" href="../parametre/parametre.php" id="topnav-pages" role="button">
                    <i class="icon nav-icon uil uil-setting" data-feather=""></i>
                    <span data-key="t-para">Paramètres</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button" style="background-color:#fabd02; color:#22254b;">
                    <i class="icon nav-icon uil uil-shield-plus" data-feather="shield"></i>
                    <span data-key="t-secu">Sécurité</span> <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <a href="../profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                    <a href="../utilisateur/utilisateur.php" class="dropdown-item" data-key="t-eval">Utilisateurs</a>
                    <a href="historique.php" class="dropdown-item" data-key="t-eval" style="background-color:#fabd02; color:#22254b;">Traçabilité</a>
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
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                                              
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php include('../titre_logi.php'); ?></a></li>
                                        <li class="breadcrumb-item active">Traçabilité</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!--Formulaire de recherche-->
                 
                    <!--/Formulaire de recherche-->

                    <div class="row">
                        
                    <div class="chargement" style="text-align:center; margin-top:70px"></div>
						  <div class="aff_evaluation">
						
                          <div class="row">
					   <!---->
					    <div class="col-lg-12">
					        <div class="panel">
					           
             
								
				                <div class="panel-body" style="background-color: #FDFDFD">
                   			         <!--  	<form role="form" id="form_recher_hist" name="form_recher_hist" action="#">-->
			  	 
                   <div class="">
                     <div class="form-group">
                       
                       <div class="row">

<!--
                   <div class="col-xs-5">
 <input type="text" class="form-control input" id="recher_historique" name="recher_historique" placeholder="Rechercher par date, adresse ip, nom de l'utilisateur ou opération"/>
                   </div>
-->
                   <div class="col-lg-4">
											<div class="form-group">
                                            <label for="recher_historiquer" class="control-label">
                                                <b>Recherche opération ou adresse ip</b>
                                            </label><br/>
<input type="text" class="form-control input" id="recher_historique" name="recher_historique" placeholder="Libellé de l'opération ou adresse ip"/>
                            </div>
							</div>																							
								
				   
				  <div class="col-lg-2">
											<div class="form-group">
                                            <label for="recher_utilisateur" class="control-label">
                                                <b>Recherche Utilisateur</b>
                                            </label><br/>
                                <select id="recher_utilisateur" name="recher_utilisateur" data-placeholder="Choisir un utilisateur" class="form-control selectpicker" data-live-search="true" data-width="100%">
                                    <option value="">Choix utilisateur...</option><?php $red=$con->prepare("SELECT * FROM utilisateur WHERE nom_utilisateur!='' ORDER BY nom_utilisateur ASC");
                                                     $red->execute();
                                                     while($ro=$red->fetch())
                                                     {
                                                     ?>
                <option value="<?php echo''.$ro['id_utilisateur'].''; ?>"><?php echo ''.stripslashes($ro['nom_utilisateur']).''; ?></option>
                                                     <?php
                                                     }
                                                     ?></select>
                            </div>
							</div>		

                            <div class="col-lg-2">
                            <div class="form-group">
                                            <label for="recher_date_debut" class="control-label">
                                                <b>Début des opérations</b>
                                            </label><br/>
<input type="date" class="form-control" id="dp1" name="recher_date_debut" placeholder="Date Début"/>
                            </div>
							</div>			

                             <div class="col-lg-2">
                            <div class="form-group">
                                            <label for="recher_date_fin" class="control-label">
                                                <b>Fin des opérations</b>
                                            </label><br/>
<input type="date" class="form-control" id="dp2" name="recher_date_fin" placeholder="Date Fin"/>
                            </div>
							</div>				
									
                                    <div class="col-lg-1" style="margin-top:8px;">
                                    <div class="form-group">
                                               <br/>
                           <button id="hist_search" class="btn btn-warning btn-md">Ok</button>		
                           </div>	
									</div>
                                    </div>				   

				   </div>
				   </div>
				   </div>
				   <!--</form>-->
					            </div>
								
								
					         </div>
              
						</div>
						
						 <div class="chargement" style="text-align:center; margin-top:70px"></div>
						 <div class="affiche_historique" style="margin-top:20px; margin-bottom:30px;">
						 
						 
					
					</div>	
						 
					</div>
							
										
                </div>

                          </div>

                    </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

<!-- Modal demande_formation -->
<div class="modal fade mod_choix_formation" id="myModal_choix_formation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
       
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-graduation-cap"></i> Evaluation d'une formation </h4>
      </div>
      <div class="modal-body">
    <div id="affiche_choix">

    <div class="col-xs-12">
                                            <div class="form-group">
                                            <label>Choisir une formation <span class="semi_aste">*</span></label>
				 <select data-placeholder="Sélectionner une formation" name="formation_id_eval" id="formation_id_eval" class="form-control selectpicker" data-live-search="true" style="width:100%;"> 
            <option value="">Veuillez sélectionner une formation</option>
            <?php       
				
$mesi1=$con->prepare("SELECT * FROM formation WHERE id_formation!='' ");
$mesi1->execute();

				 while($mesop1=$mesi1->fetch())
				 {
				?>
<option value="<?php echo''.$mesop1['id_formation'].''; ?>"><?php echo ' '.$mesop1['num_formation'].' '; ?></option>
				<?php
				}

                
				?>	
       </select>
                                            </div>
                                            </div> 

    </div>
    </div>
    
    <div class="modal-footer sup_footer">
		<button type="button" data-dismiss="modal" class="btn btn-danger button_annul">Annuler</button>&nbsp;&nbsp;
		<button type="submit" id="envoie_eval_collabo" class="btn btn-purple">Valider</button>
	</div>
    
    </div>
  </div>
</div>  

<div class="modal fade mod_choix_collaborateur" id="myModal_choix_collaborateur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
       
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-graduation-cap"></i> Evaluation d'un collaborateur </h4>
      </div>
      <div class="modal-body">
    <div id="affiche_choix">

    <div class="col-xs-12">
                                            <div class="form-group">
                                            <label>Choisir un collaborateur <span class="semi_aste">*</span></label>
				 <select data-placeholder="Sélectionner une formation" name="collaborateur_id_eval" id="collaborateur_id_eval" class="form-control selectpicker" data-live-search="true" style="width:100%;"> 
            <option value="">Veuillez sélectionner un collaborateur</option>
            <?php       
				
$mesi1=$con->prepare("SELECT * FROM personnel_soignant WHERE id_personnel_soignant!='' ");
$mesi1->execute();

				 while($mesop1=$mesi1->fetch())
				 {
				?>
<option value="<?php echo''.$mesop1['id_personnel_soignant'].''; ?>"><?php echo '('.$mesop1['matricule_personnel_soignant'].')'.' '.$mesop1['nom_personnel_soignant'].' '; ?></option>
				<?php
				}

                
				?>	
       </select>
                                            </div>
                                            </div> 

    </div>
    </div>
    
    <div class="modal-footer sup_footer">
		<button type="button" data-dismiss="modal" class="btn btn-danger button_annul">Annuler</button>&nbsp;&nbsp;
		<button type="submit" id="envoie_eval_sup" class="btn btn-purple">Valider</button>
	</div>
    
    </div>
  </div>
</div>  
<!-- fin modal demande_formation-->

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

               
            </div>

            <!-- Settings -->
            <hr class="m-0" />

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/libs/feather-icons/feather.min.js"></script>

    <!-- apexcharts -->
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>

    <script src="../assets/js/pages/dashboard-sales.init.js"></script>

    <script src="../assets/js/app.js"></script>

    </body>

</html>
<?php
}
else
{
 echo'<meta http-equiv="refresh" content="0; url=../deconex.php" />';
}
?>