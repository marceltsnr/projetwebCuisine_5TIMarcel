<?php
require_once("Models/userModel.php");
$uri = $_SERVER["REQUEST_URI"];


/*
|--------------------------------------------------------------------------
| ROUTE : PAGE D'ADMINISTRATION
|--------------------------------------------------------------------------
| Cette condition vérifie si l'utilisateur tente d'accéder à la page
| d'administration. On accepte aussi les URL contenant des paramètres
| (ex : ?action=suspendre&id=3).
*/
if ($uri === "/administration" || str_starts_with($uri, "/administration?")) {

    /*
    |--------------------------------------------------------------------------
    | Vérification de la connexion
    |--------------------------------------------------------------------------
    | Si l'utilisateur n'est pas connecté (aucune session), on le redirige
    | vers la page de connexion.
    */
    if (!isset($_SESSION["user"])) {
        header("Location: /connexion");
        exit();
    }

    $title = "Page d'Administration";

    /*
    |--------------------------------------------------------------------------
    | Vérification des droits administrateur
    |--------------------------------------------------------------------------
    | La fonction verifAdmin() vérifie dans la base de données si
    | l'utilisateur connecté possède le rôle "admin".
    | Si ce n'est pas le cas, on affiche une page d'erreur.
    */
    if (!verifAdmin($pdo, $_SESSION["user"]->id)) {
        $error = "Accès non autorisé. Vous devez être administrateur.";
        $template = "Views/Gestion/error.php";
        require_once("Views/base.php");
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | Gestion des messages système
    |--------------------------------------------------------------------------
    | Ces variables permettent d'afficher un message après une action
    | (succès ou erreur).
    */
    $message = null;
    $messageType = null;


    /*
    |--------------------------------------------------------------------------
    | Traitement des actions administrateur
    |--------------------------------------------------------------------------
    | Si une action est envoyée dans l'URL avec l'id d'un utilisateur,
    | l'administrateur peut :
    | - suspendre un utilisateur
    | - réactiver un utilisateur
    | - promouvoir un utilisateur en modérateur
    | - rétrograder un modérateur en utilisateur
    */
    if (isset($_GET['action']) && isset($_GET['id'])) {

        $action = $_GET['action'];
        $id = $_GET['id'];

        /*
        |--------------------------------------------------------------------------
        | Protection : empêcher un admin de se suspendre lui-même
        |--------------------------------------------------------------------------
        | Cela évite qu'un administrateur bloque accidentellement
        | son propre compte.
        */
        if ($id == $_SESSION["user"]->id) {
            $message = "Vous ne pouvez pas suspendre votre propre compte";
            $messageType = "error";
        } else {

            /*
            |--------------------------------------------------------------------------
            | Suspension d'un utilisateur
            |--------------------------------------------------------------------------
            */
            if ($action === 'suspendre') {
                suspendreUtilisateur($pdo, $id);
                $message = "Utilisateur suspendu avec succès";
                $messageType = "success";

            /*
            |--------------------------------------------------------------------------
            | Réactivation d'un utilisateur suspendu
            |--------------------------------------------------------------------------
            */
            } elseif ($action === 'reactiver') {
                reactiverUtilisateur($pdo, $id);
                $message = "Utilisateur réactivé avec succès";
                $messageType = "success";

            /*
            |--------------------------------------------------------------------------
            | Promotion d'un utilisateur en modérateur
            |--------------------------------------------------------------------------
            */
            } elseif ($action === 'promouvoir') {
                promouvoirModerateur($pdo, $id);
                $_SESSION['flash_message'] = "Utilisateur promu modérateur avec succès";
                $_SESSION['flash_type'] = "success";

            /*
            |--------------------------------------------------------------------------
            | Rétrogradation d'un modérateur en utilisateur simple
            |--------------------------------------------------------------------------
            */
            } elseif ($action === 'retrograder') {
                retrograderUtilisateur($pdo, $id);
                $_SESSION['flash_message'] = "Utilisateur rétrogradé avec succès";
                $_SESSION['flash_type'] = "success";
            }

            /*
            |--------------------------------------------------------------------------
            | Redirection après action
            |--------------------------------------------------------------------------
            | Cette redirection empêche que l'action soit exécutée
            | une deuxième fois si l'utilisateur recharge la page.
            */
            header("Location: /administration");
            exit();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Récupération des utilisateurs
    |--------------------------------------------------------------------------
    | On récupère tous les utilisateurs de la base de données.
    | Chaque utilisateur possède déjà l'information "estSuspendu".
    */
    $utilisateurs = getAllUtilisateurs($pdo);


    /*
    |--------------------------------------------------------------------------
    | Construction des données pour l'affichage
    |--------------------------------------------------------------------------
    | Pour chaque utilisateur, on récupère :
    | - ses informations
    | - son statut de suspension
    | - le nombre de recettes qu'il a publiées
    */
    $utilisateursData = [];

    foreach ($utilisateurs as $user) {
        $utilisateursData[] = [
            'user' => $user,
            'estSuspendu' => $user->estSuspendu,
            'nbRecettes' => countRecettesByUser($pdo, $user->id)
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Chargement de la vue administration
    |--------------------------------------------------------------------------
    */
    $template = "Views/Gestion/admin.php";
    require_once("Views/base.php");
}


/*
|--------------------------------------------------------------------------
| ROUTE : PAGE DE MODÉRATION
|--------------------------------------------------------------------------
| Cette page est accessible aux modérateurs et aux administrateurs.
*/
elseif ($uri === "/moderation") {

    /*
    |--------------------------------------------------------------------------
    | Vérification que l'utilisateur est connecté
    |--------------------------------------------------------------------------
    */
    if (!isset($_SESSION["user"])) {
        header("Location: /connexion");
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | Vérification du rôle
    |--------------------------------------------------------------------------
    | Seuls les modérateurs et administrateurs peuvent accéder
    | à cette page. Sinon redirection vers l'accueil.
    */
    if ($_SESSION["user"]->role !== 'moderateur' && $_SESSION["user"]->role !== 'admin') {
        header("Location: /");
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | Récupération de tous les utilisateurs
    |--------------------------------------------------------------------------
    */
    $utilisateurs = getAllUtilisateurs($pdo);

    /*
    |--------------------------------------------------------------------------
    | Préparation des données pour l'affichage
    |--------------------------------------------------------------------------
    */
    $utilisateursData = [];

    foreach ($utilisateurs as $user) {
        $utilisateursData[] = [
            'user' => $user,
            'estSuspendu' => $user->estSuspendu,
            'nbRecettes' => countRecettesByUser($pdo, $user->id)
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Chargement de la page de modération
    |--------------------------------------------------------------------------
    */
    $title = "Page de modération";
    $template = "Views/Gestion/moderation.php";
    require_once("Views/base.php");
}