<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT was_drawn(?)";
if (Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_row()[0]) {
  exit;
}

$db = Database::get_connection();

$stmt = "DELETE FROM lottery_ticket WHERE id=?";
Database::run_statement($db, $stmt, [$_SESSION['id']]);

$stmt = "SELECT next_draw_id()";
$next_draw = Database::run_statement_no_params($db, $stmt)->fetch_row()[0];

$possible_numbers = range(1, 50);
$chosen_numbers = array();
for ($i = 1; $i <= 7; $i++) {
  $chosen_numbers[] = array_splice($possible_numbers, rand(0, count($possible_numbers)-1), 1)[0];
}
$stmt = "INSERT INTO lottery_ticket(`id`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `draw`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
Database::run_statement($db, $stmt, array_merge([$_SESSION['id']], $chosen_numbers, [$next_draw]));
echo json_encode(include 'get-lottery-ticket.php');
?>