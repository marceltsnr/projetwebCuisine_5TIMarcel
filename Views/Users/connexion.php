<!-- Page de connexion -->
<div class="flex space-evenly wrap">
    
    <?php if (isset($_GET['compte']) && $_GET['compte'] === 'suspendu'): ?>
        <div class="alert alert-danger">
            <strong>Compte suspendu !</strong> Votre compte a été suspendu. Vous ne pouvez plus vous connecter.
        </div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <strong>Erreur !</strong> <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="">
        <fieldset>
            <legend>Se connecter</legend>
            
            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" 
                       placeholder="Login" 
                       class="form-control" 
                       id="login" 
                       name="login" 
                       value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '' ?>" 
                       required>
            </div>
            
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" 
                       placeholder="Mot de passe" 
                       class="form-control" 
                       id="mot_de_passe" 
                       name="mot_de_passe" 
                       required>
            </div>
            
            <div>
                <button name="btnEnvoi" class="btn btn-primary">Se connecter</button>
            </div>
        </fieldset>
        
        <div class="mt-4">
            <h4 class="text-danger">Pas encore inscrit ?</h4>
            <a href="/inscription" class="btn btn-secondary">Créer un compte</a>
        </div>
    </form>
  
</div>

<!-- Ajout du CSS pour les alertes si tu ne l'as pas déjà -->
<style>
.alert {
    padding: 15px;
    border-radius: 4px;
    margin-bottom: 20px;
    width: 100%;
    max-width: 500px;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.mt-4 {
    margin-top: 20px;
}
</style>