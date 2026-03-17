<div class="admin-container">

    <div class="admin-header">
        <h1>Modération</h1>
        <div class="user-info">
            <span>Connecté en tant que : <strong><?= $_SESSION["user"]->prenomUser ?> <?= $_SESSION["user"]->nomUser ?></strong> (Modérateur)</span>
        </div>
    </div>

    <div class="users-section">
        <h2>Comptes suspendus</h2>

        <?php $suspendusTrouves = false; ?>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Nb Recettes</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($utilisateursData as $data): ?>
                    <?php if ($data['estSuspendu']): ?>
                        <?php $suspendusTrouves = true; ?>
                        <?php $user = $data['user']; ?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= htmlspecialchars($user->nomUser) ?></td>
                            <td><?= htmlspecialchars($user->prenomUser) ?></td>
                            <td><?= htmlspecialchars($user->loginUser) ?></td>
                            <td><?= htmlspecialchars($user->emailUser) ?></td>
                            <td><?= $data['nbRecettes'] ?></td>
                            <td><span class="badge badge-suspendu">Suspendu</span></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!$suspendusTrouves): ?>
                    <tr>
                        <td colspan="7" style="text-align:center; color:#999;">Aucun compte suspendu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<style>
.admin-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    font-family: Arial, sans-serif;
}

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

.users-section {
    background-color: white;
    border-radius: 5px;
    border: 1px solid #dee2e6;
    padding: 20px;
}

.users-section h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 20px;
    color: #333;
}

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

.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 12px;
}

.badge-suspendu {
    background-color: #6c757d;
    color: white;
}
</style>