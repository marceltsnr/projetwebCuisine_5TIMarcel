<?php
require_once("Models/recetteModel.php");
require_once("Models/userModel.php");
$uri = $_SERVER["REQUEST_URI"];


/*
|--------------------------------------------------------------------------
| Vérification si l'utilisateur est suspendu
|--------------------------------------------------------------------------
| Si un utilisateur est connecté, on vérifie dans la base de données
| s'il est suspendu.
|
| Si son statut de suspension est égal à 1 :
| - on détruit la session
| - on le redirige vers une page indiquant qu'il est banni
|
| Cela empêche un utilisateur suspendu d'utiliser le site.
*/
if (isset($_SESSION["user"])) {

    // Récupération du statut de suspension dans la base de données
    $statut = getStatutSuspension($pdo, $_SESSION["user"]->id);

    // Si l'utilisateur est suspendu
    if ($statut == 1) {

        // Suppression des données de session
        session_unset();

        // Destruction complète de la session
        session_destroy();

        // Redirection vers la page de bannissement
        header("Location: /ban");
        exit();
    }
}


/*
|--------------------------------------------------------------------------
| ROUTE : PAGE D'ACCUEIL
|--------------------------------------------------------------------------
| Cette condition vérifie si l'utilisateur accède à la page d'accueil.
| Les deux URL possibles sont :
| - /
| - /index.php
|
| Dans ce cas :
| - on récupère toutes les recettes de la base de données
| - on charge la vue de la page d'accueil
*/
if ($uri === "/index"  || $uri === "/index.php" || $uri === "/") {
    // Récupération de toutes les recettes enregistrées
    $recettes = selectAllRecettes($pdo);
    // Titre de la page
    $title = "Page d'accueil";
    // Fichier de vue utilisé pour afficher la page
    $template = "Views/pageAccueil.php";
    // Chargement du template principal
    require_once("Views/base.php");
}