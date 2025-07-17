<?php
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = $_POST['animal_id'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nourriture = $_POST['nourriture'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("INSERT INTO consommations (animal_id, date_consommation, heure_consommation, type_nourriture, quantite)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$animal_id, $date, $heure, $nourriture, $quantite]);

    header("Location: index.php");
    exit;
}
?>
