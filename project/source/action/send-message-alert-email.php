<?php
require_once '../data/user.php';
require_once '../util/utilities.php';
require_once 'start-session.php';

if (!isset($_SESSION['message_alert']) || !isset($_SESSION['message_alert']['email']) || !isset($_SESSION['message_alert']['conversations'])) {
  throw new Exception('Missing email or conversations.');
}

$email = $_SESSION['message_alert']['email'];
$conversations = $_SESSION['message_alert']['conversations'];
unset($_SESSION['message_alert']);

$subject = 'Sift.gifts - New messages!';

$name = ucwords(strtolower(User::get_from_email($email)->username));

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts messages</h1>';
foreach ($conversations as $conversation) {
  $message .= '
  <div>
    <strong>'.htmlentities(ucwords(strtolower(User::get_from_id($conversation[0]['from'])->username))).'</strong>
  </div>
  <div>';
  foreach ($conversation as $msg) {
    $message .= '
    <p>'.$msg['sent_time'].': '.htmlentities($msg['body']).'</p>';
  }
  $message .= '
  </div>';
}
$message .= '
  <hr />
  <div>
    <p>Log in to https://sift.gifts to reply.</p>
  </div>
</body>
</html>
';

Email::send_email($name, $email, EmailAlias::Alerts, $subject, $message);
?>