<?php
session_start();
require_once '../config.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Récupérer l’ID du service à modifier
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: services.php');
    exit;
}

// Récupération du service existant
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (!$service) {
    echo "Service introuvable.";
    exit;
}

$message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!empty($nom) && !empty($description)) {
        $update = $pdo->prepare("UPDATE services SET nom = ?, description = ? WHERE id = ?");
        if ($update->execute([$nom, $description, $id])) {
            header('Location: services.php');
            exit;
        } else {
            $message = "Erreur lors de la mise à jour.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un service</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Modifier le service</h1>

    <?php if ($message): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nom du service :</label><br>
        <input type="text" name="nom" value="<?= htmlspecialchars($service['nom']) ?>" required><br><br>

        <label>Description :</label><br>
        <textarea name="description" rows="4" required><?= htmlspecialchars($service['description']) ?></textarea><br><br>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <p><a href="services.php">← Retour à la liste des services</a></p>
</body>
</html>
