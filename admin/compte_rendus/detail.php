<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php');
    exit();
}

require '../../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT cr.*, a.nom AS animal_nom FROM compte_rendus cr JOIN animaux a ON cr.animal_id = a.id WHERE cr.id = ?");
$stmt->execute([$id]);
$compteRendu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$compteRendu) {
    echo "Compte rendu non trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détail compte rendu</title>
</head>
<body>
<h1>Détail du compte rendu</h1>

<p><strong>Date :</strong> <?= htmlspecialchars($compteRendu['date']) ?></p>
<p><strong>Animal :</strong> <?= htmlspecialchars($compteRendu['animal_nom']) ?></p>
<p><strong>Description :</strong><br /> <?= nl2br(htmlspecialchars($compteRendu['description'])) ?></p>

<p><a href="index.php">Retour à la liste</a></p>
</body>
</html>
