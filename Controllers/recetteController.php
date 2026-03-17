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
*/
elseif ($uri === "/creerRecette") {

    // Message de confirmation après création
    $messageSuccess = null;

    // Vérifie si le formulaire a été envoyé
    if (isset($_POST["btnEnvoi"])) {

        // Insertion de la recette dans la base de données
        $recetteId = insertRecette($pdo);

        // Message affiché après succès
        $messageSuccess = "Recette créée avec succès !";
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
*/
elseif (isset($_GET["recetteId"]) && strpos($uri, "/voirRecette") === 0) {

    // Récupération des informations de la recette
    $recette = selectOneRecette($pdo);

    // Récupération des tags associés à cette recette
    $tags = selectTagsActiveRecette($pdo);

    // Titre de la page
    $title = "Détails de la recette";

    // Vue utilisée pour afficher les détails
    $template = "Views/Recettes/voirRecette.php";

    // Chargement du template principal
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
*/
elseif (isset($_GET["recetteId"]) && strpos($uri, "/modifierRecette") === 0) {

    $messageSuccess = null;

    // Vérifie si le formulaire a été envoyé
    if (isset($_POST['btnEnvoi'])) {

        // Mise à jour des informations de la recette
        updateRecette($pdo, (int)$_GET["recetteId"]);

        // Suppression des anciens tags associés à la recette
        deleteTagsRecette($pdo, (int)$_GET["recetteId"]);

        // Ajout des nouveaux tags sélectionnés
        foreach ($_POST["tags"] ?? [] as $tagId) {
            ajouterTagsRecette($pdo, (int)$_GET["recetteId"], (int)$tagId);
        }

        // Message de confirmation
        $messageSuccess = "Recette modifiée avec succès !";
    }

    // Récupération des données actuelles de la recette
    $recette = selectOneRecette($pdo, (int)$_GET["recetteId"]);

    // Récupération des tags déjà associés à la recette
    $tagsActiveRecette = selectTagsActiveRecette($pdo, (int)$_GET["recetteId"]);

    // Récupération de tous les tags disponibles
    $tags = selectAllTags($pdo);

    // Titre de la page
    $title = "Modifier une recette";

    // Vue utilisée pour le formulaire d'édition
    $template = "Views/Recettes/editerOuCreerRecette.php";

    // Chargement du template principal
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
*/
elseif (isset($_GET["recetteId"]) && strpos($uri, "/supprimerRecette") === 0) {

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