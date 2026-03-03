<?php 
function connectUser($pdo) {
    // Vérifie si les champs login et mot de passe ne sont pas vides
    $errors = verifEmptyData();
    if ($errors) {
        return $errors; // retourne les erreurs si un champ est vide
    }

    try {
        $query = 'select * FROM utilisateur where loginUser = :loginUser and passWordUser = :passWordUser';
        $connectUser = $pdo->prepare($query);
        $connectUser->execute([
            'loginUser' => $_POST['login'],
            'passWordUser' => $_POST['mot_de_passe']
        ]);
        $user = $connectUser->fetch();
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

function createUser($pdo) {
    // Vérifie que tous les champs sont remplis
    $errors = verifEmptyData();
    if ($errors) {
        return $errors; // retourne les erreurs si un champ est vide
    }

    try {
        $query = 'INSERT INTO utilisateur (nomUser, prenomUser, loginUser, passWordUser, emailUser, role) 
                  VALUES (:nomUser, :prenomUser, :loginUser, :passWordUser, :emailUser, :role)';
        
        $ajouterUser = $pdo->prepare($query);
        $ajouterUser->execute([
            ':nomUser' => $_POST["nom"],
            ':prenomUser' => $_POST["prenom"],
            ':loginUser' => $_POST["login"],
            ':passWordUser' => $_POST["mot_de_passe"],
            ':emailUser' => $_POST["email"],
            ':role' => 'user'
        ]);

        echo "Utilisateur ajouté avec succès !";
    } 
    catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

function verifEmptyData() {
    foreach($_POST as $key => $value) {
        if ($key != 'btnEnvoi') {
            if (empty(str_replace(' ', '', $value))) {
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
function updateUser($pdo) {
    try {
        $query = 'UPDATE utilisateur SET nomUser = :nomUser, prenomUser = :prenomUser, passWordUser = :passWordUser, emailUser = :emailUser
                  WHERE id = :id';
         $ajouterUser = $pdo->prepare($query);
         $ajouterUser->execute([
            'nomUser' => $_POST["nom"],
            'prenomUser' => $_POST["prenom"],
            'emailUser' => $_POST["email"],
            'passWordUser' => $_POST["mot_de_passe"],
            'id' => $_SESSION["user"]->id
         ]);
        }   catch (PDOException $e) {
            $message = $e->getMessage();
            die($message);
        }
}
function updateSession($pdo) {
    try {
        $query = 'select * from utilisateur where id = :id';
        $selectUser = $pdo->prepare($query);
        $selectUser->execute([
            'id' => $_SESSION["user"]->id
        ]);
        $user = $selectUser->fetch();
        $_SESSION["user"] = $user;
    } catch (PDOException $e) {
        $message = $e->getMessage();
        die($message);
    }   
}
function DeleteUser($pdo) {
    try {
        $id = $_SESSION["user"]->id;

        $queryTags = 'DELETE tag_recette 
                      FROM tag_recette
                      INNER JOIN recette ON tag_recette.recetteId = recette.recetteId
                      WHERE recette.utilisateurId = :id';
        $delTags = $pdo->prepare($queryTags);
        $delTags->execute(['id' => $id]);

        $queryRecettes = 'DELETE FROM recette WHERE utilisateurId = :id';
        $delRecettes = $pdo->prepare($queryRecettes);
        $delRecettes->execute(['id' => $id]);

        $queryUser = 'DELETE FROM utilisateur WHERE id = :id';
        $delUser = $pdo->prepare($queryUser);
        $delUser->execute(['id' => $id]);

        session_unset();
        session_destroy();

    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    }  
}