<?php 

// -----------------------------
// Connexion utilisateur
// -----------------------------
function connectUser($pdo) {

    $errors = verifEmptyData();

    if ($errors) {
        return $errors;
    }

    try {

        $query = 'SELECT * FROM utilisateur 
                  WHERE loginUser = :loginUser 
                  AND passWordUser = :passWordUser';

        $connectUser = $pdo->prepare($query);

        $connectUser->execute([
            'loginUser' => $_POST['login'],
            'passWordUser' => $_POST['mot_de_passe']
        ]);

        $user = $connectUser->fetch(PDO::FETCH_OBJ);

        if (!$user) {
            return false;
        } else {
            $_SESSION["user"] = $user;
            return true;
        }

    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }
}


// -----------------------------
// Création d'un utilisateur
// -----------------------------
function createUser($pdo) {

    $errors = verifEmptyData();

    if ($errors) {
        return $errors;
    }

    try {

        $query = 'INSERT INTO utilisateur 
                  (nomUser, prenomUser, loginUser, passWordUser, emailUser, role) 
                  VALUES 
                  (:nomUser, :prenomUser, :loginUser, :passWordUser, :emailUser, :role)';

        $createUser = $pdo->prepare($query);

        $createUser->execute([
            'nomUser' => $_POST["nom"],
            'prenomUser' => $_POST["prenom"],
            'loginUser' => $_POST["login"],
            'passWordUser' => $_POST["mot_de_passe"],
            'emailUser' => $_POST["email"],
            'role' => 'user'
        ]);

        echo "Utilisateur ajouté avec succès";

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }
}


// -----------------------------
// Vérification des champs vides
// -----------------------------
function verifEmptyData() {

    foreach($_POST as $key => $value) {

        if ($key != 'btnEnvoi') {

            if (str_replace(' ', '', $value) == '') {

                $messageError[$key] = "Votre " . $key . " est vide";

            }

        }

    }

    if (isset($messageError)) {
        return $messageError;
    } else {
        return false;
    }
}


// -----------------------------
// Modifier un utilisateur
// -----------------------------
function updateUser($pdo) {

    try {

        $query = 'UPDATE utilisateur 
                  SET nomUser = :nomUser, 
                      prenomUser = :prenomUser, 
                      passWordUser = :passWordUser, 
                      emailUser = :emailUser
                  WHERE id = :id';

        $updateUser = $pdo->prepare($query);

        $updateUser->execute([
            'nomUser' => $_POST["nom"],
            'prenomUser' => $_POST["prenom"],
            'emailUser' => $_POST["email"],
            'passWordUser' => $_POST["mot_de_passe"],
            'id' => $_SESSION["user"]->id
        ]);

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }
}


// -----------------------------
// Mettre à jour la session utilisateur
// -----------------------------
function updateSession($pdo) {

    try {

        $query = 'SELECT * FROM utilisateur WHERE id = :id';

        $selectUser = $pdo->prepare($query);

        $selectUser->execute([
            'id' => $_SESSION["user"]->id
        ]);

        $user = $selectUser->fetch(PDO::FETCH_OBJ);

        $_SESSION["user"] = $user;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Supprimer un utilisateur
// -----------------------------
function deleteUser($pdo) {

    try {

        $id = $_SESSION["user"]->id;

        // Supprimer les tags liés aux recettes de l'utilisateur
        $queryTags = 'DELETE tag_recette 
                      FROM tag_recette
                      INNER JOIN recette 
                      ON tag_recette.recetteId = recette.recetteId
                      WHERE recette.utilisateurId = :id';

        $deleteTags = $pdo->prepare($queryTags);

        $deleteTags->execute([
            'id' => $id
        ]);


        // Supprimer les recettes
        $queryRecettes = 'DELETE FROM recette WHERE utilisateurId = :id';

        $deleteRecettes = $pdo->prepare($queryRecettes);

        $deleteRecettes->execute([
            'id' => $id
        ]);


        // Supprimer l'utilisateur
        $queryUser = 'DELETE FROM utilisateur WHERE id = :id';

        $deleteUser = $pdo->prepare($queryUser);

        $deleteUser->execute([
            'id' => $id
        ]);


        // Détruire la session
        session_unset();
        session_destroy();

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}