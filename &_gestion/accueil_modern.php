<?php
session_start();
$page = 'accueil';
if ($_SESSION['id_admin_hop'] != '') {
    include('model/Database.php');
    include('model/SessionManager.php');
    $sessionManager = new SessionManager();
    $sessionManager->validateSession('accueil');

    // Initialisation de la connexion à la base de données
    try {
        $database = new Database();
        $con = $database->getConnection();
    } catch (Exception $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    // Enregistrement connexion
    $date = date("Y-m-d");
    $result = $con->prepare("INSERT INTO visite (ip, date, heure) VALUES (?, ?, ?)");
    $result->execute([$_SERVER['REMOTE_ADDR'], $date, time()]);
?>
    <!doctype html>
    <html lang="fr">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        <title><?php include('titre_ent_1.php'); ?> | Accueil</title>

        <!-- Tailwind CSS pour un design moderne -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Font Awesome pour les icônes -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- CSS personnalisé pour la recherche inversée -->
        <style>
            .recherche-inverse-container {
                transition: all 0.3s ease;
                border: 2px solid transparent;
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
                                <option value="<?php echo $ro['id_affectation']; ?>" <?php
                                                                                        if ($_SESSION['resp_rh'] == 1 && $ro['id_affectation'] == 28) {
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
                                                                                        }  ?>><?php echo stripslashes($ro['lib_affectation']); ?></option>
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
                                <option value="<?php echo $ro['id_chantier']; ?>"><?php echo stripslashes($ro['lib_chantier']); ?></option>
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
                        <div class="recherche-inverse-container rounded-md p-3 bg-green-50 border-green-200">
                            <div class="flex items-center">
                                <input type="checkbox" class="mr-2" name="recherche_inverse" id="recherche_inverse" title="Cocher pour exclure les résultats correspondants">
                                <label class="text-sm" for="recherche_inverse">
                                    <span id="recherche_label" class="text-green-600 font-semibold">Normale</span>
                                    <i class="fas fa-question-circle ml-1 text-gray-400" title="Recherche normale : inclut les résultats qui correspondent aux critères / Recherche inversée : exclut les résultats qui correspondent aux critères"></i>
                                </label>
                            </div>
                            <div class="recherche-mode-indicator text-xs mt-1 text-green-600" id="recherche_indicator">
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
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; BANAMUR.
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
                        label.text("Inversée").removeClass("text-green-600").addClass("text-red-600");
                        indicator.text("Exclut les résultats").removeClass("text-green-600").addClass("text-red-600");
                        container.removeClass("bg-green-50 border-green-200").addClass("bg-red-50 border-red-200");
                    } else {
                        label.text("Normale").removeClass("text-red-600").addClass("text-green-600");
                        indicator.text("Inclut les résultats").removeClass("text-red-600").addClass("text-green-600");
                        container.removeClass("bg-red-50 border-red-200").addClass("bg-green-50 border-green-200");
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

    </html>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0; url=deconex.php" />';
}
?>