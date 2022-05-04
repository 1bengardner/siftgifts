<?php
require_once '../data/user.php';
require_once '../data/user-message.php';
require_once '../util/utilities.php';
require_once '../action/start-session.php';

$user_to_test = 2;

$_SESSION['last_message_to'] = user_to_test;

if (!isset($_SESSION['last_message_to'])) {
  throw new Exception('No new messages.');
}
$to = $_SESSION['last_message_to'];
unset($_SESSION['last_message_to']);
session_write_close();

$stmt = "CALL add_message_email(?)";
Database::run_statement(Database::get_connection(), $stmt, [$to]);
set_time_limit(300);
// Accumulate 2 minutes' worth of messages to recipient before sending email
//sleep(120);

$email = User::get_from_id($to)->email;

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

$subject = 'Sift.gifts - New messages!';

$name = ucwords(strtolower(User::get_from_email($email)->username));

$message = '
<html>
<body style="font-family: sans-serif;">
  <h1>Sift.gifts messages</h1>';
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
    <p>Log in to https://sift.gifts to reply.</p>
  </div>
</body>
</html>
';

echo $message;
?>