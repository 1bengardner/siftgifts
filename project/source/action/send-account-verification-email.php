<?php
require_once '../data/user.php';
require_once '../util/utilities.php';

$email = $_POST['email'];

// TODO: Only send email if time limit has been reached since last issue

// Deny if email not pending verification
$stmt = "SELECT verified FROM user WHERE email = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
if ($res->fetch_row()[0] === NULL) {
  return NotificationText::EmailDoesNotExist;
}

// Save verification code
$verification_code = bin2hex(random_bytes(16));
$stmt = "CALL add_verification_code(?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$email, $verification_code]);
$verification_link = 'https://sift.gifts/verify?email='.$email.'&code='.$verification_code;

$name = ucwords(strtolower(User::get_from_email($email)->username));

// Mail
$subject = 'Sift.gifts - Signup';

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts Registration</h1>
  <div>
    <p>Hello! I heard you signed up for Sift.gifts. That\'s great!</p>
    <p>Head over to this link to verify your account: '.$verification_link.'</p>
  </div>
</body>
</html>
';

// Mail it
Email::send_email($name, $email, EmailAlias::AccountVerification, $subject, $message);
?>