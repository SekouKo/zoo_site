<?php
require_once '../../config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $espece = $_POST['espece'];
    $age = $_POST['age'];
    $habitat_id = $_POST['habitat_id'];

    $stmt = $conn->prepare("UPDATE animaux SET nom=?, espece=?, age=?, habitat_id=? WHERE id=?");
    $stmt->bind_param("ssiii", $nom, $espece, $age, $habitat_id, $id);
    $stmt->execute();

    header("Location: index.php");
    exit();
} else {
    $stmt = $conn->prepare("SELECT * FROM animaux WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $animal = $stmt->get_result()->fetch_assoc();
}
?>

<h2>Modifier un animal</h2>
<form method="POST">
    <input type="text" name="nom" value="<?= $animal['nom'] ?>" required><br>
    <input type="text" name="espece" value="<?= $animal['espece'] ?>" required><br>
    <input type="number" name="age" value="<?= $animal['age'] ?>" required><br>
    <input type="number" name="habitat_id" value="<?= $animal['habitat_id'] ?>" required><br>
    <button type="submit">Modifier</button>
</form>
