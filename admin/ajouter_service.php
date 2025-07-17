<?php
session_start();
require_once '../config.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

$message = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $description = $_POST['description'] ?? '';

    if (!empty($nom) && !empty($description)) {
        $stmt = $pdo->prepare("INSERT INTO services (nom, description) VALUES (?, ?)");
        if ($stmt->execute([$nom, $description])) {
            header('Location: services.php');
            exit;
        } else {
            $message = "Erreur lors de l'ajout du service.";
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
    <title>Ajouter un service - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Ajouter un nouveau service</h1>

    <?php if ($message): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nom">Nom du service :</label><br>
        <input type="text" id="nom" nom="nom" required><br><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <p><a href="services.php">← Retour à la liste des services</a></p>
</body>
</html>
