<?php
header('Content-Type: application/json');
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

$stmt = "SELECT source, amount FROM fund_contribution WHERE fund_id = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['fund']]);

echo json_encode($res->fetch_all(MYSQLI_ASSOC));
?>