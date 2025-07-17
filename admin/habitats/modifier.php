<?php
require_once '../../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE habitats SET nom = ?, description = ? WHERE id = ?");
    $stmt->execute([$nom, $description, $id]);

    header('Location: index.php');
    exit;
} else {
    $stmt = $pdo->prepare("SELECT * FROM habitats WHERE id = ?");
    $stmt->execute([$id]);
    $habitat = $stmt->fetch();

    if (!$habitat) {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un habitat</title>
</head>
<body>
    <h1>Modifier un habitat</h1>
    <form method="POST">
        <label>Nom : <input type="text" name="nom" value="<?= htmlspecialchars($habitat['nom']) ?>" required></label><br>
        <label>Description : <textarea name="description" required><?= htmlspecialchars($habitat['description']) ?></textarea></label><br>
        <button type="submit">Modifier</button>
    </form>
    <a href="index.php">Retour</a>
</body>
</html>
