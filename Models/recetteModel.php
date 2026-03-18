<?php

// -----------------------------
// Fonction pour récupérer toutes les recettes
// -----------------------------
function selectAllRecettes($pdo)
{
    try {
        $query = 'SELECT recette.*, categorie.nom AS recetteCategorie, utilisateur.estSuspendu 
                  FROM recette
                  INNER JOIN utilisateur ON recette.utilisateurId = utilisateur.id
                  INNER JOIN categorie ON recette.categorieId = categorie.categorieId
                  WHERE utilisateur.estSuspendu = 0';

        $selectRecette = $pdo->prepare($query);
        $selectRecette->execute();

        $recettes = $selectRecette->fetchAll(PDO::FETCH_OBJ);

        return $recettes;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

// -----------------------------
// Supprimer les tags des recettes d'un utilisateur
// -----------------------------
function deleteTagsRecetteFromUser($pdo)
{
    try {
        $query = 'DELETE FROM tag_recette 
                  WHERE recetteId IN (
                    SELECT recetteId 
                    FROM recette 
                    WHERE utilisateurId = :utilisateurId
                  )';

        $deleteTags = $pdo->prepare($query);

        $deleteTags->execute([
            'utilisateurId' => $_SESSION["utilisateur"]->id
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Supprimer toutes les recettes d'un utilisateur
// -----------------------------
function deleteAllRecettesFromUser($pdo)
{
    try {

        $query = 'DELETE FROM recette 
                  WHERE utilisateurId = :utilisateurId';

        $deleteRecettes = $pdo->prepare($query);

        $deleteRecettes->execute([
            'utilisateurId' => $_SESSION["utilisateur"]->id
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Récupérer les recettes de l'utilisateur connecté
// -----------------------------
function selectMyRecettes($pdo)
{
    try {

        $query = 'SELECT * FROM recette 
                  WHERE utilisateurId = :utilisateurId';

        $selectRecette = $pdo->prepare($query);

        $selectRecette->execute([
            'utilisateurId' => $_SESSION["utilisateur"]->id
        ]);

        $recettes = $selectRecette->fetchAll();

        return $recettes;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Récupérer toutes les catégories
// -----------------------------
function selectAllCategories($pdo)
{
    try {

        $query = 'SELECT * FROM categorie';

        $selectCategories = $pdo->prepare($query);
        $selectCategories->execute();

        $categories = $selectCategories->fetchAll();

        return $categories;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Récupérer tous les tags
// -----------------------------
function selectAllTags($pdo)
{
    try {

        $query = 'SELECT * FROM tag';

        $selectTags = $pdo->prepare($query);
        $selectTags->execute();

        $tags = $selectTags->fetchAll();

        return $tags;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Récupérer une seule recette
// -----------------------------
function selectOneRecette($pdo) {
    try {
        $query = 'SELECT recette.*, categorie.nom AS recetteCategorie
                  FROM recette
                  INNER JOIN categorie ON recette.categorieId = categorie.categorieId
                  WHERE recetteId = :recetteId';

        $selectRecette = $pdo->prepare($query);
        $selectRecette->execute([
            'recetteId' => $_GET["recetteId"]
        ]);

        return $selectRecette->fetch(PDO::FETCH_OBJ);

    } catch (PDOException $e) {
        die($e->getMessage());
    }
}


// -----------------------------
// Récupérer les tags actifs d'une recette
// -----------------------------
function selectTagsActiveRecette($pdo)
{
    try {

        $query = 'SELECT * FROM tag 
                  WHERE tagId IN (
                    SELECT tagId 
                    FROM tag_recette 
                    WHERE recetteId = :recetteId
                  )';

        $selectTags = $pdo->prepare($query);

        $selectTags->execute([
            'recetteId' => $_GET["recetteId"]
        ]);

        $tags = $selectTags->fetchAll();

        return $tags;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Modifier une recette
// -----------------------------
function updateRecette($pdo)
{
    try {
        $query = 'UPDATE recette SET 
          recetteTitre = :titre, 
          recetteDescription = :description, 
          recetteIngredients = :ingredients, 
          recetteEtapes = :etapes, 
          recetteTempsPreparation = :temps_preparation, 
          recetteDifficulte = :difficulte, 
          categorieId = :categorieId, 
          recetteImage = :image 
          WHERE recetteId = :recetteId';

        $updateRecette = $pdo->prepare($query);

        $updateRecette->execute([
            'titre'             => $_POST["titre"],
            'description'       => $_POST["description"],
            'ingredients'       => $_POST["ingredients"],
            'etapes'            => $_POST["etapes"],
            'temps_preparation' => $_POST["temps_preparation"],
            'difficulte'        => $_POST["difficulte"],
            'categorieId'       => $_POST["categorieId"],
            'image'             => $_POST["image"],
            'recetteId'         => $_GET["recetteId"]
        ]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}


// -----------------------------
// Supprimer les tags d'une recette
// -----------------------------
function deleteTagsRecette($pdo, $recetteId)
{
    try {

        $query = 'DELETE FROM tag_recette 
                  WHERE recetteId = :recetteId';

        $deleteTags = $pdo->prepare($query);

        $deleteTags->execute([
            'recetteId' => $recetteId
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Supprimer une recette
// -----------------------------
function deleteOneRecette($pdo)
{
    try {

        $query = 'DELETE FROM recette 
                  WHERE recetteId = :recetteId';

        $deleteRecette = $pdo->prepare($query);

        $deleteRecette->execute([
            'recetteId' => $_GET["recetteId"]
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Ajouter un tag à une recette
// -----------------------------
function ajouterTagsRecette($pdo, $recetteId, $tagId)
{
    try {

        $query = 'INSERT INTO tag_recette (recetteId, tagId) 
                  VALUES (:recetteId, :tagId)';

        $insertTag = $pdo->prepare($query);

        $insertTag->execute([
            'recetteId' => $recetteId,
            'tagId' => $tagId
        ]);
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}

// -----------------------------
// Ajouter une nouvelle recette
// -----------------------------
function insertRecette($pdo)
{
    try {
        $query = 'INSERT INTO recette (
                    recetteTitre, 
                    recetteDescription, 
                    recetteIngredients, 
                    recetteEtapes, 
                    recetteTempsPreparation, 
                    recetteDifficulte, 
                    categorieId, 
                    recetteImage,
                    utilisateurId
                  ) VALUES (
                    :titre, 
                    :description, 
                    :ingredients, 
                    :etapes, 
                    :temps_preparation, 
                    :difficulte, 
                    :categorieId, 
                    :image,
                    :utilisateurId
                  )';

        $insertRecette = $pdo->prepare($query);

        $insertRecette->execute([
            'titre' => $_POST["titre"],
            'description' => $_POST["description"],
            'ingredients' => $_POST["ingredients"],
            'etapes' => $_POST["etapes"],
            'temps_preparation' => $_POST["temps_preparation"],
            'difficulte' => $_POST["difficulte"],
            'categorieId' => $_POST["categorieId"],
            'image' => $_POST["image"],
            'utilisateurId' => $_SESSION["utilisateur"]->id
        ]);

        // Retourner l'ID de la nouvelle recette insérée
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Récupérer les recettes d'un utilisateur par son id
// -----------------------------
function getRecettesByUserId($pdo, $userId)
{
    try {
        $query = 'SELECT * FROM recette WHERE utilisateurId = :utilisateurId';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['utilisateurId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}