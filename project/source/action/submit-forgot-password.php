<?php
require_once '../util/utilities.php';
require_once 'start-session.php';

// Validate required field presence
$required_fields = ['email'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::forgot_password_error($_POST['email']); },
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, MessageLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  header('Location: /forgot-password');
  exit;
}

require 'send-password-reset-email.php';

$_SESSION["notifications"] = [new Notification(Message::PasswordResetSent, MessageLevel::Success)];

header('Location: /');
?>