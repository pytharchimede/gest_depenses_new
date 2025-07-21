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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <title><?php include('titre_ent_1.php'); ?> | Accueil</title>
        <?php include('meta.php'); ?>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        
        <!-- Tailwind CSS pour un design moderne -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Font Awesome pour les icônes -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Autres bibliothèques si nécessaires -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        
        <!-- CSS personnalisé pour la recherche inversée -->
        <style>
            .recherche-inverse-container {
                transition: all 0.3s ease;
                border-radius: 8px;
                padding: 8px;
            }
            
            .recherche-inverse-normal {
                background-color: #f0f9ff;
                border: 2px solid #10b981;
            }
            
            .recherche-inverse-active {
                background-color: #fef2f2;
                border: 2px solid #ef4444;
            }
            
            .recherche-label-normal {
                color: #10b981;
                font-weight: 600;
            }
            
            .recherche-label-inverse {
                color: #ef4444;
                font-weight: 600;
            }
            
            .recherche-mode-indicator {
                font-size: 0.75rem;
                margin-top: 4px;
                font-style: italic;
            }
            
            .recherche-mode-normal::before {
                content: "✓ ";
                color: #10b981;
            }
            
            .recherche-mode-inverse::before {
                content: "✗ ";
                color: #ef4444;
            }
        </style>
    </head>

    <body class="bg-gray-50">
        <!-- Navigation moderne -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-gray-800"><?php include('titre_ent_ac.php'); ?></h1>
                        </div>
                    </div>
                    
                    <!-- Menu utilisateur -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button onclick="toggleUserMenu()" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                                <?php if ($_SESSION['photo_hop'] != '') { ?>
                                    <img class="w-8 h-8 rounded-full object-cover" src="photo/<?php echo $_SESSION['photo_hop']; ?>" alt="Photo de profil" />
                                <?php } else { ?>
                                    <img class="w-8 h-8 rounded-full object-cover" src="photo/profile-2398782.png" alt="Photo de profil">
                                <?php } ?>
                                <span class="font-medium"><?php echo $_SESSION['nom_adm_hop']; ?></span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            
                            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="profil/profil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                                <a href="parametre/parametre.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Paramètres
                                </a>
                                <a href="deconex.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu horizontal -->
        <div class="bg-indigo-600">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex space-x-8 overflow-x-auto">
                    <a href="accueil.php" class="flex items-center px-3 py-4 text-sm font-medium text-white bg-indigo-700 rounded-t-lg">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Tableau de bord
                    </a>
                    <a href="accepte.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                        <i class="fas fa-check mr-2"></i>
                        Acceptées
                    </a>
                    <a href="sauvegarder.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                        <i class="fas fa-ban mr-2"></i>
                        Planifiées
                    </a>
                    <a href="decaisse.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        A Décaisser
                    </a>
                    <a href="point_financier.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                        <i class="fas fa-chart-line mr-2"></i>
                        Point financier
                    </a>
                    <a href="statistique.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                        <i class="fas fa-calculator mr-2"></i>
                        Statistique
                    </a>
                    <?php if ($_SESSION['id_type_groupe'] == 1) { ?>
                        <a href="parametre/parametre.php" class="flex items-center px-3 py-4 text-sm font-medium text-indigo-100 hover:text-white">
                            <i class="fas fa-cogs mr-2"></i>
                            Paramètres
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">
                Fiches à Analyser
            </h1>

            <!-- Formulaire de recherche moderne -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Filtres de recherche</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                    
                    <!-- Affectation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Affectation</label>
                        <select <?php if ($_SESSION['resp_logistique'] == 1 || $_SESSION['resp_technique'] == 1 || $_SESSION['resp_bureau'] == 1 || $_SESSION['resp_rh'] == 1) {
                                    echo ' disabled ';
                                } ?> class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="recher_affectation" name="recher_affectation">
                            <option value="">Toutes les affectations</option>
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

                    <!-- Chantier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chantier</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" id="recher_chantier" name="recher_chantier">
                            <option value="">Tous les chantiers</option>
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

                    <!-- Nom et Prénom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom et Prénom(s)</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" name="recher_demandeur" id="recher_demandeur" placeholder="Nom du demandeur">
                    </div>

                    <!-- Mode de recherche -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mode de recherche</label>
                        <div class="recherche-inverse-container rounded-md p-3">
                            <div class="flex items-center">
                                <input type="checkbox" class="mr-2" name="recherche_inverse" id="recherche_inverse" title="Cocher pour exclure les résultats correspondants">
                                <label class="text-sm" for="recherche_inverse">
                                    <span id="recherche_label">Normale</span>
                                    <i class="fas fa-question-circle ml-1 text-gray-400" title="Recherche normale : inclut les résultats qui correspondent aux critères / Recherche inversée : exclut les résultats qui correspondent aux critères"></i>
                                </label>
                            </div>
                            <div class="recherche-mode-indicator text-xs mt-1" id="recherche_indicator">
                                Inclut les résultats
                            </div>
                        </div>
                    </div>

                    <!-- Date début -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date début</label>
                        <input type="datetime-local" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" name="recher_date_debut" id="recher_date_debut">
                    </div>

                    <!-- Date fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date fin</label>
                        <input type="datetime-local" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" name="recher_date_fin" id="recher_date_fin">
                    </div>
                </div>
            </div>

            <!-- Zone d'affichage des résultats -->
            <div class="chargement text-center py-8 hidden">
                <div class="inline-flex items-center">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mr-3"></div>
                    <span class="text-gray-600">Chargement en cours...</span>
                </div>
            </div>
            
            <div class="affiche_accueil">
                <!-- Le contenu sera chargé ici via AJAX -->
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t mt-16">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <script>document.write(new Date().getFullYear())</script> &copy; BANAMUR.
                    </div>
                    <div class="text-sm text-gray-600">
                        Découvrez nos solutions <a href="https://www.fidest.org" target="_blank" class="text-indigo-600 hover:text-indigo-800">en cliquant ici</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="js/function_accueil.js"></script>
        
        <script>
            function toggleUserMenu() {
                document.getElementById('userMenu').classList.toggle('hidden');
            }

            // Fermer le menu si on clique ailleurs
            document.addEventListener('click', function(event) {
                const userMenu = document.getElementById('userMenu');
                const userButton = event.target.closest('button');
                
                if (!userButton || !userButton.onclick) {
                    userMenu.classList.add('hidden');
                }
            });

            // Script pour améliorer l'interface de recherche inversée
            $(document).ready(function() {
                // Fonction pour mettre à jour le label et les couleurs
                function updateSearchModeDisplay() {
                    var isInverse = $("#recherche_inverse").is(":checked");
                    var label = $("#recherche_label");
                    var indicator = $("#recherche_indicator");
                    var container = $(".recherche-inverse-container");

                    if (isInverse) {
                        label.text("Inversée").addClass("text-red-600 font-semibold").removeClass("text-green-600");
                        indicator.text("Exclut les résultats").addClass("text-red-600").removeClass("text-green-600");
                        container.addClass("bg-red-50 border-red-200").removeClass("bg-green-50 border-green-200");
                    } else {
                        label.text("Normale").addClass("text-green-600 font-semibold").removeClass("text-red-600");
                        indicator.text("Inclut les résultats").addClass("text-green-600").removeClass("text-red-600");
                        container.addClass("bg-green-50 border-green-200").removeClass("bg-red-50 border-red-200");
                    }
                }

                // Écouter les changements de la checkbox
                $("#recherche_inverse").change(function() {
                    updateSearchModeDisplay();
                });

                // Mettre à jour l'affichage au chargement
                updateSearchModeDisplay();
                
                // Charger les résultats par défaut
                chargerResultats();
            });
        </script>
    </body>
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
                                        <div class="col-lg-3 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-4 control-label"><b>Nom et Prénom(s)</b></label>
                                            <input type="text" class="form-control" name="recher_demandeur" id="recher_demandeur" placeholder="Nom et Prénom(s) du demandeur">
                                        </div>
                                        <div class="col-lg-1 col-xs-12" style="margin-top:10px;">
                                            <label class="col-lg-12 control-label"><b>Mode de recherche</b></label>
                                            <div class="form-check recherche-inverse-container">
                                                <input type="checkbox" class="form-check-input" name="recherche_inverse" id="recherche_inverse" title="Cocher pour exclure les résultats correspondants">
                                                <label class="form-check-label" for="recherche_inverse">
                                                    <span id="recherche_label">Normale</span>
                                                    <i class="fas fa-question-circle" title="Recherche normale : inclut les résultats qui correspondent aux critères / Recherche inversée : exclut les résultats qui correspondent aux critères"></i>
                                                </label>
                                                <div class="recherche-mode-indicator" id="recherche_indicator">
                                                    Inclut les résultats
                                                </div>
                                            </div>
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

                <!-- Script pour améliorer l'interface de recherche inversée -->
                <script>
                    $(document).ready(function() {
                        // Fonction pour mettre à jour le label et les couleurs
                        function updateSearchModeDisplay() {
                            var isInverse = $("#recherche_inverse").is(":checked");
                            var label = $("#recherche_label");
                            var indicator = $("#recherche_indicator");
                            var container = $(".recherche-inverse-container");

                            if (isInverse) {
                                label.text("Inversée").removeClass("recherche-label-normal").addClass("recherche-label-inverse");
                                indicator.text("Exclut les résultats").removeClass("recherche-mode-normal").addClass("recherche-mode-inverse");
                                container.removeClass("recherche-inverse-normal").addClass("recherche-inverse-active");
                            } else {
                                label.text("Normale").removeClass("recherche-label-inverse").addClass("recherche-label-normal");
                                indicator.text("Inclut les résultats").removeClass("recherche-mode-inverse").addClass("recherche-mode-normal");
                                container.removeClass("recherche-inverse-active").addClass("recherche-inverse-normal");
                            }
                        }

                        // Mettre à jour l'affichage au chargement
                        updateSearchModeDisplay();

                        // Mettre à jour l'affichage lors du changement
                        $("#recherche_inverse").on("change", function() {
                            updateSearchModeDisplay();

                            // Afficher une notification pour expliquer le changement
                            var isInverse = $(this).is(":checked");
                            var message = isInverse ?
                                "<strong>Mode recherche inversée activé !</strong><br>Les résultats correspondant aux critères seront <strong>EXCLUS</strong> de l'affichage." :
                                "<strong>Mode recherche normale activé !</strong><br>Les résultats correspondant aux critères seront <strong>INCLUS</strong> dans l'affichage.";

                            var alertType = isInverse ? "alert-warning" : "alert-success";
                            var icon = isInverse ? "fa-exclamation-triangle" : "fa-check-circle";

                            // Créer une notification temporaire
                            var notification = $('<div class="alert ' + alertType + ' alert-dismissible fade show recherche-notification" role="alert">' +
                                '<i class="fas ' + icon + '"></i> ' + message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                '</div>');

                            $('body').append(notification);

                            // Supprimer automatiquement après 6 secondes
                            setTimeout(function() {
                                notification.fadeOut(500, function() {
                                    $(this).remove();
                                });
                            }, 6000);
                        });

                        // Ajouter un indicateur visuel au champ de saisie
                        $("#recher_demandeur").on("focus", function() {
                            var isInverse = $("#recherche_inverse").is(":checked");
                            var placeholder = isInverse ?
                                "Tapez un nom pour l'EXCLURE des résultats" :
                                "Tapez un nom pour l'INCLURE dans les résultats";
                            $(this).attr("placeholder", placeholder);
                        }).on("blur", function() {
                            $(this).attr("placeholder", "Nom et Prénom(s) du demandeur");
                        });
                    });
                </script>

    </body>

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>