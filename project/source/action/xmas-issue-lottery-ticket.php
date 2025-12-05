<?php
require_once '../action/xmas-authenticate.php';
require_once '../util/utilities.php';

$stmt = "SELECT xmas_was_drawn(?)";
if (Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['xmas']])->fetch_row()[0]) {
  exit;
}

$db = Database::get_connection();

$stmt = "DELETE FROM xmas_lottery_ticket WHERE code=?";
Database::run_statement($db, $stmt, [$_SESSION['xmas']]);

$stmt = "SELECT next_draw_id()";
$next_draw = Database::run_statement_no_params($db, $stmt)->fetch_row()[0];
if ($next_draw === NULL) {
  return ["?", "?", "?", "?", "?", "?", "?"];
}
$chosen_numbers = include 'return-lottery-numbers.php';
$stmt = "INSERT INTO xmas_lottery_ticket(`code`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `draw`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
Database::run_statement($db, $stmt, array_merge([$_SESSION['xmas']], $chosen_numbers, [$next_draw]));
echo json_encode(include 'xmas-get-lottery-ticket.php');
return include 'xmas-get-lottery-ticket.php';
?>