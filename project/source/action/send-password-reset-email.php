<?php
require_once '../data/user.php';
require_once '../util/utilities.php';

$email = $_POST['email'];

if ($msg = Validation::forgot_password_error($email)) {
  return $msg;
}

// Save reset code
$reset_code = bin2hex(random_bytes(8));
$stmt = "CALL add_reset_code(?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$email, $reset_code]);
$reset_link = 'https://sift.gifts/page/reset-password?email='.$email.'&code='.$reset_code;

$name = User::get_from_id($email)->username;

// Mail
$subject = 'Sift.gifts - Reset password';

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts Password Reset</h1>
  <div>
    <p>Hello! I heard you forgot your password. No sweat!</p>
    <p>Head over to this link to set a new password: '.$reset_link.'</p>
  </div>
</body>
</html>
';

// Mail it
Email::send_email($name, $email, EmailAlias::PasswordReset, $subject, $message);
?>