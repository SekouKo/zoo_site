<?php
require_once '../../config.php';
include_once 'includes/header.php';


// Récupération des animaux avec jointure pour afficher le nom de l'habitat
$sql = "SELECT animaux.*, habitats.nom AS nom_habitat 
        FROM animaux 
        LEFT JOIN habitats ON animaux.habitat_id = habitats.id";
$result = $conn->query($sql);
?>

<h2>Liste des animaux</h2>

<a href="ajouter.php">➕ Ajouter un animal</a>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Espèce</th>
            <th>Âge</th>
            <th>Habitat</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($animal = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $animal['id'] ?></td>
                <td><?= htmlspecialchars($animal['nom']) ?></td>
                <td><?= htmlspecialchars($animal['espece']) ?></td>
                <td><?= $animal['age'] ?></td>
                <td><?= htmlspecialchars($animal['nom_habitat']) ?></td>
                <td>
                    <a href="modifier.php?id=<?= $animal['id'] ?>">✏️ Modifier</a> |
                    <a href="supprimer.php?id=<?= $animal['id'] ?>" onclick="return confirm('Supprimer cet animal ?')">🗑️ Supprimer</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
