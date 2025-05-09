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
$stmt = "UPDATE prize SET `1`=?, `2`=?, `3`=?, `4`=?, `5`=?, `6`=?, `7`=? WHERE id=?";
Database::run_statement($db, $stmt, [$_POST['1'], $_POST['2'], $_POST['3'], $_POST['4'], $_POST['5'], $_POST['6'], $_POST['7'], 1]);

header('Location: /lottery-admin');
?>