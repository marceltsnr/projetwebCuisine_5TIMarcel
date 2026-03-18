<?php

/*
|--------------------------------------------------------------------------
| Chargement des modèles
|--------------------------------------------------------------------------
| Ces fichiers permettent d'accéder aux fonctions liées à la base
| de données :
| - recetteModel : gestion des recettes
| - userModel : gestion des utilisateurs
*/
require_once "Models/recetteModel.php";
require_once("Models/userModel.php");


/*
|--------------------------------------------------------------------------
| Récupération de l'URL demandée
|--------------------------------------------------------------------------
| Cette variable permet de savoir quelle page l'utilisateur souhaite
| afficher afin d'exécuter le bon traitement.
*/
$uri = $_SERVER["REQUEST_URI"];


/*
|--------------------------------------------------------------------------
| ROUTE : MES RECETTES
|--------------------------------------------------------------------------
| Cette route permet à l'utilisateur connecté d'afficher uniquement
| les recettes qu'il a créées.
|
| La fonction selectMyRecettes() récupère toutes les recettes
| associées à l'utilisateur dans la base de données.
*/
if ($uri === "/mesRecettes") {
    // Récupération des recettes de l'utilisateur
    $recettes = selectMyRecettes($pdo);

    // Debug temporaire pour vérifier les données récupérées
    // var_dump($recettes);

    // Titre de la page
    $title = "Mes Recettes";

    // Vue utilisée pour afficher les recettes
    $template = "Views/pageAccueil.php";

    // Chargement du template principal
    require_once "Views/base.php";
}


/*
|--------------------------------------------------------------------------
| ROUTE : CRÉER UNE RECETTE
|--------------------------------------------------------------------------
| Cette route permet à l'utilisateur de créer une nouvelle recette.
|
| Étapes :
| 1. Vérification si le formulaire a été envoyé
| 2. Insertion de la recette dans la base de données
| 3. Chargement des catégories et tags disponibles
| 4. Affichage du formulaire de création
*/ elseif ($uri === "/creerRecette") {

    // Message de confirmation après création
    $messageSuccess = null;

    if (isset($_POST["btnEnvoi"])) {
        $recetteId = insertRecette($pdo);
        header("Location: /");
        exit();
    }

    // Récupération des catégories disponibles
    $categories = selectAllCategories($pdo);

    // Récupération des tags disponibles
    $tags = selectAllTags($pdo);

    // Titre de la page
    $title = "Créer une recette";

    // Vue contenant le formulaire de création
    $template = "Views/Recettes/editerOuCreerRecette.php";

    // Chargement du template principal
    require_once "Views/base.php";
}


/*
|--------------------------------------------------------------------------
| ROUTE : VOIR UNE RECETTE
|--------------------------------------------------------------------------
| Cette route permet d'afficher les détails d'une recette.
|
| L'id de la recette est récupéré dans l'URL via le paramètre GET.
| Exemple :
| /voirRecette?recetteId=5
|
| Les informations récupérées sont :
| - les données de la recette
| - les tags associés à la recette
*/ elseif (isset($_GET["recetteId"]) && str_starts_with($uri, "/voirrecette")) {

    $recette = selectOneRecette($pdo);
    $tags = selectTagsActiveRecette($pdo);

    $title = "Détails de la recette";
    $template = "Views/Recettes/voirRecette.php";
    require_once "Views/base.php";
}



/*
|--------------------------------------------------------------------------
| ROUTE : MODIFIER UNE RECETTE
|--------------------------------------------------------------------------
| Cette route permet de modifier une recette existante.
|
| Étapes :
| 1. Vérification si le formulaire de modification est envoyé
| 2. Mise à jour des informations de la recette
| 3. Suppression des anciens tags
| 4. Ajout des nouveaux tags sélectionnés
*/ elseif (isset($_GET["recetteId"]) && strpos($uri, "/modifierRecette") === 0) {

    $messageSuccess = null;

    // On récupère la recette EN PREMIER (avant le traitement du POST)
    $recette = selectOneRecette($pdo);
    $tagsActiveRecette = selectTagsActiveRecette($pdo);
    $tags = selectAllTags($pdo);
    $categories = selectAllCategories($pdo);

    if (isset($_POST['btnEnvoi'])) {

        updateRecette($pdo);

        deleteTagsRecette($pdo, (int)$_GET["recetteId"]);

        foreach ($_POST["tags"] ?? [] as $tagId) {
            ajouterTagsRecette($pdo, (int)$_GET["recetteId"], (int)$tagId);
        }

        // On recharge pour afficher les données à jour
        $recette = selectOneRecette($pdo);
        $tagsActiveRecette = selectTagsActiveRecette($pdo);

        $messageSuccess = "Recette modifiée avec succès !";
    }

    $title = "Modifier une recette";
    $template = "Views/Recettes/editerOuCreerRecette.php";
    require_once "Views/base.php";
}


/*
|--------------------------------------------------------------------------
| ROUTE : SUPPRIMER UNE RECETTE
|--------------------------------------------------------------------------
| Cette route permet de supprimer une recette existante.
|
| Étapes :
| 1. Afficher une page de confirmation
| 2. Si l'utilisateur confirme :
|    - suppression des tags associés
|    - suppression de la recette
*/ elseif (isset($_GET["recetteId"]) && strpos($uri, "/supprimerRecette") === 0) {

    // Récupération de la recette à supprimer
    $recette = selectOneRecette($pdo, (int)$_GET["recetteId"]);

    $messageSuccess = null;

    // Vérifie si l'utilisateur confirme la suppression
    if (isset($_POST['confirmerSuppression'])) {

        // Suppression des tags liés à la recette
        deleteTagsRecette($pdo, (int)$_GET["recetteId"]);

        // Suppression de la recette dans la base de données
        deleteOneRecette($pdo, (int)$_GET["recetteId"]);

        // Message de confirmation
        $messageSuccess = "Recette supprimée avec succès !";
    }

    // Titre de la page
    $title = "Supprimer une recette";

    // Vue de confirmation de suppression
    $template = "Views/Recettes/supprimerRecette.php";

    // Chargement du template principal
    require_once "Views/base.php";
}
