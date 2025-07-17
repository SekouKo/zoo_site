<?php
session_start();
require_once '../../config/database.php'; // adapte le chemin selon ta structure

// Vérifier que l'utilisateur est vétérinaire
if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../index.php');
    exit;
}

// Récupérer les animaux pour le filtre
$query = $pdo->query("SELECT id, nom FROM animaux ORDER BY nom");
$animaux = $query->fetchAll(PDO::FETCH_ASSOC);

$animal_id = $_GET['animal_id'] ?? null;

// Récupérer les consommations filtrées par animal si demandé
if ($animal_id) {
    $stmt = $pdo->prepare("SELECT c.date_consommation, c.heure_consommation, c.nourriture, c.quantite 
                           FROM consommations c
                           WHERE c.animal_id = ?
                           ORDER BY c.date_consommation DESC, c.heure_consommation DESC");
    $stmt->execute([$animal_id]);
    $consommations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $consommations = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consommations des animaux - Vétérinaire</title>
</head>
<body>
    <h1>Consommations par animal</h1>
    <form method="get">
        <label for="animal_id">Choisir un animal :</label>
        <select name="animal_id" id="animal_id" required>
            <option value="">-- Choisir un animal --</option>
            <?php foreach ($animaux as $animal): ?>
                <option value="<?= htmlspecialchars($animal['id']) ?>" <?= ($animal_id == $animal['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($animal['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Voir consommations</button>
    </form>

    <?php if ($animal_id && count($consommations) > 0): ?>
        <h2>Consommations pour <?= htmlspecialchars($animaux[array_search($animal_id, array_column($animaux, 'id'))]['nom']) ?></h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Nourriture</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consommations as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['date_consommation']) ?></td>
                        <td><?= htmlspecialchars($c['heure_consommation']) ?></td>
                        <td><?= htmlspecialchars($c['nourriture']) ?></td>
                        <td><?= htmlspecialchars($c['quantite']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($animal_id): ?>
        <p>Aucune consommation trouvée pour cet animal.</p>
    <?php endif; ?>
</body>
</html>
