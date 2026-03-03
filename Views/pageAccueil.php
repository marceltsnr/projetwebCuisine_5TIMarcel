<div>
    <!--
    <div class="note-test" style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
        <h3 style="margin-top: 0; color: #856404;">📋 Logins de test :</h3>
        <p style="margin: 5px 0;"><strong>Admin :</strong> celoumar / celoumar</p>
        <p style="margin: 5px 0;"><strong>User :</strong> marcelou / marcelou</p>
    </div>
-->
    <h1>Marmiton-TTI</h1>

    <div class="flexible wrap space-around">
        <?php foreach ($recettes as $recette) : ?>
            <div class="border card">
                <h2 class="center"><?= $recette->recetteTitre ?></h2>
                <div class="flexible discImageEcole">
                    <img src="https://picsum.photos/200/300?random=<?= $recette->recetteImage ?>" alt="photo de la recette">
                </div>
                <div class="center">
                    <p><span class=""><?= $recette->recetteDifficulte ?></span> - <span><?= $recette->recetteTempsPreparation ?></span> min, <?= $recette->recetteCategorie ?></p>
                    <h3><a href="/voirrecette?recetteId=<?= $recette->recetteId ?>" class="btn btn-page">Voir la recette</a></h3>
                    <?php if ($uri == '/mesrecettes') : ?>
                        <p><a href="/supprimerrecette?recetteId=<?= $recette->recetteId ?>">Supprimer la recette</a></p>
                        <p><a href="/modifierrecette?recetteId=<?= $recette->recetteId ?>">Modifier la recette</a></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>