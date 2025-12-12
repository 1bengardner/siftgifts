<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT was_drawn(?)";
if (Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_row()[0]) {
  exit;
}

$db = Database::get_connection();

$stmt = "SELECT draw FROM lottery_ticket WHERE id=?";
$next_draw = Database::run_statement($db, $stmt, [$_SESSION['id']])->fetch_row()[0];
$stmt = "DELETE FROM lottery_ticket WHERE id=?";
Database::run_statement($db, $stmt, [$_SESSION['id']]);
if ($next_draw === NULL) {
  $stmt = "SELECT next_draw_id()";
  $next_draw = Database::run_statement_no_params($db, $stmt)->fetch_row()[0];
}
if ($next_draw === NULL || !in_array($_SESSION['id'], [1, 2])) {
  return ["?", "?", "?", "?", "?", "?", "?"];
}
$chosen_numbers = include 'return-lottery-numbers.php';
$stmt = "INSERT INTO lottery_ticket(`id`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `draw`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
Database::run_statement($db, $stmt, array_merge([$_SESSION['id']], $chosen_numbers, [$next_draw]));
echo json_encode(include 'get-lottery-ticket.php');
return include 'get-lottery-ticket.php';
?>