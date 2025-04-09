<?php
// SessionManager.php

class SessionManager
{
    // Vérifie si l'utilisateur est connecté
    public static function checkSession()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie si les variables de session sont définies
        if (
            isset($_SESSION['pass_hop']) && $_SESSION['pass_hop'] != '' &&
            isset($_SESSION['secur_hop']) && $_SESSION['secur_hop'] != ''
        ) {
            return true; // L'utilisateur est connecté
        }

        return false; // L'utilisateur n'est pas connecté
    }

    // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    public static function redirectIfNotLoggedIn()
    {
        if (!self::checkSession()) {
            header('Location: ../deconex.php'); // Remplace "login.php" par ta page de connexion
            exit();
        }
    }
}
