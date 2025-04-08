<form id="searchForm" class="bg-white p-4 rounded-xl shadow-md mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Nom du bénéficiaire -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Nom du bénéficiaire</label>
            <input type="text" name="beneficiaire"
                placeholder="Ex: Koffi"
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" />
        </div>

        <!-- Statut -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Statut de la fiche</label>
            <select name="statut" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">-- Tous --</option>
                <option value="en_attente">En attente</option>
                <option value="acceptee">Acceptée</option>
                <option value="refusee">Refusée</option>
                <option value="decaissee">Décaissement effectué</option>
            </select>
        </div>

        <!-- Date début -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Date de début</label>
            <input type="date" name="date_debut"
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" />
        </div>

        <!-- Date fin -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Date de fin</label>
            <input type="date" name="date_fin"
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" />
        </div>

        <!-- Date de décaissement prévue -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Date de décaissement prévue</label>
            <input type="date" name="date_decaissement"
                class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" />
        </div>

        <!-- Chantier -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Chantier</label>
            <select name="chantier" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">-- Tous les chantiers --</option>
                <?php
                // Exemple : liste des chantiers depuis la BDD
                foreach ($chantiers as $chantier) {
                    echo "<option value='{$chantier['id_chantier']}'>{$chantier['lib_chantier']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Affectation -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Affectation</label>
            <select name="affectation" class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">-- Toutes les affectations --</option>
                <?php
                // Exemple : liste des affectations depuis la BDD
                foreach ($affectations as $aff) {
                    echo "<option value='{$aff['id_affectation']}'>{$aff['lib_affectation']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Boutons -->
    <div class="mt-4 flex items-center gap-2">
        <button type="button" onclick="searchFiches()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold">
            Rechercher
        </button>
        <a href="page_resultat.php"
            class="text-sm text-gray-600 hover:underline">Réinitialiser</a>
    </div>
</form>