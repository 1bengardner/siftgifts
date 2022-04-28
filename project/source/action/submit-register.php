<?php
require_once '../util/utilities.php';
require_once 'start-session.php';

// Validate required field presence
$required_fields = ['name', 'email', 'password', 'confirm-password'];
$validation_errors = [];
$validations = [
  function() use ($required_fields) { return Validation::keys_missing($required_fields); },
  function() { return Validation::name_error($_POST['name']); },
  function() { return Validation::email_registration_error($_POST['email']); },
  function() { return Validation::passwords_differ($_POST['password'], $_POST['confirm-password']); },
  function() { return Validation::password_error($_POST['password']); },
];

foreach ($validations as $validation) {
  if ($msg = $validation()) {
    array_push($validation_errors, new Notification($msg, NotificationLevel::Error));
  }
}

if (count($validation_errors) > 0) {
  $_SESSION["notifications"] = $validation_errors;
  header('Location: /register');
  exit;
}

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Add user to db
$stmt = "INSERT INTO user(username, email, encrypted_password) VALUES (?, ?, ?)";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$name, $email, $password]);

$from = '/wishlist-template.php';
$to = '/wishlist/'.strtolower($name).'.php';

$new_file = '<?php $user = "'.$name.'"; $id = '.$db->insert_id.'; include "'.$from.'"; ?>';
file_put_contents($to, $new_file);

$_SESSION["id"] = $db->insert_id;

require 'send-account-verification-email.php';
require 'send-user-alert-email.php';

$_SESSION["notifications"] = [new Notification(NotificationText::RegistrationSuccess, NotificationLevel::Success)];

header('Location: /home');
?>