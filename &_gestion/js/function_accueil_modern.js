// Fonction globale pour charger les résultats
function chargerResultats() {
  var recher_etat = $("#recher_etat").val() || "";
  var recher_date_debut = $("#recher_date_debut").val() || "";
  var recher_date_fin = $("#recher_date_fin").val() || "";
  var recher_demandeur = $("#recher_demandeur").val() || "";
  var recher_chantier = $("#recher_chantier").val() || "";
  var recher_affectation = $("#recher_affectation").val() || "";
  var recherche_inverse = $("#recherche_inverse").is(":checked") ? "1" : "0";
  var page_id = "0";

  var dataString =
    "page_id=" +
    page_id +
    "&recher_etat=" +
    recher_etat +
    "&recher_date_debut=" +
    recher_date_debut +
    "&recher_date_fin=" +
    recher_date_fin +
    "&recher_demandeur=" +
    recher_demandeur +
    "&recher_chantier=" +
    recher_chantier +
    "&recher_affectation=" +
    recher_affectation +
    "&recherche_inverse=" +
    recherche_inverse;

  $.ajax({
    type: "POST",
    url: "src/charge_accueil.php",
    data: dataString,
    cache: false,
    beforeSend: function () {
      $(".chargement").removeClass("hidden").show();
      $(".affiche_accueil").hide();
    },
    success: function (result) {
      $(".chargement").addClass("hidden").hide();
      $(".affiche_accueil").html(result).show();
    },
    error: function () {
      $(".chargement").addClass("hidden").hide();
      $(".affiche_accueil")
        .html(
          '<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-3xl mb-2"></i><p>Erreur lors du chargement des données</p></div>'
        )
        .show();
    },
  });
}

$(document).ready(function () {
  // Charger les résultats par défaut au chargement de la page
  setTimeout(function () {
    chargerResultats();
  }, 100); // Petit délai pour s'assurer que tous les éléments sont chargés

  // Recharger les résultats lors de changements dans les champs de recherche
  $(document).on(
    "change keyup",
    "#recher_affectation, #recher_etat, #recher_date_debut, #recher_date_fin, #recher_demandeur, #recher_chantier, #recherche_inverse",
    function () {
      chargerResultats();
    }
  );

  // Gestion spéciale pour la checkbox de recherche inversée
  $("#recherche_inverse").on("change", function () {
    // Mettre à jour l'affichage visuel
    updateSearchModeDisplay();
    // Recharger les résultats
    chargerResultats();
  });
});

// Fonction pour mettre à jour l'affichage du mode de recherche
function updateSearchModeDisplay() {
  var isInverse = $("#recherche_inverse").is(":checked");
  var label = $("#recherche_label");
  var indicator = $("#recherche_indicator");
  var container = $(".recherche-inverse-container");

  if (isInverse) {
    label
      .text("Inversée")
      .removeClass("text-green-600")
      .addClass("text-red-600");
    indicator
      .text("Exclut les résultats")
      .removeClass("text-green-600")
      .addClass("text-red-600");
    container
      .removeClass("bg-green-50 border-green-200")
      .addClass("bg-red-50 border-red-200");
  } else {
    label
      .text("Normale")
      .removeClass("text-red-600")
      .addClass("text-green-600");
    indicator
      .text("Inclut les résultats")
      .removeClass("text-red-600")
      .addClass("text-green-600");
    container
      .removeClass("bg-red-50 border-red-200")
      .addClass("bg-green-50 border-green-200");
  }
}

// Fonction pour basculer les menus déroulants
function toggleMenu(menuId) {
  // Fermer tous les autres menus ouverts
  document.querySelectorAll('[id^="menu-"]').forEach((menu) => {
    if (menu.id !== menuId) {
      menu.classList.add("hidden");
    }
  });

  // Basculer le menu demandé
  const menu = document.getElementById(menuId);
  if (menu) {
    menu.classList.toggle("hidden");
  }
}

// Fonction pour reporter une fiche
function reporterFiche(numFiche) {
  if (confirm("Êtes-vous sûr de vouloir reporter cette fiche ?")) {
    // Implémenter la logique de report
    console.log("Reporter la fiche:", numFiche);
    // Ici vous pouvez ajouter un appel AJAX pour reporter la fiche
  }
}

// Fermer les menus en cliquant ailleurs
document.addEventListener("click", function (event) {
  if (!event.target.closest('[onclick*="toggleMenu"]')) {
    document.querySelectorAll('[id^="menu-"]').forEach((menu) => {
      menu.classList.add("hidden");
    });
  }
});

// Fonction de pagination (appelée depuis le backend)
function change_page_accueil(page_id) {
  var recher_date_debut = $("#recher_date_debut").val() || "";
  var recher_date_fin = $("#recher_date_fin").val() || "";
  var recher_demandeur = $("#recher_demandeur").val() || "";
  var recher_chantier = $("#recher_chantier").val() || "";
  var recher_affectation = $("#recher_affectation").val() || "";
  var recherche_inverse = $("#recherche_inverse").is(":checked") ? "1" : "0";

  var dataString =
    "page_id=" +
    page_id +
    "&recher_date_debut=" +
    recher_date_debut +
    "&recher_date_fin=" +
    recher_date_fin +
    "&recher_demandeur=" +
    recher_demandeur +
    "&recher_chantier=" +
    recher_chantier +
    "&recher_affectation=" +
    recher_affectation +
    "&recherche_inverse=" +
    recherche_inverse;

  $.ajax({
    type: "POST",
    url: "src/charge_accueil.php",
    data: dataString,
    cache: false,
    beforeSend: function () {
      $(".chargement").removeClass("hidden").show();
      $(".affiche_accueil").hide();
    },
    success: function (result) {
      $(".chargement").addClass("hidden").hide();
      $(".affiche_accueil").html(result).show();
    },
    error: function () {
      $(".chargement").addClass("hidden").hide();
      $(".affiche_accueil")
        .html(
          '<div class="text-center py-8 text-red-600"><i class="fas fa-exclamation-triangle text-3xl mb-2"></i><p>Erreur lors du chargement des données</p></div>'
        )
        .show();
    },
  });
}
