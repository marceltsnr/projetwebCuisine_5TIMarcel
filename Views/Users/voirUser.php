<h1><?= htmlspecialchars($userVu->prenomUser) ?> <?= htmlspecialchars($userVu->nomUser) ?></h1>

<div class="flexible wrap space-around">
    <?php foreach ($recettes as $recette) : ?>
        <div class="border card">
            <h2 class="center"><?= $recette->recetteTitre ?></h2>
            <div class="flexible discImageEcole">
                <img src="<?= $recette->recetteImage ?>" alt="photo de la recette">
            </div>
            <div class="center">
                <p><span><?= $recette->recetteDifficulte ?></span> - <span><?= $recette->recetteTempsPreparation ?></span> min</p>
                <h3><a href="/voirrecette?recetteId=<?= $recette->recetteId ?>" class="btn btn-page">Voir la recette</a></h3>
            </div>
        </div>
    <?php endforeach; ?>
</div>