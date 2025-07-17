<?php
// admin/horaires/index.php
require_once '../../includes/db.php'; // adapte le chemin si nécessaire

$req = $pdo->query("SELECT * FROM horaires ORDER BY FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Horaires</title>
</head>
<body>
    <h1>Horaires d'ouverture du zoo</h1>

    <a href="ajouter.php">➕ Ajouter un horaire</a>

    <table border="1" cellpadding="8">
        <tr>
            <th>Jour</th>
            <th>Ouverture</th>
            <th>Fermeture</th>
            <th>Actions</th>
        </tr>

        <?php while ($horaire = $req->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($horaire['jour']) ?></td>
                <td><?= htmlspecialchars($horaire['ouverture']) ?></td>
                <td><?= htmlspecialchars($horaire['fermeture']) ?></td>
                <td>
                    <a href="modifier.php?id=<?= $horaire['id'] ?>">✏️ Modifier</a>
                    <a href="supprimer.php?id=<?= $horaire['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">🗑️ Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
