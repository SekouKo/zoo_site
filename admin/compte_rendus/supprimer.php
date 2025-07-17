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

// Confirmation suppression (GET)
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $stmt = $pdo->prepare("DELETE FROM compte_rendus WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Supprimer un compte rendu</title>
</head>
<body>
<h1>Supprimer un compte rendu vétérinaire</h1>

<p>Êtes-vous sûr de vouloir supprimer ce compte rendu ?</p>
<p>
    <a href="?id=<?= $id ?>&confirm=yes">Oui, supprimer</a> | 
    <a href="index.php">Non, revenir à la liste</a>
</p>

</body>
</html>
