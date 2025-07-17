<?php
require_once '../../config.php'; // adapte selon ta structure
session_start();

// Vérifier que l'utilisateur est bien vétérinaire
if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../login.php');
    exit;
}

$conn = new PDO($dsn, $username, $password, $options);

$stmt = $conn->prepare("SELECT ch.id, h.nom AS habitat, ch.commentaire, ch.date_commentaire 
                        FROM commentaires_habitats ch
                        JOIN habitats h ON ch.habitat_id = h.id
                        ORDER BY ch.date_commentaire DESC");
$stmt->execute();
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commentaires Habitats</title>
</head>
<body>
    <h1>Commentaires sur les habitats</h1>
    <a href="ajouter.php">Ajouter un commentaire</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Habitat</th>
                <th>Commentaire</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commentaires as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['habitat']) ?></td>
                    <td><?= nl2br(htmlspecialchars($c['commentaire'])) ?></td>
                    <td><?= htmlspecialchars($c['date_commentaire']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $c['id'] ?>">Modifier</a> | 
                        <a href="supprimer.php?id=<?= $c['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php">Retour à l'espace vétérinaire</a>
</body>
</html>
