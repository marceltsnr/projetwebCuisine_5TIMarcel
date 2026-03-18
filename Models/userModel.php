<?php 

// ============================================
// FONCTIONS D'AUTHENTIFICATION ET UTILISATEUR
// ============================================

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
        }
        
        // Vérifier si le compte est suspendu
        if ($user->estSuspendu == 1) {
            return "suspendu";
        }
        
        $_SESSION["utilisateur"] = $user;
        return true;

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
                  (nomUser, prenomUser, loginUser, passWordUser, emailUser, role, estSuspendu) 
                  VALUES 
                  (:nomUser, :prenomUser, :loginUser, :passWordUser, :emailUser, :role, 0)';

        $createUser = $pdo->prepare($query);

        $createUser->execute([
            'nomUser' => $_POST["nom"],
            'prenomUser' => $_POST["prenom"],
            'loginUser' => $_POST["login"],
            'passWordUser' => $_POST["mot_de_passe"],
            'emailUser' => $_POST["email"],
            'role' => 'user'
        ]);

        return true;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

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
            'id' => $_SESSION["utilisateur"]->id
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
            'id' => $_SESSION["utilisateur"]->id
        ]);

        $user = $selectUser->fetch(PDO::FETCH_OBJ);

        $_SESSION["utilisateur"] = $user;

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

        $id = $_SESSION["utilisateur"]->id;

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


// ============================================
// FONCTIONS D'ADMINISTRATION (GESTION DES COMPTES)
// ============================================

// -----------------------------
// Récupérer tous les utilisateurs
// -----------------------------
function getAllUtilisateurs($pdo) {

    try {

        $query = 'SELECT id, nomUser, prenomUser, loginUser, role, emailUser, estSuspendu
                  FROM utilisateur 
                  ORDER BY id';

        $getAllUtilisateurs = $pdo->prepare($query);
        $getAllUtilisateurs->execute();

        $utilisateurs = $getAllUtilisateurs->fetchAll(PDO::FETCH_OBJ);

        return $utilisateurs;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Suspendre un utilisateur
// -----------------------------
function suspendreUtilisateur($pdo, $id) {

    try {

        $query = 'UPDATE utilisateur 
                  SET estSuspendu = 1 
                  WHERE id = :id';

        $suspendreUser = $pdo->prepare($query);

        $suspendreUser->execute([
            'id' => $id
        ]);

        return true;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Réactiver un utilisateur
// -----------------------------
function reactiverUtilisateur($pdo, $id) {

    try {

        $query = 'UPDATE utilisateur 
                  SET estSuspendu = 0 
                  WHERE id = :id';

        $reactiverUser = $pdo->prepare($query);

        $reactiverUser->execute([
            'id' => $id
        ]);

        return true;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Récupérer le statut de suspension
// -----------------------------
function getStatutSuspension($pdo, $id) {

    try {

        $query = 'SELECT estSuspendu FROM utilisateur WHERE id = :id';

        $getStatut = $pdo->prepare($query);

        $getStatut->execute([
            'id' => $id
        ]);

        $user = $getStatut->fetch(PDO::FETCH_OBJ);

        if ($user) {
            return $user->estSuspendu;
        } else {
            return null;
        }

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Vérifier si l'utilisateur est admin
// -----------------------------
function verifAdmin($pdo, $userId) {

    try {

        $query = 'SELECT role FROM utilisateur WHERE id = :id';

        $verifAdmin = $pdo->prepare($query);

        $verifAdmin->execute([
            'id' => $userId
        ]);

        $user = $verifAdmin->fetch(PDO::FETCH_OBJ);

        if ($user && $user->role === 'admin') {
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// -----------------------------
// Compter les recettes d'un utilisateur
// -----------------------------
function countRecettesByUser($pdo, $userId) {

    try {

        $query = 'SELECT COUNT(*) as total 
                  FROM recette 
                  WHERE utilisateurId = :userId';

        $countRecettes = $pdo->prepare($query);

        $countRecettes->execute([
            'userId' => $userId
        ]);

        $result = $countRecettes->fetch(PDO::FETCH_OBJ);

        return $result->total;

    } catch (PDOException $e) {

        $message = $e->getMessage();
        die($message);

    }

}


// ============================================
// FONCTIONS UTILITAIRES
// ============================================

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

function promouvoirModerateur($pdo, $id) {
    try {
        $query = 'UPDATE utilisateur SET role = :role WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['role' => 'moderateur', 'id' => $id]);
        return true;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function retrograderUtilisateur($pdo, $id) {
    try {
        $query = 'UPDATE utilisateur SET role = :role WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['role' => 'user', 'id' => $id]);
        return true;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

// -----------------------------
// Récupérer un utilisateur par son id
// -----------------------------
function getUserById($pdo, $id)
{
    try {
        $query = 'SELECT * FROM utilisateur WHERE id = :id';
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}