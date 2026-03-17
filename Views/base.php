<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Css/base.css">
    <link rel="stylesheet" href="../Assets/css/animation.css">
    <link rel="stylesheet" href="../Assets/Css/flex.css">
    <link rel="stylesheet" href="../Assets/css/form.css">
    <link rel="shortcut icon" href="../Assets/Images/logo.png" type="image/x-icon">
    <title><?php $title ?></title>
</head>
<body>
    <header>
    <?php require_once("Views/Components/navBar.php")   ?>
    </header>
    <main>
        <?php require_once("$template"); ?>
    </main>
    <footer>
     <?php require_once("Views/Components/footer.php")   ?>
    </footer>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>