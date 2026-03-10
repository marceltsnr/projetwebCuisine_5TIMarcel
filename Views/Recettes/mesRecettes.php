<?php if (isset($_SESSION["user"])) : ?>
    <a href="/creerRecette" class="btn btn-primary mb-3">Ajouter une recette</a>
<?php endif; ?>

<?php
// Récupérer toutes les recettes
$recettes = $pdo->query('SELECT * FROM recette')->fetchAll(PDO::FETCH_OBJ);

// Vérifier que l'utilisateur et les recettes existent
if (!$recettes) {
    echo "<p>Aucune recette disponible.</p>";
}
?>

<div class="flexible wrap space-around">
    <?php foreach ($recettes as $recette) : ?>
        <?php
        // Vérifie que la recette appartient à l'utilisateur connecté
        if (!isset($_SESSION["user"]) || (int)$recette->utilisateurId !== (int)$_SESSION["user"]->id) {
            continue;
        }
        ?>

        <div class="border card">
            <h2 class="center"><?= htmlspecialchars($recette->recetteTitre) ?></h2>

            <div class="flexible discImageEcole">
                <?php if (!empty($recette->recetteImage)) : ?>
                    <img src="<?= htmlspecialchars($recette->recetteImage) ?>" alt="Photo de la recette">
                <?php else : ?>
                    <p>Aucune image disponible</p>
                <?php endif; ?>
            </div>

            <div class="center">
                <p>
                    <span><?= htmlspecialchars($recette->recetteDifficulte) ?></span> -
                    <span><?= (int)$recette->recetteTempsPreparation ?></span> min,
                    <?= htmlspecialchars($recette->recetteCategorie ?? "Non catégorisée") ?>
                </p>

                <h3>
                    <a href="/voirRecette?recetteId=<?= (int)$recette->recetteId ?>" class="btn btn-page">
                        Voir la recette
                    </a>
                </h3>

                <!-- Boutons visibles uniquement pour le propriétaire -->
                <p>
                    <a href="/modifierRecette?recetteId=<?= (int)$recette->recetteId ?>" class="btn btn-warning">Modifier</a>
                    <a href="/supprimerRecette?recetteId=<?= (int)$recette->recetteId ?>" class="btn btn-danger" 
                       onclick="return confirm('Voulez-vous vraiment supprimer cette recette ?');">
                        Supprimer
                    </a>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>