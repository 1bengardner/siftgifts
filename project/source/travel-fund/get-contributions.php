<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=your_db;charset=utf8mb4", "user", "pass", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$fund_id = $_GET['fund_id'];

$stmt = $pdo->prepare("SELECT source, amount FROM contributions WHERE fund_id = ?");
$stmt->execute([$fund_id]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>