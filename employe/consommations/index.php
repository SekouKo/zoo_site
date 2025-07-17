<?php
require_once '../../includes/db.php';

$stmt = $pdo->query("SELECT c.*, a.nom AS nom_animal FROM consommations c
                     JOIN animaux a ON c.animal_id = a.id
                     ORDER BY c.date_consommation DESC, c.heure_consommation DESC");
$consommations = $stmt->fetchAll();
?>

<h2>Historique des consommations</h2>
<a href="ajouter.php">➕ Ajouter une consommation</a>
<table border="1" cellpadding="5">
    <tr>
        <th>Animal</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Nourriture</th>
        <th>Quantité</th>
    </tr>
    <?php foreach ($consommations as $conso): ?>
        <tr>
            <td><?= htmlspecialchars($conso['nom_animal']) ?></td>
            <td><?= $conso['date_consommation'] ?></td>
            <td><?= $conso['heure_consommation'] ?></td>
            <td><?= htmlspecialchars($conso['type_nourriture']) ?></td>
            <td><?= $conso['quantite'] ?> kg</td>
        </tr>
    <?php endforeach; ?>
</table>
