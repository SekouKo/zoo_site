<?php
require_once '../../config.php';
session_start();

if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../login.php');
    exit;
}

$conn = new PDO($dsn, $username, $password, $options);

// Récupérer la liste des habitats pour le select
$stmt = $conn->query("SELECT id, nom FROM habitats ORDER BY nom");
$habitats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $habitat_id = $_POST['habitat_id'] ?? null;
    $commentaire = trim($_POST['commentaire'] ?? '');

    if (!$habitat_id) {
        $errors[] = "Veuillez choisir un habitat.";
    }
    if (empty($commentaire)) {
        $errors[] = "Le commentaire ne peut pas être vide.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO commentaires_habitats (habitat_id, commentaire, date_commentaire) VALUES (?, ?, NOW())");
        $stmt->execute([$habitat_id, $commentaire]);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un commentaire</title>
</head>
<body>
    <h1>Ajouter un commentaire sur un habitat</h1>
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
                <option value="<?= $h['id'] ?>" <?= (isset($habitat_id) && $habitat_id == $h['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($h['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="commentaire">Commentaire :</label><br>
        <textarea name="commentaire" id="commentaire" rows="5" cols="50" required><?= htmlspecialchars($_POST['commentaire'] ?? '') ?></textarea><br><br>

        <button type="submit">Ajouter</button>
    </form>
    <a href="index.php">Retour à la liste</a>
</body>
</html>
