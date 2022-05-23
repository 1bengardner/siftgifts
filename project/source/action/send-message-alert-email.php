<?php
require_once '../data/user.php';
require_once '../data/user-message.php';
require_once '../util/utilities.php';
require_once 'start-session.php';

if (!isset($_SESSION['last_message_to'])) {
  throw new Exception('No email recipient set');
}
$to = $_SESSION['last_message_to'];
unset($_SESSION['last_message_to']);
session_write_close();  // unblock subsequent requests

$recipient = User::get_from_id($to);

if (!$recipient->subscribed) {
  trigger_error('Recipient has declined receiving message emails');
  exit;
}
$stmt = "SELECT is_ready_for_message_email(?)";
if (!Database::run_statement(Database::get_connection(), $stmt, [$to])->fetch_row()[0]) {
  trigger_error('Recipient received an email too recently');
  exit;
}

$stmt = "CALL add_message_email(?)";
Database::run_statement(Database::get_connection(), $stmt, [$to]);

set_time_limit(300);
// Accumulate new messages and give user a chance to read them before sending email
sleep(60);

$email = $recipient->email;

$conversations = [];
$stmt = "SELECT * FROM message WHERE `to`=? AND unread=TRUE AND TIMESTAMPDIFF(DAY, sent_time, CURRENT_TIMESTAMP) < 1 ORDER BY `from`, sent_time";
$unread_for_email = Database::run_statement(Database::get_connection(), $stmt, [$to])->fetch_all(MYSQLI_ASSOC);
$last_from = null;
foreach ($unread_for_email as $message) {
  $msg = new UserMessage($message);
  if ($last_from != $msg->from || $msg->from == null) {
    $last_from = $msg->from;
    unset($cur_conversation);
    $cur_conversation = [];
    $conversations[] =& $cur_conversation;
  }
  $cur_conversation[] = $msg;
}
if (empty($conversations)) {
  exit;
}

$subject = 'Sift.gifts - New messages!';

$name = ucwords(strtolower(User::get_from_email($email)->username));

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts</h1>
  <p>You have new messages. Log in to https://sift.gifts to reply.</p>';
foreach ($conversations as $conversation) {
  $message .= '
  <div>
    <strong>'.htmlentities($conversation[0]->from ? ucwords(strtolower(User::get_from_id($conversation[0]->from)->username)) : '[Guest] '.ucwords(strtolower($conversation[0]->guest_name))).'</strong>
  </div>
  <div>';
  foreach ($conversation as $msg) {
    $message .= '
    <p style="line-height: 50%;">'.date('g:i A', strtotime($msg->sent_time)).': '.nl2br(htmlentities($msg->body)).'</p>';
  }
  $message .= '
  </div>';
}
$message .= '
  <hr />
  <div>
    <p>🎁 Change your email preferences at https://sift.gifts/preferences</p>
  </div>
</body>
</html>
';

Email::send_email($name, $email, EmailAlias::Alerts, $subject, $message);
?>