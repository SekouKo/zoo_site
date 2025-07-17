<?php
require_once '../../../includes/db.php';

if (isset($_GET['id']) && isset($_GET['etat'])) {
    $id = (int) $_GET['id'];
    $etat = $_GET['etat'] == 1 ? 1 : 0;

    $stmt = $db->prepare("UPDATE avis SET valide = :etat WHERE id = :id");
    $stmt->execute(['etat' => $etat, 'id' => $id]);
}

header('Location: index.php');
exit;
