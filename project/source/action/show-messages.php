<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../action/authenticate.php';

$stmt = "SELECT * from message JOIN (SELECT conversation_partner, MAX(most_recent) most_recent FROM (SELECT `from` conversation_partner, MAX(sent_time) most_recent FROM message WHERE `to`=? GROUP BY `from` UNION SELECT `to`, MAX(sent_time) most_recent FROM message WHERE `from`=? GROUP BY `to`) res GROUP BY conversation_partner) res ON (`to` = conversation_partner OR `from` = conversation_partner) AND sent_time = most_recent ORDER BY most_recent DESC";
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
    <div class="message-chooser-message" conversation=<?php echo $msg->conversation_partner; ?>>
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
        <span class="last-message-time"><?php echo date($date_format, strtotime($msg->sent_time)); ?></span>
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
  <div class="message-viewer">
    <div class="message-content"></div>
    <form user=<?php echo $_SESSION['id']; ?> id="message-form" method="post"></form>
  </div>
</div>
<?php
}
?>