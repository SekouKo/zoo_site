<?php
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO habitats (nom, description) VALUES (?, ?)");
    $stmt->execute([$nom, $description]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un habitat</title>
</head>
<body>
    <h1>Ajouter un habitat</h1>
    <form method="POST">
        <label>Nom : <input type="text" name="nom" required></label><br>
        <label>Description : <textarea name="description" required></textarea></label><br>
        <button type="submit">Ajouter</button>
    </form>
    <a href="index.php">Retour</a>
</body>
</html>
