<?php
require_once '../util/utilities.php';
require_once '../data/user.php';
require_once 'start-session.php';

$required_fields = ['to', 'message'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::to_error($_POST['to']); }
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, NotificationLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  include '../page/notification-box.php';
  exit;
}

$to_id = User::get_from_name($_POST['to'])->id;

$db = Database::get_connection();
if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
  $stmt = "INSERT INTO message(`to`, `from`, body, guest_name) VALUES (?, ?, ?, ?)";
  Database::run_statement($db, $stmt, [$to_id, null, $_POST['message'], $_POST['from'] ?: null]);
  $_SESSION["notifications"] = [new Notification(NotificationText::MessageSent, NotificationLevel::Success)];
  include '../page/notification-box.php';
} else {
  $stmt = "INSERT INTO message(`to`, `from`, body) VALUES (?, ?, ?)";
  Database::run_statement($db, $stmt, [$to_id, $_SESSION['id'], $_POST['message']]);
  $_SESSION["notifications"] = [new Notification(NotificationText::MessageSent, NotificationLevel::Success)];
}
?>