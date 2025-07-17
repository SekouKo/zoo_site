<?php
session_start();
require_once '../../config.php';

// ✅ Sécurité : réservé à l’admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../connexion.php');
    exit;
}

// Vérifie que l'id est passé
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: liste.php');
    exit;
}

$message = '';

// Récupère l’utilisateur
$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
    $message = "Utilisateur introuvable.";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';

    if ($email === '' || !in_array($role, ['employe', 'veterinaire', 'admin'])) {
        $message = 'Champs invalides.';
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET email = ?, role = ? WHERE id = ?");
        $stmt->execute([$email, $role, $id]);
        $message = "Utilisateur mis à jour.";
        // Refresh les données
        $utilisateur['email'] = $email;
        $utilisateur['role'] = $role;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Modifier un utilisateur</h1>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($utilisateur): ?>
    <form method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($utilisateur['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rôle :</label>
            <select name="role" id="role" class="form-select" required>
                <option value="employe" <?= $utilisateur['role'] === 'employe' ? 'selected' : '' ?>>Employé</option>
                <option value="veterinaire" <?= $utilisateur['role'] === 'veterinaire' ? 'selected' : '' ?>>Vétérinaire</option>
                <option value="admin" <?= $utilisateur['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
    <?php endif; ?>
</body>
</html>
