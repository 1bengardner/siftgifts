// add_contribution.php

<?php
header('Content-Type: application/json');

$host = 'localhost';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Get POST data
$fund_id = $_POST['fund_id'] ?? null;
$source = trim($_POST['source'] ?? '');
$amount = $_POST['amount'] ?? null;

if (!$fund_id || !$source || !$amount || !is_numeric($amount)) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO contributions (fund_id, source, amount) VALUES (?, ?, ?)");
    $stmt->execute([$fund_id, $source, $amount]);

    $id = $pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'contribution' => [
            'id' => $id,
            'fund_id' => $fund_id,
            'source' => $source,
            'amount' => number_format($amount, 2),
            'created_at' => date('Y-m-d H:i:s')
        ]
    ]);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Failed to insert contribution']);
}
?>