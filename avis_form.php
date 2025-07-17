<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');

    if ($pseudo === '' || $contenu === '') {
        $message = 'Merci de remplir tous les champs.';
    } else {
        $stmt = $pdo->prepare("INSERT INTO avis (pseudo, contenu) VALUES (?, ?)");
        $stmt->execute([$pseudo, $contenu]);
        $message = 'Merci pour votre avis ! Il sera visible après validation.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Déposer un avis</title>
</head>
<body>
    <h1>Laisser un avis</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="pseudo">Pseudo :</label><br>
        <input type="text" id="pseudo" name="pseudo" maxlength="50" required><br><br>

        <label for="contenu">Votre avis :</label><br>
        <textarea id="contenu" name="contenu" rows="5" cols="40" required></textarea><br><br>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
