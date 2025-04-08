<header id="page-topbar">

    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="accueil.php" class="logo logo-dark">
                    <span class="logo-sm">
                    </span>
                    <span class="logo-lg">
                        <?php include('titre_ent_ac.php'); ?>
                    </span>
                </a>

                <a href="accueil.php" class="logo logo-light">
                    <span class="logo-sm">
                    </span>
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
                            <a class="nav-link arrow-none" href="decaisse.php" id="topnav-dashboard" style="background-color:#fabd02; color:#22254b;">
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