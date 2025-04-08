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
        <title><?php include('../titre_ent_1.php'); ?> | Paramètres</title>

        <?php include('../meta.php'); ?>
        <!-- App favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

              <!-- quill css -->
              <link href="../assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
        <link href="../assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />

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
                            <a class="dropdown-item d-flex align-items-center" href="parametre.php"><i class="mdi mdi-cog-outline text-muted font-size-16 align-middle me-1"></i> <span class="align-middle">Paramètres</span></a>
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

            <?php if($_SESSION['id_type_groupe']<=2){ ?>
            <li class="nav-item">
                <a class="nav-link arrow-none" href="parametre.php" id="topnav-pages" role="button" style="background-color:#fabd02; color:#22254b;">
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
                    <a href="../profil/profil.php" class="dropdown-item" data-key="t-eval">Profil</a>
                    <?php if($_SESSION['id_type_groupe']<=2){ ?>
                    <a href="../utilisateur/utilisateur.php" class="dropdown-item" data-key="t-eval">Utilisateurs</a>
                    <a href="../historique/historique.php" class="dropdown-item" data-key="t-eval">Traçabilité</a>
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
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                                              
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php include('../titre_logi.php'); ?></a></li>
                                        <li class="breadcrumb-item active">Paramètres</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        
                    <div class="chargement_" style="text-align:center; margin-top:70px"></div>
						  <div class="aff_evaluation_">

                        <div class="row">
                       
                        <!--Debut affectation-->
						<div class="col-md-6 col-xs-12">
                       
                       <div class="card bg- text-white-50" style="color:#038bd7;">
                      
                           <div class="card-body">

                           <ul class="breadcrumb push-down-0">
               
               <li class="tit_para">affectation</li>
               </ul>
               
   <button id="ajout_affectation" data-toggle="modal" data-target="#myModal_affectation" style="margin:10px; " class="btn btn-purple"><i class="fa fa-plus"></i> Ajouter affectation</button>
   <button id="import_affectation" style="margin:10px; " class="btn btn-warning"><i class="fa fa-download"></i> Importer affectation</button>
                              
                         <!-- PAGE CONTENT WRAPPER -->
                       <div class="page-content-wrap"  style="">
                           
                           <!-- START WIDGETS -->    
                           <div class="panel-body"> 
                           <div>
                              <br />
             
             </div> 
                           <div class="chargement"></div>               
                           <div class="row voir aff_affectation">
                        
                           </div>
                           </div>
                           <!-- END WIDGETS --> 
                           <br />       
                       </div>
                       <!-- END PAGE CONTENT WRAPPER --> 
                               
                              
                           </div>
                       </div>
                    
                       </div>
                       <!--/fin affectation-->

                          <!--Debut chantier-->
						<div class="col-md-6 col-xs-12">
                       
                       <div class="card bg- text-white-50" style="color:#038bd7;">
                      
                           <div class="card-body">

                           <ul class="breadcrumb push-down-0">
               
               <li class="tit_para">chantier</li>
               </ul>
               
   <button id="ajout_chantier" data-toggle="modal" data-target="#myModal_chantier" style="margin:10px; " class="btn btn-purple"><i class="fa fa-plus"></i> Ajouter chantier</button>
   <button id="import_chantier" style="margin:10px; " class="btn btn-warning"><i class="fa fa-download"></i> Importer chantier</button>
                              
                         <!-- PAGE CONTENT WRAPPER -->
                       <div class="page-content-wrap"  style="">
                           
                           <!-- START WIDGETS -->    
                           <div class="panel-body"> 
                           <div>
                              <br />
             
             </div> 
                           <div class="chargement"></div>               
                           <div class="row voir aff_chantier">
                        
                           </div>
                           </div>
                           <!-- END WIDGETS --> 
                           <br />       
                       </div>
                       <!-- END PAGE CONTENT WRAPPER --> 
                               
                              
                           </div>
                       </div>
                    
                       </div>
                       <!--/fin chantier-->


                         <!--Debut operation-->
						<div class="col-md-12 col-xs-12">
                       
                       <div class="card bg- text-white-50" style="color:#038bd7;">
                      
                           <div class="card-body">

                           <ul class="breadcrumb push-down-0">
               
               <li class="tit_para">operation</li>
               </ul>
               
   <button id="ajout_operation" data-toggle="modal" data-target="#myModal_operation" style="margin:10px; " class="btn btn-purple"><i class="fa fa-plus"></i> Ajouter operation</button>
   <button id="import_operation" style="margin:10px; " class="btn btn-warning"><i class="fa fa-download"></i> Importer operation</button>
                              
                         <!-- PAGE CONTENT WRAPPER -->
                       <div class="page-content-wrap"  style="">
                           
                           <!-- START WIDGETS -->    
                           <div class="panel-body"> 
                           <div>
                              <br />
             
             </div> 
                           <div class="chargement"></div>               
                           <div class="row voir aff_operation">
                        
                           </div>
                           </div>
                           <!-- END WIDGETS --> 
                           <br />       
                       </div>
                       <!-- END PAGE CONTENT WRAPPER --> 
                               
                              
                           </div>
                       </div>
                    
                       </div>
                       <!--/fin operation-->


                         <!--Debut designation-->
						<div class="col-md-12 col-xs-12">
                       
                       <div class="card bg- text-white-50" style="color:#038bd7;">
                      
                           <div class="card-body">

                           <ul class="breadcrumb push-down-0">
               
               <li class="tit_para">designation</li>
               </ul>
               
   <button id="ajout_designation" data-toggle="modal" data-target="#myModal_designation" style="margin:10px; " class="btn btn-purple"><i class="fa fa-plus"></i> Ajouter designation</button>
   <button id="import_designation" style="margin:10px; " class="btn btn-warning"><i class="fa fa-download"></i> Importer designation</button>
                              
                         <!-- PAGE CONTENT WRAPPER -->
                       <div class="page-content-wrap"  style="">
                           
                           <!-- START WIDGETS -->    
                           <div class="panel-body"> 
                           <div>
                              <br />
             
             </div> 
                           <div class="chargement"></div>               
                           <div class="row voir aff_designation">
                        
                           </div>
                           </div>
                           <!-- END WIDGETS --> 
                           <br />       
                       </div>
                       <!-- END PAGE CONTENT WRAPPER --> 
                               
                              
                           </div>
                       </div>
                    
                       </div>
                       <!--/fin designation-->

                      
                        </div>
						

                          </div>

                    </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

<!-- Modal affectation -->
<!-- Modal -->
<div class="modal fade" id="myModal_affectation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header ajout_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Ajouter un affectation </h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
				
				
	  <form name="form_affectation" id="form_affectation" class="form-horizontal" action="#">
		
		<div class="row">
        <div class="col-md-12 col-xs-12">
				 <label>Libellé affectation <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="lib_affectation" name="lib_affectation"  />
        </div>
		</div>
		
		 <div class="modal-footer ajout-footer_file"> 
		 <button type="submit" id="envoie" class="btn button_valid"><i class="fa fa-check"></i> Valider</button>&nbsp;&nbsp;
         <button type="button" class="btn button_annul" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
         </div>
      </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade mod_pop" id="myModal_affectation_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modification affectation</h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_affectation_mod"></div>
		</div>
	  
    </div>
  </div>
</div>	

<div class="modal fade mod_pop" id="myModal_affectation_sup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header sup_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Suppression affectation</h4>
      </div>
      <div class="modal-body">

	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_affectation_sup"></div>
		</div>

		<div class="modal-footer ajout-footer">
        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Non</button>
        <button type="submit" id="submit_affectation_sup" class="btn button_supprimer"><i class="fa fa-bitbucket"></i> Oui</button>&nbsp;&nbsp;&nbsp;
      </div>
	  
    </div>
  </div>
</div>	
<!-- fin modal affectation-->


<!-- Modal chantier -->
<!-- Modal -->
<div class="modal fade" id="myModal_chantier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header ajout_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Ajouter un chantier </h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
				
				
	  <form name="form_chantier" id="form_chantier" class="form-horizontal" action="#">
		
		<div class="row">
        <div class="col-md-12 col-xs-12">
				 <label>Libellé chantier <span class="semi_aste">*</span></label>
				 <input type="text" class="form-control" required id="lib_chantier" name="lib_chantier"  />
        </div>
		</div>
		
		 <div class="modal-footer ajout-footer_file"> 
		 <button type="submit" id="envoie" class="btn button_valid"><i class="fa fa-check"></i> Valider</button>&nbsp;&nbsp;
         <button type="button" class="btn button_annul" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
         </div>
      </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade mod_pop" id="myModal_chantier_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modification chantier</h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_chantier_mod"></div>
		</div>
	  
    </div>
  </div>
</div>	

<div class="modal fade mod_pop" id="myModal_chantier_sup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header sup_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Suppression chantier</h4>
      </div>
      <div class="modal-body">

	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_chantier_sup"></div>
		</div>

		<div class="modal-footer ajout-footer">
        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Non</button>
        <button type="submit" id="submit_chantier_sup" class="btn button_supprimer"><i class="fa fa-bitbucket"></i> Oui</button>&nbsp;&nbsp;&nbsp;
      </div>
	  
    </div>
  </div>
</div>	
<!-- fin modal chantier-->

<!-- Modal operation -->
<!-- Modal -->
<div class="modal fade" id="myModal_operation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header ajout_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Ajouter un operation </h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
				
				
	  <form name="form_operation" id="form_operation" class="form-horizontal" action="#">
		
		<div class="row">
        <div class="col-md-4 col-xs-12">
          <label>Chantier concerné <span class="semi_aste">*</span></label>
          <select class="form-control selectpicker" data-placeholder="Choisir" id="chantier_id_operation" title="Choisir..." style="width: 100%;" data-live-search="true" data-width="100%">
            <option value="">---Choisir---</option>
                    <?php
           $red=$con->prepare("SELECT * FROM chantier ORDER BY lib_chantier ASC");
           $red->execute();
           while($ro=$red->fetch())
           {
           ?>
           <option value="<?php echo''.$ro['id_chantier'].''; ?>"><?php echo''.stripslashes($ro['lib_chantier']).'' ; ?></option>
                  <?php
           }
                    ?>
           </select>
        </div>
        <div class="col-md-8 col-xs-12">
          <label>Libellé operation <span class="semi_aste">*</span></label>
          <input type="text" class="form-control" required id="lib_operation" name="lib_operation"  />
        </div>
		</div>

		 <div class="modal-footer ajout-footer_file"> 
		 <button type="submit" id="envoie" class="btn button_valid"><i class="fa fa-check"></i> Valider</button>&nbsp;&nbsp;
         <button type="button" class="btn button_annul" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
         </div>
      </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade mod_pop" id="myModal_operation_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modification operation</h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_operation_mod"></div>
		</div>
	  
    </div>
  </div>
</div>	

<div class="modal fade mod_pop" id="myModal_operation_sup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header sup_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Suppression operation</h4>
      </div>
      <div class="modal-body">

	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_operation_sup"></div>
		</div>

		<div class="modal-footer ajout-footer">
        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Non</button>
        <button type="submit" id="submit_operation_sup" class="btn button_supprimer"><i class="fa fa-bitbucket"></i> Oui</button>&nbsp;&nbsp;&nbsp;
      </div>
	  
    </div>
  </div>
</div>	
<!-- fin modal operation-->


<!-- Modal designation -->
<!-- Modal -->
<div class="modal fade" id="myModal_designation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header ajout_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus"></i> Ajouter un designation </h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
				
				
	  <form name="form_designation" id="form_designation" class="form-horizontal" action="#">
		
		<div class="row">
        <div class="col-md-4 col-xs-12">
          <label>Opération concernée <span class="semi_aste">*</span></label>
          <select class="form-control selectpicker" data-placeholder="Choisir" id="operation_id_designation" title="Choisir..." style="width: 100%;" data-live-search="true" data-width="100%">
            <option value="">---Choisir---</option>
                    <?php
           $red=$con->prepare("SELECT * FROM operation ORDER BY lib_operation ASC");
           $red->execute();
           while($ro=$red->fetch())
           {
           ?>
           <option value="<?php echo''.$ro['id_operation'].''; ?>"><?php echo''.stripslashes($ro['lib_operation']).'' ; ?></option>
                  <?php
           }
                    ?>
           </select>
        </div>
        <div class="col-md-8 col-xs-12">
          <label>Libellé designation <span class="semi_aste">*</span></label>
          <input type="text" class="form-control" required id="lib_designation" name="lib_designation"  />
        </div>
		</div>

    <div class="row">
        <div class="col-md-4 col-xs-12">
          <label>Quantité <span class="semi_aste">*</span></label>
          <input type="number" class="form-control" required id="qte_designation" name="qte_designation"  />
        </div>
        <div class="col-md-4 col-xs-12">
          <label>Prix Unitaire <span class="semi_aste">*</span></label>
          <input type="number" class="form-control" required id="prix_designation" name="prix_designation"  />
        </div>
        <div class="col-md-4 col-xs-12">
          <label>Prix Total <span class="semi_aste">*</span></label>
          <input readonly type="text" class="form-control" required id="total_designation" name="total_designation"  />
        </div>
		</div>
    
    <hr>

    <div class="row">
        <div class="col-md-4 col-xs-12">
          <label>Fourniture déboursé <span class="semi_aste">*</span></label>
          <input type="number" class="form-control" required id="fourniture_debourse" name="fourniture_debourse"  />
        </div>
        <div class="col-md-4 col-xs-12">
          <label>Main d'oeuvre déboursé <span class="semi_aste">*</span></label>
          <input type="number" class="form-control" required id="main_doeuvre_debourse" name="main_doeuvre_debourse"  />
        </div>
        <div class="col-md-4 col-xs-12">
          <label>Montant déboursé <span class="semi_aste">*</span></label>
          <input readonly type="text" class="form-control" required id="montant_debourse" name="montant_debourse"  />
        </div>
		</div>
		
		 <div class="modal-footer ajout-footer_file"> 
		 <button type="submit" id="envoie" class="btn button_valid"><i class="fa fa-check"></i> Valider</button>&nbsp;&nbsp;
         <button type="button" class="btn button_annul" data-dismiss="modal"><i class="fa fa-times"></i> Annuler</button>
         </div>
      </form>
      </div>
     
    </div>
  </div>
</div>



<div class="modal fade mod_pop" id="myModal_designation_mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header modif_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Modification designation</h4>
      </div>
      <div class="modal-body">
	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_designation_mod"></div>
		</div>
	  
    </div>
  </div>
</div>	

<div class="modal fade mod_pop" id="myModal_designation_sup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> 
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header sup_header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Suppression designation</h4>
      </div>
      <div class="modal-body">

	    <div style="background-color:red; color:#fff; text-align:center;" class="msg_erreur"></div>
		<div id="affiche_designation_sup"></div>
		</div>

		<div class="modal-footer ajout-footer">
        <button type="button" class="btn button_annuler" data-dismiss="modal"><i class="fa fa-times"></i> Non</button>
        <button type="submit" id="submit_designation_sup" class="btn button_supprimer"><i class="fa fa-bitbucket"></i> Oui</button>&nbsp;&nbsp;&nbsp;
      </div>
	  
    </div>
  </div>
</div>	
<!-- fin modal designation-->


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

           <!-- ckeditor -->
           <script src="../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

          <!-- quill js -->
          <script src="../assets/libs/quill/quill.min.js"></script>

          <!-- init js -->
          <script src="../assets/js/pages/form-editor.init.js"></script>

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