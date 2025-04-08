$(document).ready(function () {
  $("div.msg_erreur").hide();

  $(".annul_decaisse").live("click", function () {
    $(location).attr("href", "decaisse.php");
  });

  $("#montant_decaisser").on("keyup", function () {
    var mont_dec = $("#montant_decaisser").val();

    $.ajax({
      type: "POST",

      url: "src/verif_montant_decaisser_partiel.php",

      data: "mont_dec=" + mont_dec,

      cache: false,

      success: function (result) {
        if (result == 0) {
          $("div.msg_erreur")
            .html(
              '<i class="fa fa-exclammation-triangle"></i> Attention ! Dépassement du montant demandé !'
            )
            .show();

          $(".btn_dec").hide();
        } else {
          $("div.msg_erreur").hide();

          $(".btn_dec").show();
        }
      },
    });
  });

  $(document).on("click", "#submit_decaisse", function (event) {
    event.preventDefault(); // Empêche le comportement par défaut du formulaire

    var montant_decaisser = $("#montant_decaisser").val();
    var num_fiche = $("#num_fiche").val();
    var date_prochain_decaissement = $("#date_prochain_decaissement").val();
    var montant_restant_final = $("#montant_restant_final").val();

    $.ajax({
      type: "POST",
      url: "src/sessions_envoi_otp_partiel.php",
      data: {
        num_fiche: num_fiche,
        montant_decaisser: montant_decaisser,
        date_prochain_decaissement: date_prochain_decaissement,
        montant_restant_final: montant_restant_final,
      },
      cache: false,
      success: function (response) {
        console.log("Réponse : ", response);
        $(location).attr("href", "src/envoi_otp_partiel.php");
      },
      error: function (xhr, status, error) {
        console.error("Erreur : ", error);
      },
    });
  });
});
