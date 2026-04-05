<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=your_db;charset=utf8mb4", "user", "pass", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$fund_id = $_POST['fund_id'] ?? null;
$source = trim($_POST['source'] ?? '');
$amount = $_POST['amount'] ?? null;

if (!$fund_id || !$source || !is_numeric($amount)) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO contributions (fund_id, source, amount) VALUES (?, ?, ?)");
$stmt->execute([$fund_id, $source, $amount]);

echo json_encode([
    'success' => true,
    'contribution' => [
        'source' => $source,
        'amount' => number_format($amount, 2)
    ]
]);
?>
