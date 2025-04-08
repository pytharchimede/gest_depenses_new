<?php
session_start();

// Importation des classes
require_once 'model/Database.php';
require_once 'model/Visite.php';
require_once 'model/Fiche.php';
require_once 'model/Affectation.php';
require_once 'model/Chantier.php';


// Instantiations
$databaseObj = new Database();
$pdo = $databaseObj->getConnection();

$visiteObj = new Visite();

$ficheObj = new Fiche($pdo);

$affectationObj = new Affectation($pdo);

$fichesADecaisser = $ficheObj->getFichesADecaisser();

$chantierObj = new Chantier($pdo);

$affectations = $affectationObj->getAllAffectation();

$chantiers = $chantierObj->getAllChantier();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Fiches à Décaisser</title>
    <!-- Ajout de Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <?php include 'inc/header_decaisse.php'; ?>

    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-semibold text-center mb-8">Fiches à Décaisser</h1>


        <?php include 'form/form_search_fiche_decaisse.php'; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 resultsContainer">
            <?php foreach ($fichesADecaisser as $fiche): ?>
                <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all flex flex-col justify-between">

                    <!-- Photo du bénéficiaire -->
                    <div class="flex justify-center mb-4">
                        <img src="../../img_demande/<?php echo htmlspecialchars($fiche['photo_beneficiaire']); ?>"
                            alt="Photo de <?php echo htmlspecialchars($fiche['beficiaire_fiche']); ?>"
                            class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500 shadow-md">
                    </div>

                    <!-- Infos principales -->
                    <h2 class="text-xl font-semibold text-center mb-1"><?php echo htmlspecialchars($fiche['beficiaire_fiche']); ?></h2>
                    <p class="text-gray-600 text-center text-sm mb-1">Fiche N° <?php echo htmlspecialchars($fiche['num_fiche']); ?></p>
                    <p class="text-green-600 font-bold text-lg text-center mb-2">
                        <?php echo number_format($fiche['montant_fiche'], 0, ',', ' ') ?> CFA
                    </p>

                    <!-- Détails -->
                    <div class="text-sm text-gray-700 mb-4">
                        <p><strong>Affectation:</strong>
                            <?php echo htmlspecialchars($affectationObj->getAffectationById($fiche['affectation_id'])['lib_affectation']); ?>
                        </p>
                        <p><strong>Pièce:</strong> <?php echo htmlspecialchars($fiche['num_piece']); ?></p>
                        <p><strong>Désignation:</strong> <?php echo htmlspecialchars($fiche['designation_fiche']); ?></p>
                    </div>

                    <!-- Date + Actions -->
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-gray-500">
                            <?= date('d M Y', strtotime($fiche['date_creat_fiche'])); ?>
                        </span>
                        <div class="flex gap-2">
                            <!-- Décaissement total -->
                            <a href="https://fidest.ci/logi/&_gestion/confirm_decaisse.php?num_fiche=<?php echo $fiche['num_fiche']; ?>"
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs shadow">
                                Décaisser Totalement
                            </a>

                            <!-- Décaissement partiel -->
                            <a href="https://fidest.ci/logi/&_gestion/confirm_decaisse_partiel.php?num_fiche=<?php echo $fiche['num_fiche']; ?>"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs shadow">
                                Décaisser Partiellement
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>

    <script>
        function toggleMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }

        function toggleNav() {
            document.getElementById('navMenu').classList.toggle('hidden');
        }

        function searchFiches() {

            let formData = new FormData(document.getElementById('searchForm'));

            console.log(formData);

            fetch('request/search_fiches.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mettre à jour les résultats sur la page
                        updateResults(data.fiches);
                    } else {
                        // Gérer l'erreur si aucune fiche n'est trouvée
                        alert('Aucune fiche trouvée');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }

        function updateResults(fiches) {
            let resultsContainer = document.querySelector('.resultsContainer');
            resultsContainer.innerHTML = ''; // Effacer les anciens résultats

            fiches.forEach(fiche => {
                resultsContainer.innerHTML += `
            <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transition-all flex flex-col justify-between">
                <div class="flex justify-center mb-4">
                    <img src="../../img_demande/${fiche.photo_beneficiaire}" alt="Photo de ${fiche.beficiaire_fiche}"
                        class="w-24 h-24 rounded-full object-cover border-4 border-indigo-500 shadow-md">
                </div>
                <h2 class="text-xl font-semibold text-center mb-1">${fiche.beficiaire_fiche}</h2>
                <p class="text-gray-600 text-center text-sm mb-1">Fiche N° ${fiche.num_fiche}</p>
                <p class="text-green-600 font-bold text-lg text-center mb-2">${new Intl.NumberFormat().format(fiche.montant_fiche)} CFA</p>
                <div class="text-sm text-gray-700 mb-4">
                    <p><strong>Affectation:</strong> ${fiche.affectation}</p>
                    <p><strong>Pièce:</strong> ${fiche.num_piece}</p>
                    <p><strong>Désignation:</strong> ${fiche.designation_fiche}</p>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">${new Date(fiche.date_creat_fiche).toLocaleDateString()}</span>
                    <div class="flex gap-2">
                        <a href="decaisse_total.php?id=${fiche.id_fiche}"
                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs shadow">
                            Décaisser Totalement
                        </a>
                        <a href="decaisse_partiel.php?id=${fiche.id_fiche}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs shadow">
                            Décaisser Partiellement
                        </a>
                    </div>
                </div>
            </div>
        `;
            });
        }
    </script>


</body>

</html>