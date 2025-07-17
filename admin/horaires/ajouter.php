<?php
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour = $_POST['jour'];
    $heure_ouverture = $_POST['heure_ouverture'];
    $heure_fermeture = $_POST['heure_fermeture'];

    $stmt = $pdo->prepare("INSERT INTO horaires (jour, heure_ouverture, heure_fermeture) VALUES (?, ?, ?)");
    $stmt->execute([$jour, $heure_ouverture, $heure_fermeture]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un horaire</title>
</head>
<body>
    <h1>Ajouter un horaire</h1>
    <form method="POST">
        <label>Jour : <input type="text" name="jour" required></label><br>
        <label>Heure d'ouverture : <input type="time" name="heure_ouverture" required></label><br>
        <label>Heure de fermeture : <input type="time" name="heure_fermeture" required></label><br>
        <button type="submit">Ajouter</button>
    </form>
    <a href="index.php">Retour</a>
</body>
</html>
