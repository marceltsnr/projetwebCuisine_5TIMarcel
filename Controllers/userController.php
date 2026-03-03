<?php
require_once("Models/userModel.php");

// Récupération du chemin désiré
$uri = $_SERVER["REQUEST_URI"];

if ($uri === "/connexion") {
   if (isset($_POST['btnEnvoi'])) {
      if (connectUser($pdo)) {
         // Redirection vers la page d'accueil
         header("location:/");
         exit();
      }
   }
   $title = "Connexion";
   $template = "Views/Users/connexion.php";
   require_once("Views/base.php");
} elseif ($uri === "/deconnexion") {
   session_destroy();
   header("location:/");
   exit();
} elseif ($uri === "/inscription") {
   if (isset($_POST['btnEnvoi'])) {
      $messageError = verifEmptyData();
      if (!$messageError) {
         createUser($pdo);
         header("location:/connexion");
         exit();
      }
   }
   $title = "Inscription";
   $template = "Views/Users/inscription.php";
   require_once("Views/base.php");
} elseif ($uri === "/profil") {
   if (isset($_POST['btnEnvoi'])) {
      $messageError = verifEmptyData();
      if (!$messageError) {
         updateUser($pdo);
         updateSession($pdo);
         header("location:/profil");
         exit();
      }
   }
   if (isset($_POST['btnDelete']) && isset($_SESSION['user'])) {
      deleteUser($pdo);
      header("location:/confirmDeleteUser");
      exit();
   }
   $title = "Mon profil";
   $template = "Views/Users/InscriptionOrEditProfile.php";
   require_once("Views/base.php");
}
elseif ($uri === "/confirmDeleteUser") {
    $title = "Page d'accueil";
    $template = "Views/Users/confirmDeleteUser.php";
    require_once("Views/base.php");
}