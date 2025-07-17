<?php
require_once '../../config.php';
session_start();

if ($_SESSION['role'] !== 'veterinaire') {
    header('Location: ../../login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $conn = new PDO($dsn, $username, $password, $options);
    $stmt = $conn->prepare("DELETE FROM commentaires_habitats WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php');
exit;
