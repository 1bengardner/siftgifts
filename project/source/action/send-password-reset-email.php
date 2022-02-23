<?php
require_once '../data/user.php';
require_once '../util/utilities.php';

$email = $_POST['email'];

if ($msg = Validation::forgot_password_error($email)) {
  return $msg;
}

// Delete code if one exists
$stmt = "SELECT code FROM reset_code WHERE email=?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
$reset_code = $res->fetch_row()[0];
if (!empty($reset_code)) {
  $stmt = "CALL remove_reset_code(?)";
  $res = Database::run_statement(Database::get_connection(), $stmt, [$email]);  
}

// Save new code
$reset_code = bin2hex(random_bytes(8));
$stmt = "CALL add_reset_code(?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$email, $reset_code]);
$reset_link = 'https://sift.gifts/page/reset-password?email='.$email.'&code='.$reset_code;

$name = User::get_from_id($email)->name;
$to = $name;

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

// To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';

// Additional headers
$headers[] = 'To: '.$name.' <'.$email.'>';
$headers[] = 'From: Sift.gifts <password-reset@sift.gifts>';

// Mail it
mail($to, $subject, $message, implode("\r\n", $headers));
?>