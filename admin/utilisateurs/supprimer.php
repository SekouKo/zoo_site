<?php
session_start();
require_once '../../config.php';

// ✅ Sécurité : seulement admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../../connexion.php');
    exit;
}

// Vérifie que l’id est passé
$id = $_GET['id'] ?? null;
if ($id) {
    // Ne pas supprimer l’admin principal (optionnel)
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: liste.php');
exit;
