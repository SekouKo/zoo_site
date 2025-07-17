<?php
require_once '../../includes/db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM habitats WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header('Location: index.php');
exit;
