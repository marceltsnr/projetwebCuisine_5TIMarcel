<?php
require_once "Models/recetteModel.php";

$uri = $_SERVER["REQUEST_URI"];

// -------------------
// Route : Mes recettes
// -------------------
if ($uri === "/mesRecettes") {
    $recettes = selectMyRecettes($pdo);

    // Debug temporaire pour vérifier
    // var_dump($recettes);

    $title = "Mes Recettes";                       
    $template = "Views/pageAccueil.php";           
    require_once "Views/base.php";                 
} 

// -------------------
// Route : Créer une recette
// -------------------
elseif ($uri === "/creerRecette") {
    $messageSuccess = null;

    if (isset($_POST["btnEnvoi"])) {
        $recetteId = insertRecette($pdo);
        $messageSuccess = "Recette créée avec succès !";
    }

    $categories = selectAllCategories($pdo);
    $tags = selectAllTags($pdo);

    $title = "Créer une recette";
    $template = "Views/Recettes/editerOuCreerRecette.php";
    require_once "Views/base.php";
}

// -------------------
// Route : Voir une recette
// -------------------
elseif (isset($_GET["recetteId"]) && strpos($uri, "/voirRecette") === 0) {
    $recette = selectOneRecette($pdo);
    $tags = selectTagsActiveRecette($pdo);

    $title = "Détails de la recette";
    $template = "Views/Recettes/voirRecette.php";
    require_once "Views/base.php";
}

// -------------------
// Route : Modifier une recette
// -------------------
elseif (isset($_GET["recetteId"]) && strpos($uri, "/modifierRecette") === 0) {
    $messageSuccess = null;

    if (isset($_POST['btnEnvoi'])) {
        updateRecette($pdo, (int)$_GET["recetteId"]);
        deleteTagsRecette($pdo, (int)$_GET["recetteId"]);

        foreach ($_POST["tags"] ?? [] as $tagId) {
            ajouterTagsRecette($pdo, (int)$_GET["recetteId"], (int)$tagId);
        }

        $messageSuccess = "Recette modifiée avec succès !";
    }

    $recette = selectOneRecette($pdo, (int)$_GET["recetteId"]);
    $tagsActiveRecette = selectTagsActiveRecette($pdo, (int)$_GET["recetteId"]);
    $tags = selectAllTags($pdo);

    $title = "Modifier une recette";
    $template = "Views/Recettes/editerOuCreerRecette.php";
    require_once "Views/base.php";
}

// -------------------
// Route : Supprimer une recette
// -------------------
elseif (isset($_GET["recetteId"]) && strpos($uri, "/supprimerRecette") === 0) {
    $recette = selectOneRecette($pdo, (int)$_GET["recetteId"]);
    $messageSuccess = null;

    if (isset($_POST['confirmerSuppression'])) {
        deleteTagsRecette($pdo, (int)$_GET["recetteId"]);
        deleteOneRecette($pdo, (int)$_GET["recetteId"]);
        $messageSuccess = "Recette supprimée avec succès !";
    }

    $title = "Supprimer une recette";
    $template = "Views/Recettes/supprimerRecette.php";
    require_once "Views/base.php";
}