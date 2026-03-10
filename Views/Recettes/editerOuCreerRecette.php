<div class="flex space-evenly wrap">
    <form method="post" action="">
        <fieldset>
            <legend><?= isset($recette) ? "Modifier la recette" : "Créer une recette" ?></legend>

            <!-- Titre -->
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control"
                <?php if(isset($recette)) : ?> value="<?= $recette->recetteTitre ?>" <?php endif ?>>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"><?php if(isset($recette)) echo $recette->recetteDescription; ?></textarea>
            </div>

            <!-- Ingrédients -->
            <div class="mb-3">
                <label class="form-label">Ingrédients</label>
                <textarea name="ingredients" class="form-control"><?php if(isset($recette)) echo $recette->recetteIngredients; ?></textarea>
            </div>

            <!-- Etapes -->
            <div class="mb-3">
                <label class="form-label">Etapes</label>
                <textarea name="etapes" class="form-control"><?php if(isset($recette)) echo $recette->recetteEtapes; ?></textarea>
            </div>

            <!-- Temps préparation -->
            <div class="mb-3">
                <label class="form-label">Temps préparation (min)</label>
                <input type="number" name="temps_preparation" class="form-control"
                <?php if(isset($recette)) : ?> value="<?= $recette->recetteTempsPreparation ?>" <?php endif ?>>
            </div>

            <!-- Difficulté -->
            <div class="mb-3">
                <label class="form-label">Difficulté</label>
                <select name="difficulte" class="form-control">
                    <option value="facile" <?= isset($recette) && $recette->recetteDifficulte == "facile" ? "selected" : "" ?>>Facile</option>
                    <option value="moyen" <?= isset($recette) && $recette->recetteDifficulte == "moyen" ? "selected" : "" ?>>Moyen</option>
                    <option value="difficile" <?= isset($recette) && $recette->recetteDifficulte == "difficile" ? "selected" : "" ?>>Difficile</option>
                </select>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image (url)</label>
                <input type="text" name="image" class="form-control"
                <?php if(isset($recette)) : ?> value="<?= $recette->recetteImage ?>" <?php endif ?>>
            </div>

            <!-- Catégorie -->
            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorieId" class="form-control">
                    <?php foreach($categories as $categorie) : ?>
                        <option value="<?= $categorie->categorieId ?>"
                        <?= isset($recette) && $recette->categorieId == $categorie->categorieId ? "selected" : "" ?>>
                            <?= $categorie->nom ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- Tags -->
            <div class="mb-3">
                <label class="form-label">Tags</label>
                <?php foreach($tags as $tag) : ?>
                    <div>
                        <input type="checkbox" name="tags[]" value="<?= $tag->tagId ?>"
                        <?php
                        if(isset($tagsActiveRecette)) {
                            foreach($tagsActiveRecette as $tagActive) {
                                if($tagActive->tagId == $tag->tagId) echo "checked";
                            }
                        }
                        ?>>
                        <?= $tag->nom ?>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- Bouton -->
            <div class="flex space-between mt-3">
                <button class="btn btn-primary" name="btnEnvoi">
                    <?= isset($recette) ? "Modifier" : "Créer" ?>
                </button>
            </div>

        </fieldset>
    </form>
</div>