<h1>Marmiton-TTI</h1>

<div class="flexible wrap space-around">
    <?php foreach ($recettes as $recette) : ?>
        <div class="border card">
            <h2 class="center"><?= $recette->recetteTitre ?></h2>
            <div class="flexible discImageEcole">
                <img src="https://picsum.photos/200/300?random=<?= $recette->recetteImage ?>" alt="photo de la recette">
            </div>
            <div class="center">
                <p><span><?= $recette->recetteDifficulte ?></span> - <span><?= $recette->recetteTempsPreparation ?></span> min, <?= $recette->recetteCategorie ?></p>
                <h3><a href="/voirrecette?recetteId=<?= $recette->recetteId ?>" class="btn btn-page">Voir la recette</a></h3>
                <?php if ($uri == '/mesrecettes') : ?>
                    <p><a href="/supprimerrecette?recetteId=<?= $recette->recetteId ?>">Supprimer la recette</a></p>
                    <p><a href="/modifierrecette?recetteId=<?= $recette->recetteId ?>">Modifier la recette</a></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>