$(document).ready(function () {
    
    
     // Fonction pour charger les résultats
  function chargerResultats() {
    var recher_etat = $("#recher_etat").val() || "";
    var recher_date_debut = $("#recher_date_debut").val() || "";
    var recher_date_fin = $("#recher_date_fin").val() || "";
    var recher_demandeur = $("#recher_demandeur").val() || "";
    var recher_chantier = $("#recher_chantier").val() || "";
    var recher_affectation = $("#recher_affectation").val() || "";
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
      recher_affectation;

    $.ajax({
      type: "POST",
      url: "src/charge_accueil.php",
      data: dataString,
      cache: false,
      beforeSend: function () {
        $("div.chargement")
          .html('<img src="../../img/giphy.gif" style="width:55px; height:55px;" />')
          .show();
        $(".affiche_accueil").hide();
      },
      success: function (result) {
        $("div.chargement").hide();
        $(".affiche_accueil").html(result).show();
      },
    });
  }

  // Charger les résultats par défaut au chargement de la page
  chargerResultats();

  // Recharger les résultats lors de changements dans les champs de recherche
  $("#recher_affectation, #recher_etat, #recher_date_debut, #recher_date_fin, #recher_demandeur, #recher_chantier").on("change keyup", function () {
    chargerResultats();
  });

         
         console.log(  $("#recher_affectation"));
         
             $("#recher_affectation").on("change", function () {
        
      console.log('Affectation changée ! ');
        
      var recher_etat = $("#recher_etat").val();

      var recher_date_debut = $("#recher_date_debut").val();

      var recher_date_fin = $("#recher_date_fin").val();

      var recher_demandeur = $("#recher_demandeur").val();

      var recher_chantier = $("#recher_chantier").val();

      var recher_affectation = $("#recher_affectation").val();

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
        recher_affectation;

      $.ajax({
        type: "POST",

        url: "src/charge_accueil.php",

        data: dataString,

        cache: false,

        beforeSend: function () {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .show();

          $(".affiche_accueil").hide();
        },

        success: function (result) {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .hide();

          $(".affiche_accueil").html(result).show();
        },
      });
    });
    
    $("#recher_etat").on("change", function () {
    var recher_etat = $("#recher_etat").val();

    var recher_date_debut = $("#recher_date_debut").val();

    var recher_date_fin = $("#recher_date_fin").val();

    var recher_demandeur = $("#recher_demandeur").val();

    var recher_chantier = $("#recher_chantier").val();

    var recher_affectation = $("#recher_affectation").val();

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
      recher_affectation;

    $.ajax({
      type: "POST",

      url: "src/charge_accueil.php",

      data: dataString,

      cache: false,

      beforeSend: function () {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .show();

        $(".affiche_accueil").hide();
      },

      success: function (result) {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .hide();

        $(".affiche_accueil").html(result).show();
      },
    });
  });

  $("#recher_date_debut").on("change", function () {
    var recher_etat = $("#recher_etat").val();

    var recher_date_debut = $("#recher_date_debut").val();

    var recher_date_fin = $("#recher_date_fin").val();

    var recher_demandeur = $("#recher_demandeur").val();

    var recher_chantier = $("#recher_chantier").val();

    var recher_affectation = $("#recher_affectation").val();

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
      recher_affectation;

    $.ajax({
      type: "POST",

      url: "src/charge_accueil.php",

      data: dataString,

      cache: false,

      beforeSend: function () {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .show();

        $(".affiche_accueil").hide();
      },

      success: function (result) {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .hide();

        $(".affiche_accueil").html(result).show();
      },
    });
  });

  $("#recher_date_fin").on("change", function () {
    var recher_etat = $("#recher_etat").val();

    var recher_date_debut = $("#recher_date_debut").val();

    var recher_date_fin = $("#recher_date_fin").val();

    var recher_demandeur = $("#recher_demandeur").val();

    var recher_chantier = $("#recher_chantier").val();

    var recher_affectation = $("#recher_affectation").val();

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
      recher_affectation;

    $.ajax({
      type: "POST",

      url: "src/charge_accueil.php",

      data: dataString,

      cache: false,

      beforeSend: function () {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .show();

        $(".affiche_accueil").hide();
      },

      success: function (result) {
        $("div.chargement")
          .html(
            '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
          )
          .hide();

        $(".affiche_accueil").html(result).show();
      },
    });

    document
      .querySelectorAll('input[type="date"]')
      .forEach(function (dateInput) {
        dateInput.addEventListener("change", function () {
          const today = new Date().toISOString().split("T")[0]; // Format AAAA-MM-JJ
          if (this.value <= today) {
            alert(
              "La date sélectionnée ne peut pas précéder ou être égale à la date du jour."
            );
            this.value = ""; // Réinitialise le champ si la date est incorrecte
          }
        });
      });

    $("#recher_demandeur").on("keyup", function () {
      var recher_etat = $("#recher_etat").val();

      var recher_date_debut = $("#recher_date_debut").val();

      var recher_date_fin = $("#recher_date_fin").val();

      var recher_demandeur = $("#recher_demandeur").val();

      var recher_chantier = $("#recher_chantier").val();

      var recher_affectation = $("#recher_affectation").val();

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
        recher_affectation;

      $.ajax({
        type: "POST",

        url: "src/charge_accueil.php",

        data: dataString,

        cache: false,

        beforeSend: function () {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .show();

          $(".affiche_accueil").hide();
        },

        success: function (result) {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .hide();

          $(".affiche_accueil").html(result).show();
        },
      });
    });

    $("#recher_chantier").on("change", function () {
      var recher_etat = $("#recher_etat").val();

      var recher_date_debut = $("#recher_date_debut").val();

      var recher_date_fin = $("#recher_date_fin").val();

      var recher_demandeur = $("#recher_demandeur").val();

      var recher_chantier = $("#recher_chantier").val();

      var recher_affectation = $("#recher_affectation").val();

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
        recher_affectation;

      $.ajax({
        type: "POST",

        url: "src/charge_accueil.php",

        data: dataString,

        cache: false,

        beforeSend: function () {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .show();

          $(".affiche_accueil").hide();
        },

        success: function (result) {
          $("div.chargement")
            .html(
              '<img src="../../img/giphy.gif" style="width:55px; height:55px;" />'
            )
            .hide();

          $(".affiche_accueil").html(result).show();
        },
      });
    });


  $("div.chargement")
    .html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />')
    .show();

  $("div.affiche_accueil").hide();

  setTimeout(function () {
    $("div.chargement")
      .html('<img src="../img/giphy.gif" style="width:55px; height:55px;" />')
      .hide();

    $("div.affiche_accueil").show();

    change_page_accueil("0");
  }, 1500);

  $("div.msg_erreur").hide();


  });

  function change_page_accueil(page_id) {
    var recher_etat = "";

    var recher_date_debut = "";

    var recher_date_fin = "";

    var recher_demandeur = "";

    var recher_chantier = "";

    var recher_affectation = "";

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
      recher_affectation;

    $.ajax({
      type: "POST",

      url: "src/charge_accueil.php",

      data: dataString,

      cache: false,

      success: function (result) {
        $(".affiche_accueil").html(result);
      },
    });
  }
});
