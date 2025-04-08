<?php

session_start();

include('../../../logi/connex.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifier si l'OTP soumis correspond à celui enregistré dans la base de données

    $submitted_otp = implode("", $_POST['otp']); // Convertir le tableau en chaîne de caractères

    $num_fiche = $_GET['id_fiche'];



    try {

        // Préparer la requête de sélection pour récupérer l'OTP de la base de données

        $stmt = $con->prepare("SELECT otp FROM fiche WHERE num_fiche=:num_fiche");

        $stmt->execute(array('num_fiche' => $num_fiche));

        $row = $stmt->fetch(PDO::FETCH_ASSOC);



        // Comparer les OTP

        if ($row && $submitted_otp == $row['otp']) {



            // Mettre à jour la colonne otp_valide à true dans la table fiche

            $stmt = $con->prepare("UPDATE fiche SET otp_valide = true WHERE num_fiche = :num_fiche");

            $stmt->execute(array('num_fiche' => $num_fiche));



            // OTP valide, vous pouvez rediriger l'utilisateur vers une page de succès

            header("Location: success_otp_partiel.php?num_fiche=$num_fiche");

            exit();
        } else {

            // OTP invalide, vous pouvez rediriger l'utilisateur vers une page d'erreur

            header("Location: error_otp.php?num_fiche=$num_fiche");

            exit();
        }
    } catch (PDOException $e) {

        // Erreur de connexion à la base de données

        echo "Erreur de connexion : " . $e->getMessage();
    }
}



// Si la méthode de requête n'est pas POST, redirigez l'utilisateur vers la page de saisie d'OTP

header("Location: otp_page.php");

exit();
