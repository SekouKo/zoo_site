<?php
session_start();
require_once '../config.php';
include_once 'includes/header.php';


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}
// Ajouter un service
if (isset($_POST['add_service'])) {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($name && $description) {
        $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
        header('Location: services.php');
        exit;
    }
}

// Modifier un service
if (isset($_POST['edit_service'])) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';

    if ($id && $name && $description) {
        $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
        header('Location: services.php');
        exit;
    }
}

// Supprimer un service
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: services.php');
    exit;
}

// Récupérer tous les services
$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll();

// Si modification, récupérer les données du service à modifier
$editService = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $editService = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1>Gestion des services</h1>

    <!-- Formulaire ajout ou modification -->
    <div class="mb-4">
        <h2><?= $editService ? "Modifier un service" : "Ajouter un service" ?></h2>
        <form method="POST" action="">
            <?php if ($editService): ?>
                <input type="hidden" name="id" value="<?= $editService['id'] ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="name" class="form-control" required value="<?= $editService['name'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required><?= $editService['description'] ?? '' ?></textarea>
            </div>
            <button type="submit" name="<?= $editService ? 'edit_service' : 'add_service' ?>" class="btn btn-primary">
                <?= $editService ? "Modifier" : "Ajouter" ?>
            </button>
            <?php if ($editService): ?>
                <a href="services.php" class="btn btn-secondary">Annuler</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Liste des services -->
    <h2>Liste des services</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
            <tr>
                <td><?= $service['id'] ?></td>
                <td><?= htmlspecialchars($service['name']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td>
                    <a href="?edit=<?= $service['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="?delete=<?= $service['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (count($services) === 0): ?>
                <tr><td colspan="4">Aucun service trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

