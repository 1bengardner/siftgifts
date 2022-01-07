<?php
require_once '../util/utilities.php';
session_start();

// Validate required field presence
$required_fields = ['password', 'confirm-password'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::passwords_differ($_POST['password'], $_POST['confirm-password']); },
  function() { return Validation::password_error($_POST['password']); },
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, $msg);
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["messages"] = $validation_errors;
  header('Location: ../page/change-password');
  exit;
}

$stmt = "UPDATE user SET encrypted_password = ? WHERE id = ?";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [password_hash($_POST['password'], PASSWORD_DEFAULT), $_SESSION['id']]);

$_SESSION["messages"] = [Message::ChangePasswordSuccess];

header('Location: ../page/dashboard');
?>