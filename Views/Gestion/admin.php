<div class="admin-container">

    <!-- En-tête -->
    <div class="admin-header">
        <h1>Administration</h1>
        <div class="user-info">
            <span>Connecté en tant que : <strong><?= $_SESSION["utilisateur"]->prenomUser ?> <?= $_SESSION["utilisateur"]->nomUser ?></strong> (Admin)</span>
        </div>
    </div>

    <!-- Messages de notification -->
    <?php if (isset($message)): ?>
        <div class="alert alert-<?= $messageType ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <!-- Tableau des utilisateurs -->
    <div class="users-section">
        <h2>Gestion des utilisateurs</h2>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateursData as $data): ?>
                    <?php $user = $data['user']; ?>
                    <tr class="<?= $data['estSuspendu'] ? 'suspendu' : '' ?>">
                        <td><?= $user->id ?></td>
                        <td><?= htmlspecialchars($user->nomUser) ?></td>
                        <td><?= htmlspecialchars($user->prenomUser) ?></td>
                        <td><?= htmlspecialchars($user->loginUser) ?></td>
                        <td><?= htmlspecialchars($user->emailUser) ?></td>
                        <td>
                            <?php if ($user->role === 'admin'): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php elseif ($user->role === 'moderateur'): ?>
                                <span class="badge badge-moderateur">Modérateur</span>
                            <?php else: ?>
                                <span class="badge badge-user">Utilisateur</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($data['estSuspendu']): ?>
                                <span class="badge badge-suspendu">Suspendu</span>
                            <?php else: ?>
                                <span class="badge badge-actif">Actif</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <?php if ($user->id != $_SESSION["utilisateur"]->id): ?>
                                <?php if ($data['estSuspendu']): ?>
                                    <a href="?action=reactiver&id=<?= $user->id ?>" class="btn-reactiv">
                                        <img class="btn-img" src="../../Assets/Images/activate.png" alt="Activate">
                                    </a>
                                <?php else: ?>
                                    <a href="?action=suspendre&id=<?= $user->id ?>" class="btn-suspend">
                                        <img class="btn-img" src="../../Assets/Images/banned.png" alt="Banned">
                                    </a>
                                <?php endif; ?>

                                <?php if ($user->role === 'moderateur'): ?>
                                    <a href="?action=retrograder&id=<?= $user->id ?>" class="btn-retrograder">
                                        <img class="btn-img" src="../../Assets/Images/down.png" alt="Retrograder">
                                    </a>
                                <?php elseif ($user->role === 'user'): ?>
                                    <a href="?action=promouvoir&id=<?= $user->id ?>" class="btn-promouvoir">
                                        <img class="btn-img" src="../../Assets/Images/up.png" alt="Promouvoir">
                                    </a> <?php endif; ?>
                                <a href="/admVoirUser?id=<?= $user->id ?>" class="btn-promouvoir">
                                    <img class="btn-img" src="../../Assets/Images/oeil.png" alt="Voir">
                                </a>
                            <?php else: ?>
                                <span class="text-muted">(Vous)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>