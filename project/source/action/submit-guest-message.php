<?php
require_once '../util/utilities.php';
require_once '../data/user.php';
require_once 'start-session.php';

// TODO: Validate
$to_id = User::get_from_name($_POST['to'])->id;

$db = Database::get_connection();
if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
  $stmt = "INSERT INTO message(`to`, `from`, body, guest_name) VALUES (?, ?, ?, ?)";
  Database::run_statement($db, $stmt, [$to_id, null, $_POST['message'], $_POST['from'] ?: null]);
} else {
  $stmt = "INSERT INTO message(`to`, `from`, body) VALUES (?, ?, ?)";
  Database::run_statement($db, $stmt, [$to_id, $_SESSION['id'], $_POST['message']]);
  $_SESSION["notifications"] = [new Notification(NotificationText::MessageSent, NotificationLevel::Success)];
  header("HTTP/1.1 200 OK");
  echo 1;
}
?>