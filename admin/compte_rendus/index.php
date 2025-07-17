<?php
session_start();

// Vérifier que l'utilisateur est admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../login.php'); // ou une autre page
    exit();
}

// Connexion à la base
require '../../config/database.php';

// Récupérer les filtres
$animalFilter = $_GET['animal'] ?? '';
$dateFilter = $_GET['date'] ?? '';

// Préparer la requête SQL avec filtres
$sql = "SELECT cr.id, cr.date, cr.description, a.nom AS animal_nom
        FROM compte_rendus cr
        JOIN animaux a ON cr.animal_id = a.id
        WHERE 1=1";

$params = [];

if ($animalFilter !== '') {
    $sql .= " AND a.nom LIKE :animal";
    $params[':animal'] = "%$animalFilter%";
}

if ($dateFilter !== '') {
    $sql .= " AND cr.date = :date";
    $params[':date'] = $dateFilter;
}

$sql .= " ORDER BY cr.date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$compteRendus = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Comptes rendus vétérinaires</title>
</head>
<body>
<h1>Comptes rendus vétérinaires</h1>

<form method="get" action="">
    <label>Filtrer par animal :
        <input type="text" name="animal" value="<?= htmlspecialchars($animalFilter) ?>" />
    </label>
    <label>Filtrer par date :
        <input type="date" name="date" value="<?= htmlspecialchars($dateFilter) ?>" />
    </label>
    <button type="submit">Filtrer</button>
    <a href="index.php">Réinitialiser</a>
</form>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Date</th>
            <th>Animal</th>
            <th>Description</th>
            <th>Détails</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($compteRendus) === 0): ?>
            <tr><td colspan="4">Aucun compte rendu trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($compteRendus as $cr): ?>
                <tr>
                    <td><?= htmlspecialchars($cr['date']) ?></td>
                    <td><?= htmlspecialchars($cr['animal_nom']) ?></td>
                    <td><?= nl2br(htmlspecialchars(substr($cr['description'], 0, 100))) ?>...</td>
                    <td><a href="detail.php?id=<?= $cr['id'] ?>">Voir</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
