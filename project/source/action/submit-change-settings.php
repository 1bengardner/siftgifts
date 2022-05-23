<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';
require_once '../data/user.php';

$old_name = User::get_from_id($_SESSION['id'])->username;
$is_changing_name = strtolower($old_name) != strtolower($_POST['name']);

$is_changing_password = !empty($_POST['password']) || !empty($_POST['confirm-password']);

// Validate required field presence
$required_fields = [];
$validation_errors = [];
$validations = [
  function() use (&$required_fields) { return Validation::keys_missing($required_fields); },
];

if ($is_changing_name) {
  array_push($required_fields, ...['name']);
  array_push($validations, ...[
    function() { return Validation::name_error($_POST['name']); },
  ]);
}

if ($is_changing_password) {
  array_push($required_fields, ...['password', 'confirm-password']);
  array_push($validations, ...[
    function() { return Validation::passwords_differ($_POST['password'], $_POST['confirm-password']); },
    function() { return Validation::password_error($_POST['password']); },
  ]);
}

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, NotificationLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  header('Location: /settings');
  exit;
}

$stmt = "CALL update_profile(?, ?, ?, ?, ?)";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$_SESSION['id'], $_POST['name'], $is_changing_password ? password_hash($_POST['password'], PASSWORD_DEFAULT) : NULL, isset($_POST['visible-in-directory']), isset($_POST['subscribe-to-message-alerts'])]);

if ($is_changing_name) {
  rename('../wishlist/'.strtolower($old_name).'.php', '../wishlist/'.strtolower($_POST['name']).'.php');
}

$_SESSION["notifications"] = [new Notification(NotificationText::ChangeProfileSuccess, NotificationLevel::Success)];

header('Location: /settings');
?>