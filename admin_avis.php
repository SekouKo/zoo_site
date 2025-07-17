<?php
require_once 'config.php';

// Traitement des actions
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int) $_GET['id'];

    if ($_GET['action'] === 'valider') {
        $pdo->prepare("UPDATE avis SET valide = 1 WHERE id = ?")->execute([$id]);
    } elseif ($_GET['action'] === 'supprimer') {
        $pdo->prepare("DELETE FROM avis WHERE id = ?")->execute([$id]);
    }

    header("Location: admin_avis.php");
    exit;
}

// Récupération de tous les avis
$avis = $pdo->query("SELECT * FROM avis ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des avis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h1>Gestion des avis visiteurs</h1>

    <?php if (empty($avis)) : ?>
        <p>Aucun avis n’a encore été soumis.</p>
    <?php else : ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Pseudo</th>
                    <th>Contenu</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avis as $a) : ?>
                    <tr>
                        <td><?= htmlspecialchars($a['pseudo']) ?></td>
                        <td><?= nl2br(htmlspecialchars($a['contenu'])) ?></td>
                        <td><?= htmlspecialchars($a['created_at']) ?></td>
                        <td><?= $a['valide'] ? '<span class="text-success">Validé</span>' : '<span class="text-danger">En attente</span>' ?></td>
                        <td>
                            <?php if (!$a['valide']) : ?>
                                <a href="admin_avis.php?action=valider&id=<?= $a['id'] ?>" class="btn btn-success btn-sm">Valider</a>
                            <?php endif; ?>
                            <a href="admin_avis.php?action=supprimer&id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet avis ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary mt-3">← Retour à l'accueil</a>
</body>
</html>

