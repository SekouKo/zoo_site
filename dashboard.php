<?php
require_once 'mongo/get_stats.php';
$stats = getAnimalStats();
?>

<h1>📊 Statistiques de consultation des animaux</h1>

<ul>
    <?php foreach ($stats as $doc): ?>
        <li>
            <?= htmlspecialchars($doc['prenom']) ?> —
            <?= $doc['compteur'] ?> consultations
        </li>
    <?php endforeach; ?>
</ul>

