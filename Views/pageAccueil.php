<h1>Marmiton-TTI</h1>

<div class="flexible wrap space-around">
    <?php foreach ($recettes as $recette) : ?>
        <div class="border card">
            <!-- Badge "Vos recettes" -->
            <?php if (isset($_SESSION["utilisateur"]) && $recette->utilisateurId === $_SESSION["utilisateur"]->id) : ?>
                <div class="badge-mes-recettes">
                    🍳 Vos recettes
                </div>
            <?php endif; ?>

            <h2 class="center"><?= $recette->recetteTitre ?></h2>
            <div class="flexible discImageEcole">
                <img src="<?= $recette->recetteImage ?>" alt="photo de la recette">
            </div>
            <div class="center">
                <p><span><?= $recette->recetteDifficulte ?></span> - <span><?= $recette->recetteTempsPreparation ?></span> min, <?= $recette->recetteCategorie ?></p>
                <h3><a href="/voirrecette?recetteId=<?= $recette->recetteId ?>" class="btn btn-page">Voir la recette</a></h3>
                <a href="/voirUser?id=<?= $recette->utilisateurId ?>">Voir le profil</a>
                <?php if ($uri == '/mesrecettes') : ?>
                    <p><a href="/supprimerrecette?recetteId=<?= $recette->recetteId ?>">Supprimer la recette</a></p>
                    <p><a href="/modifierrecette?recetteId=<?= $recette->recetteId ?>">Modifier la recette</a></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>