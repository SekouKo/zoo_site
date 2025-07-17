<?php
require_once '../../config.php';
session_start();

if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../login.php');
    exit;
}

$conn = new PDO($dsn, $username, $password, $options);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// Récupérer le commentaire
$stmt = $conn->prepare("SELECT * FROM commentaires_habitats WHERE id = ?");
$stmt->execute([$id]);
$commentaire = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$commentaire) {
    header('Location: index.php');
    exit;
}

// Liste des habitats
$stmt = $conn->query("SELECT id, nom FROM habitats ORDER BY nom");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitat_id = $_POST['habitat_id'] ?? null;
    $comment_text = trim($_POST['commentaire'] ?? '');

    if (!$habitat_id) {
        $errors[] = "Veuillez choisir un habitat.";
    }
    if (empty($comment_text)) {
        $errors[] = "Le commentaire ne peut pas être vide.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE commentaires_habitats SET habitat_id = ?, commentaire = ? WHERE id = ?");
        $stmt->execute([$habitat_id, $comment_text, $id]);
        header('Location: index.php');
        exit;
    }
} else {
    $habitat_id = $commentaire['habitat_id'];
    $comment_text = $commentaire['commentaire'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un commentaire</title>
</head>
<body>
    <h1>Modifier un commentaire sur un habitat</h1>
    <?php if ($errors): ?>
        <ul style="color:red;">
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post">
        <label for="habitat_id">Habitat :</label>
        <select name="habitat_id" id="habitat_id" required>
            <option value="">-- Choisir un habitat --</option>
            <?php foreach ($habitats as $h): ?>
                <option value="<?= $h['id'] ?>" <?= ($habitat_id == $h['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($h['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="commentaire">Commentaire :</label><br>
        <textarea name="commentaire" id="commentaire" rows="5" cols="50" required><?= htmlspecialchars($comment_text) ?></textarea><br><br>

        <button type="submit">Modifier</button>
    </form>
    <a href="index.php">Retour à la liste</a>
</body>
</html>
