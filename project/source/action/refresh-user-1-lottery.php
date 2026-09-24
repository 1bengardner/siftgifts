<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

if (!include '../action/is-admin.php') {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}

$db = Database::get_connection();

$stmt = "INSERT INTO winning_ticket(`1`, `2`, `3`, `4`, `5`, `6`, `7`, `draw_time`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
Database::run_statement($db, $stmt, array_merge(include 'return-lottery-numbers.php', [$_POST["draw-time"]]));
$stmt = "DELETE FROM lottery_ticket WHERE id=?";
Database::run_statement($db, $stmt, [1]);
$stmt = "SELECT next_draw_id()";
$next_draw = Database::run_statement_no_params($db, $stmt)->fetch_row()[0];
$stmt = "INSERT INTO lottery_ticket(`id`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `draw`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
Database::run_statement($db, $stmt, array_merge([1], include 'return-lottery-numbers.php', [$next_draw]));
$_SESSION["notifications"] = [new Notification(NotificationText::User1TicketCreated, NotificationLevel::Success)];
header('Location: /lottery-admin');
?>