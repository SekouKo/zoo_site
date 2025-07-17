<?php
require_once '../../../includes/db.php';

$avis = $db->query("SELECT * FROM avis ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Gestion des avis</h2>
<table border="1">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Contenu</th>
            <th>Date</th>
            <th>Valide</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($avis as $a) : ?>
        <tr>
            <td><?= htmlspecialchars($a['nom']) ?></td>
            <td><?= htmlspecialchars($a['contenu']) ?></td>
            <td><?= htmlspecialchars($a['date']) ?></td>
            <td><?= $a['valide'] ? 'Oui' : 'Non' ?></td>
            <td>
                <?php if ($a['valide']) : ?>
                    <a href="valider.php?id=<?= $a['id'] ?>&etat=0">❌ Invalider</a>
                <?php else : ?>
                    <a href="valider.php?id=<?= $a['id'] ?>&etat=1">✅ Valider</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
