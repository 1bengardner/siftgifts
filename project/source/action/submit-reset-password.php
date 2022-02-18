<?php
require_once '../util/utilities.php';
require_once '../action/start-session.php';

// Validate required field presence
$required_fields = ['password', 'confirm-password', 'email', 'code'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::invalid_reset_code($_POST['email'], $_POST['code']); },
  function() { return Validation::passwords_differ($_POST['password'], $_POST['confirm-password']); },
  function() { return Validation::password_error($_POST['password']); },
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, MessageLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  header('Location: ../page/reset-password?email='.$_POST['email'].'&code='.$_POST['code']);
  exit;
}

$stmt = "UPDATE user SET encrypted_password = ? WHERE email = ?";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [password_hash($_POST['password'], PASSWORD_DEFAULT), $_POST['email']]);

$_SESSION["notifications"] = [new Notification(Message::ChangePasswordSuccess, MessageLevel::Success)];

header('Location: /page/login');
?>