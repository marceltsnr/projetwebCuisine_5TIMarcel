<?php

require_once("Models/recetteModel.php");
require_once("Models/userModel.php");

// Vérification si l'utilisateur connecté est suspendu
if (isset($_SESSION["user"])) {
    $statut = getStatutSuspension($pdo, $_SESSION["user"]->id);
    if ($statut == 1) {
        session_unset();
        session_destroy();
        header("Location: /ban");
        exit();
    }
}
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/index.php" || $uri === "/") {
    // Récuperer toutes les données de la table school 
    $recettes = selectAllRecettes($pdo);
    $title = "Page d'accueil";
    $template = "Views/pageAccueil.php";
    require_once("Views/base.php");
}
