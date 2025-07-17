<?php
session_start();
require_once '../config.php';

// Vérification de l'accès admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Vérification de l'ID passé dans l'URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: services.php');
    exit;
}

// Supprimer le service
$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

// Redirection après suppression
header('Location: services.php');
exit;
