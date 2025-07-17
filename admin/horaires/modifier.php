<?php
require_once '../../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour = $_POST['jour'];
    $heure_ouverture = $_POST['heure_ouverture'];
    $heure_fermeture = $_POST['heure_fermeture'];

    $stmt = $pdo->prepare("UPDATE horaires SET jour = ?, heure_ouverture = ?, heure_fermeture = ? WHERE id = ?");
    $stmt->execute([$jour, $heure_ouverture, $heure_fermeture, $id]);

    header('Location: index.php');
    exit;
} else {
    $stmt = $pdo->prepare("SELECT * FROM horaires WHERE id = ?");
    $stmt->execute([$id]);
    $horaire = $stmt->fetch();
    if (!$horaire) {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un horaire</title>
</head>
<body>
    <h1>Modifier un horaire</h1>
    <form method="POST">
        <label>Jour : <input type="text" name="jour" value="<?= htmlspecialchars($horaire['jour']) ?>" required></label><br>
        <label>Heure d'ouverture : <input type="time" name="heure_ouverture" value="<?= $horaire['heure_ouverture'] ?>" required></label><br>
        <label>Heure de fermeture : <input type="time" name="heure_fermeture" value="<?= $horaire['heure_fermeture'] ?>" required></label><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="index.php">Retour</a>
</body>
</html>
