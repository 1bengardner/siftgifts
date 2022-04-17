<?php
require_once '../util/utilities.php';
require_once 'start-session.php';

// Validate required field presence
$required_fields = ['email', 'code'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::invalid_verification_code($_POST['email'], $_POST['code']); },
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, NotificationLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  header('Location: /landing?email='.$_POST['email'].'&code='.$_POST['code']);
  exit;
}

$stmt = "UPDATE user SET verified = true WHERE email = ?";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$_POST['email']]);

$_SESSION["notifications"] = [new Notification(NotificationText::VerifyAccountSuccess, NotificationLevel::Success)];

header('Location: /login');
?>