<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';
require_once '../data/user.php';

$user = User::get_from_id($_SESSION['id']);
if (!in_array($user->id, [2])) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}

$db = Database::get_connection();
$stmt = "CALL get_pending_lotteries()";
$res = Database::run_statement_no_params($db, $stmt)->fetch_all(MYSQLI_NUM);
if (!$res) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoLotteries, NotificationLevel::Error)];
  header('Location: /lottery-admin');
  exit;
}
foreach ($res as $row) {
  $id = $row[0];
  $chosen_numbers = include 'return-lottery-numbers.php';
  $stmt = "UPDATE winning_ticket SET `1`=?, `2`=?, `3`=?, `4`=?, `5`=?, `6`=?, `7`=? WHERE id=?";
  Database::run_statement($db, $stmt, array_merge($chosen_numbers, [$id]));
}

$_SESSION["notifications"] = [new Notification(NotificationText::RegenerateLotterySuccess, NotificationLevel::Success)];

header('Location: /lottery-admin');
?>