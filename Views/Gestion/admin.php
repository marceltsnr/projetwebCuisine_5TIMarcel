<div class="admin-container">

    <!-- En-tête -->
    <div class="admin-header">
        <h1>Administration</h1>
        <div class="user-info">
            <span>Connecté en tant que : <strong><?= $_SESSION["user"]->prenomUser ?> <?= $_SESSION["user"]->nomUser ?></strong> (Admin)</span>
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
                            <?php if ($user->id != $_SESSION["user"]->id): ?>
                                <?php if ($data['estSuspendu']): ?>
                                    <a href="?action=reactiver&id=<?= $user->id ?>" class="btn-reactiv">Réactiver</a>
                                <?php else: ?>
                                    <a href="?action=suspendre&id=<?= $user->id ?>" class="btn-suspend">Suspendre</a>
                                <?php endif; ?>

                                <?php if ($user->role === 'moderateur'): ?>
                                    <a href="?action=retrograder&id=<?= $user->id ?>" class="btn-retrograder">Rétrograder</a>
                                <?php elseif ($user->role === 'user'): ?>
                                    <a href="?action=promouvoir&id=<?= $user->id ?>" class="btn-promouvoir">Modérateur</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">(Vous)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Infos utiles -->
    <div class="info-box">
        <h3>ℹ️ Information</h3>
        <p>Les comptes suspendus ne peuvent plus se connecter à l'application.</p>
    </div>

</div>

<style>
    /* Style général */
    .admin-container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    /* En-tête */
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-radius: 5px;
        margin-bottom: 30px;
        border: 1px solid #dee2e6;
    }

    .admin-header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-deconnexion {
        background-color: #dc3545;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-deconnexion:hover {
        background-color: #c82333;
    }

    /* Messages d'alerte */
    .alert {
        padding: 12px 20px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    /* Section utilisateurs */
    .users-section {
        background-color: white;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        padding: 20px;
        margin-bottom: 20px;
    }

    .users-section h2 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 20px;
        color: #333;
    }

    /* Tableau */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .user-table th {
        background-color: #343a40;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: normal;
    }

    .user-table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .user-table tr:hover {
        background-color: #f8f9fa;
    }

    .user-table tr.suspendu {
        background-color: #fff3f3;
        color: #666;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: normal;
    }

    .badge-admin {
        background-color: #dc3545;
        color: white;
    }

    .badge-user {
        background-color: #28a745;
        color: white;
    }

    .badge-suspendu {
        background-color: #6c757d;
        color: white;
    }

    .badge-actif {
        background-color: #28a745;
        color: white;
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-suspend {
        background-color: #ffc107;
        color: #212529;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
        border: none;
        cursor: pointer;
    }

    .btn-suspend:hover {
        background-color: #e0a800;
    }

    .btn-reactiv {
        background-color: #28a745;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
        border: none;
        cursor: pointer;
    }

    .btn-reactiv:hover {
        background-color: #218838;
    }

    .text-muted {
        color: #999;
        font-style: italic;
        font-size: 12px;
    }

    /* Info box */
    .info-box {
        background-color: #e7f3ff;
        border: 1px solid #b8daff;
        border-radius: 4px;
        padding: 15px 20px;
    }

    .info-box h3 {
        margin: 0 0 10px 0;
        font-size: 16px;
        color: #004085;
    }

    .info-box p {
        margin: 0;
        color: #004085;
        font-size: 14px;
    }

    .btn-promouvoir {
        background-color: #17a2b8;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
    }

    .btn-promouvoir:hover {
        background-color: #138496;
    }

    .btn-retrograder {
        background-color: #6c757d;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 3px;
        font-size: 12px;
    }

    .btn-retrograder:hover {
        background-color: #5a6268;
    }

    .badge-moderateur {
        background-color: #17a2b8;
        color: white;
    }
</style>