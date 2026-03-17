<?php
require_once("Models/userModel.php");

$uri = $_SERVER["REQUEST_URI"];

/* if ($uri === "/administration" || str_starts_with($uri, "/administration?")) {
    var_dump($_GET);
    if (!verifAdmin($pdo, $_SESSION["user"]->id)) {
    var_dump("PAS ADMIN");
    exit();
}

var_dump("EST ADMIN");
exit();
 } */
if ($uri === "/administration" || str_starts_with($uri, "/administration?")) {

    // Vérification que l'utilisateur est connecté
    if (!isset($_SESSION["user"])) {
        header("Location: /connexion");
        exit();
    }

    $title = "Page d'Administration";

    // Vérification des droits admin
    if (!verifAdmin($pdo, $_SESSION["user"]->id)) {
        $error = "Accès non autorisé. Vous devez être administrateur.";
        $template = "Views/Gestion/error.php";
        require_once("Views/base.php");
        exit();
    }

    // Traitement des actions de suspension/réactivation
    $message = null;
    $messageType = null;

    if (isset($_GET['action']) && isset($_GET['id'])) {

        $action = $_GET['action'];
        $id = $_GET['id'];

        // Empêcher l'admin de se suspendre lui-même
        if ($id == $_SESSION["user"]->id) {
            $message = "Vous ne pouvez pas suspendre votre propre compte";
            $messageType = "error";
        } else {
            if ($action === 'suspendre') {
                suspendreUtilisateur($pdo, $id);
                $message = "Utilisateur suspendu avec succès";
                $messageType = "success";
            } elseif ($action === 'reactiver') {
                reactiverUtilisateur($pdo, $id);
                $message = "Utilisateur réactivé avec succès";
                $messageType = "success";
            } elseif ($action === 'promouvoir') {
                promouvoirModerateur($pdo, $id);
                $_SESSION['flash_message'] = "Utilisateur promu modérateur avec succès";
                $_SESSION['flash_type'] = "success";
            } elseif ($action === 'retrograder') {
                retrograderUtilisateur($pdo, $id);
                $_SESSION['flash_message'] = "Utilisateur rétrogradé avec succès";
                $_SESSION['flash_type'] = "success";
            }

            // Redirection pour éviter de re-soumettre l'action si on rafraîchit la page
            header("Location: /administration");
            exit();
        }
    }

    // Récupération de tous les utilisateurs (déjà avec estSuspendu)
    $utilisateurs = getAllUtilisateurs($pdo);

    // Récupération du nombre de recettes pour chaque utilisateur
    $utilisateursData = [];
    foreach ($utilisateurs as $user) {
        $utilisateursData[] = [
            'user' => $user,
            'estSuspendu' => $user->estSuspendu, // Déjà présent dans la requête
            'nbRecettes' => countRecettesByUser($pdo, $user->id)
        ];
    }
    $template = "Views/Gestion/admin.php";
    require_once("Views/base.php");
} elseif ($uri === "/moderation") {

    if (!isset($_SESSION["user"])) {
        header("Location: /connexion");
        exit();
    }

    if ($_SESSION["user"]->role !== 'moderateur' && $_SESSION["user"]->role !== 'admin') {
        header("Location: /");
        exit();
    }

    $utilisateurs = getAllUtilisateurs($pdo);

    $utilisateursData = [];
    foreach ($utilisateurs as $user) {
        $utilisateursData[] = [
            'user' => $user,
            'estSuspendu' => $user->estSuspendu,
            'nbRecettes' => countRecettesByUser($pdo, $user->id)
        ];
    }

    $title = "Page de modération";
    $template = "Views/Gestion/moderation.php";
    require_once("Views/base.php");
}