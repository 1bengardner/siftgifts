<?php
header('Content-Type: application/json');
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

if (!$_POST['fund'] || !$_POST['source'] || !is_numeric($_POST['amount'])) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = "INSERT INTO fund_contribution (fund_id, source, amount, user) VALUES (?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['fund'], $_POST['source'], $_POST['amount'], $_SESSION['id']]);

echo json_encode([
    'success' => true,
    'contribution' => [
        'source' => $_POST['source'],
        'amount' => number_format($_POST['amount'], 2)
    ]
]);
?>
