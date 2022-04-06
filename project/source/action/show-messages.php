<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../action/authenticate.php';

$stmt = "SELECT * FROM (SELECT * FROM message m1 JOIN (SELECT `from` conversation_partner, MAX(sent_time) most_recent FROM message WHERE `to`=? GROUP BY `from`) m2 ON m1.`from` = m2.conversation_partner and m1.sent_time = m2.most_recent UNION (SELECT * FROM message m1 JOIN (SELECT `to`, MAX(sent_time) most_recent FROM message WHERE `from`=? GROUP BY `to`) m2 ON m1.`to` = m2.`to` and m1.sent_time = m2.most_recent)) res GROUP BY conversation_partner ORDER BY sent_time DESC";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id'], $_SESSION['id']]);
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
    $msg->conversation_partner = $msg_data['conversation_partner']
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
        <p><strong><?php echo ucwords(strtolower(User::get_from_id($msg->conversation_partner)->username)); ?></strong></p>
        <p class="preview subheading">
          <?php
          if ($msg->from === $_SESSION['id']) {
            echo '<em>'.htmlentities($msg->body).'</em>';
          } else {
            echo htmlentities($msg->body);
          }
          ?>
        </p>
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