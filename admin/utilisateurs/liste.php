<?php
session_start();
require_once '../../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../connexion.php');
    exit;
}

$users = $pdo->query("SELECT * FROM utilisateurs ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Liste des utilisateurs</h1>

    <a href="ajouter.php" class="btn btn-success mb-3">Ajouter un utilisateur</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= $u['role'] ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $u['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="supprimer.php?id=<?= $u['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce compte ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
