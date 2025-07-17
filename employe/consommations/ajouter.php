<?php
require_once '../../includes/db.php';
$animaux = $pdo->query("SELECT id, nom FROM animaux")->fetchAll();
?>

<h2>Ajouter une consommation de nourriture</h2>
<form action="ajouter_traitement.php" method="post">
    <label>Animal :</label>
    <select name="animal_id" required>
        <?php foreach ($animaux as $animal): ?>
            <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['nom']) ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Date :</label>
    <input type="date" name="date" required><br>

    <label>Heure :</label>
    <input type="time" name="heure" required><br>

    <label>Type de nourriture :</label>
    <input type="text" name="nourriture" required><br>

    <label>Quantité (kg) :</label>
    <input type="number" step="0.01" name="quantite" required><br>

    <button type="submit">Ajouter</button>
</form>
