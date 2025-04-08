<header class="bg-white shadow-md">
    <div class="max-w-screen-xl mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <a href="accueil.php" class="flex items-center space-x-2">
            <span class="text-xl font-bold text-gray-800"><?php include('titre_ent_ac.php'); ?></span>
        </a>

        <!-- Recherche (cachée sur mobile) -->
        <div class="hidden lg:block flex-1 mx-4">
            <input type="text"
                class="w-full border rounded-lg px-4 py-2 text-sm"
                placeholder="Rechercher... (Ex: Code formation, matricule, etc.)" />
        </div>

        <!-- Profil utilisateur -->
        <div class="relative">
            <button class="flex items-center space-x-2" onclick="toggleMenu()">
                <img src="photo/<?php echo $_SESSION['photo_hop'] ?: 'profile-2398782.png'; ?>"
                    alt="Profil"
                    class="w-10 h-10 rounded-full border" />
                <span class="hidden md:block text-sm font-medium"><?php echo $_SESSION['nom_adm_hop']; ?></span>
            </button>

            <!-- Dropdown -->
            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                <div class="p-4 border-b">
                    <h6 class="font-semibold"><?php echo $_SESSION['nom_adm_hop']; ?></h6>
                    <p class="text-sm text-gray-500"><?php echo $_SESSION['nom_type_groupe']; ?></p>
                </div>
                <ul class="text-sm">
                    <li><a href="profil/profil.php" class="block px-4 py-2 hover:bg-gray-100">Profil</a></li>
                    <li><a href="parametre/parametre.php" class="block px-4 py-2 hover:bg-gray-100">Paramètres</a></li>
                    <li><a href="deconex.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Déconnexion</a></li>
                </ul>
            </div>
        </div>

        <!-- Bouton menu mobile -->
        <button class="lg:hidden ml-4" onclick="toggleNav()">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Menu navigation -->
    <nav id="navMenu" class="lg:block hidden bg-gray-100">
        <div class="max-w-screen-xl mx-auto px-4 py-2">
            <ul class="flex flex-col lg:flex-row gap-2 lg:gap-6 text-sm font-medium">
                <li><a href="accueil.php" class="block px-3 py-2 hover:text-blue-600">Tableau de bord</a></li>
                <li><a href="accepte.php" class="block px-3 py-2 hover:text-green-600">Acceptées</a></li>
                <li><a href="refuse.php" class="block px-3 py-2 hover:text-red-600">Refusées</a></li>
                <li><a href="decaisse.php" class="block px-3 py-2 bg-yellow-400 text-gray-900 rounded-md">À décaisser</a></li>
                <li><a href="sauvegarder.php" class="block px-3 py-2 hover:text-gray-700">Planifiées</a></li>
                <li><a href="point_financier.php" class="block px-3 py-2 hover:text-indigo-600">Point financier</a></li>
                <li><a href="point_chantier.php" class="block px-3 py-2 hover:text-indigo-600">Point chantier</a></li>

                <?php if ($_SESSION['id_type_groupe'] == 1) { ?>
                    <li><a href="parametre/parametre.php" class="block px-3 py-2 hover:text-gray-800">Paramètres</a></li>
                <?php } ?>

                <!-- Sécurité -->
                <li class="relative group">
                    <a href="#" class="block px-3 py-2 hover:text-blue-700">Sécurité ▼</a>
                    <ul class="absolute hidden group-hover:block bg-white shadow-md rounded-md z-20 mt-1">
                        <li><a href="profil/profil.php" class="block px-4 py-2 hover:bg-gray-100">Profil</a></li>
                        <?php if ($_SESSION['id_type_groupe'] <= 2) { ?>
                            <li><a href="utilisateur/utilisateur.php" class="block px-4 py-2 hover:bg-gray-100">Utilisateurs</a></li>
                            <li><a href="historique/historique.php" class="block px-4 py-2 hover:bg-gray-100">Traçabilité</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>