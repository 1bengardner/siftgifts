<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../data/user.php';
require_once '../action/authenticate.php';

$stmt = "CALL get_conversations(?)";
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
    $msg->conversation_partner_id = $msg_data['conversation_partner_id'];
  ?>
    <div
      <?php
      if (isset($msg->conversation_partner_id)) {
        echo 'title="'.htmlentities($msg->body).'"';
      } else if (isset($msg->guest_name)) {
        echo 'title="Guest message"'.ucwords(strtolower($msg->guest_name));
      } else {
        echo 'title="Anonymous message"';
      }
      ?>
      class="message-chooser-message <?php if ($msg->unread && ($msg->from != $_SESSION['id'] || $msg->conversation_partner_id == $_SESSION['id'])) echo "unread"; ?>"
      conversation="<?php echo $msg->conversation_partner_id; ?>"
      last-message="<?php echo $msg->id; ?>">
      <div>
        <p class="preview">
          <strong>
          <?php
          if (isset($msg->conversation_partner_id)) {
            echo ucwords(strtolower(User::get_from_id($msg->conversation_partner_id)->username));
          } else if (isset($msg->guest_name)) {
            echo '<em>❓</em> '.ucwords(strtolower($msg->guest_name));
          } else {
            echo '<em>👻</em>';
          }
          ?>
          </strong>
          <?php
          $date = strtotime($msg->sent_time);
          $date_format = 'g:i A';
          if ($date < strtotime('first day of january this year')) {
            $date_format = 'Y';
          } else if ($date < strtotime('last Sunday')) {
            $date_format = 'M j';
          } else if ($date < strtotime('today')) {
            $date_format = 'l';
          }
          ?>
          <span class="preview right last-message-time"><?php echo date($date_format, strtotime($msg->sent_time)); ?></span>
        </p>
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
    <div class="message-content"><div class="center">Select a message to expand the conversation.</div></div>
    <form id="message-form" method="post"></form>
  </div>
</div>
<?php
}
?>