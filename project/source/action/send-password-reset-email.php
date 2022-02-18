<?php
require_once '../data/user.php';

$email = $_POST['email'];

// Delete code if one exists
$stmt = "SELECT code FROM reset_code WHERE email=?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$email]);
$reset_code = $res->fetch_row()[0];
if (!empty($reset_code)) {
  $stmt = "DELETE FROM reset_code WHERE email=?";
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
  <div style="display: inline-block;">
    <p>Hello! I heard you forgot your password. No sweat!</p>
    <p>Head over to this link to set a new password: '.$reset_link.'</p>
  </div>
  <div style="display: inline-block;">
    <svg xmlns="http://www.w3.org/2000/svg"  width="80" height="80" viewBox="0 0 160 160"><ellipse cx="704.139" cy="285.673" rx="21.534" ry="6.76" transform="matrix(0.924264, -0.381754, 0.381754, 0.924264, -727.578308, 78.978523)" fill="#361f5c"/>
    <ellipse cx="798.455" cy="305.135" rx="6.76" ry="21.534" transform="matrix(0.766735, -0.641963, 0.641963, 0.766735, -681.484741, 372.290222)" fill="#361f5c"/>
    <circle cx="80.797" cy="86.191" r="43.067" fill="#361f5c"/>
    <rect x="85.942" y="119.991" width="13.084" height="23.442" fill="#361f5c"/>
    <rect x="59.775" y="119.991" width="13.084" height="23.442" fill="#361f5c"/>
    <ellipse cx="88.123" cy="143.705" rx="10.903" ry="4.089" fill="#361f5c"/>
    <ellipse cx="61.955" cy="143.16" rx="10.903" ry="4.089" fill="#361f5c"/>
    <path d="M 67.274 32.054 C 71.12 16.567 88.095 7.454 105.189 11.698 C 122.283 15.943 133.023 31.939 129.178 47.426 C 125.332 62.913 112.574 62.963 95.48 58.718 C 78.386 54.473 63.429 47.541 67.274 32.054 Z" fill="#b7b6e1"/>
    <circle cx="74.359" cy="77.104" r="14.359" fill="#fff"/>
    <circle cx="68.457" cy="78.957" r="4.786" fill="#28225A"/>
    <path d="M 83.366 107.019 C 84.686 114.269 77.663 120.229 70.724 117.747 C 67.504 116.595 65.143 113.813 64.531 110.448 L 64.531 110.448 L 64.527 110.429 C 63.586 105.227 67.608 103.386 72.81 102.445 C 78.012 101.503 82.424 101.817 83.366 107.019 Z" fill="#fff"/></svg>
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