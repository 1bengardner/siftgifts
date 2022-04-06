<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../action/authenticate.php';

$stmt = "SELECT * FROM message m1 JOIN (SELECT `from`, MAX(sent_time) AS most_recent FROM message WHERE `to`=? GROUP BY `from`) m2 ON m1.`from` = m2.`from` and m1.sent_time = m2.most_recent ORDER BY sent_time DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
$msgs = $res->fetch_all(MYSQLI_ASSOC);
if (count($msgs) === 0) {
?>
<div class="widget focused center">
  <h2>No messages.</h2>
</div>
<?php
} else {
?>
<div class="message-grid">
  <div class="message-chooser">
<?php
  foreach ($msgs as $msg_data) {
    $msg = new UserMessage($msg_data);
?>
    <div class="message-chooser-message" id=<?php echo $msg->id; ?>>
      <div class="right">
<?php
    $date = strtotime($msg->sent_time);
    $date_format = 'g:i A';
    if ($date < strtotime('today')) {
      $date_format = 'M j';
    }
    if ($date < strtotime('first day of january this year')) {
      $date_format .= ', Y';
    }
?>
        <span><?php echo date($date_format, strtotime($msg->sent_time)); ?></span>
      </div>
      <div>
        <p><strong><?php echo ucwords(strtolower(User::get_from_id($msg->from)->username)); ?></strong></p>
        <p class="preview subheading"><?php echo htmlentities($msg->body); ?></p>
      </div>
    </div>
<?php
  }
?>
  </div>
  <div class="message-content"></div>
</div>
<?php
}
?>