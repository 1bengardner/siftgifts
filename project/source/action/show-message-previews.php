<?php
require_once '../action/authenticate.php';
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../data/user.php';

$stmt = "CALL get_conversations(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
$msgs = $res->fetch_all(MYSQLI_ASSOC);

foreach ($msgs as $msg_data) {
  $msg = new UserMessage($msg_data);
  $msg->conversation_partner_id = $msg_data['conversation_partner_id'];
?>
  <div
    <?php
    if (isset($msg->guest_name)) {
      echo 'title="Guest message"';
    } else if (!isset($msg->conversation_partner_id)) {
      echo 'title="Anonymous message"';
    }
    ?>
    class="message-chooser-message<?php if ($msg->unread && ($msg->from != $_SESSION['id'] || $msg->conversation_partner_id == $_SESSION['id'])) echo " unread"; ?>"
    <?php if ($msg->conversation_partner_id) echo 'conversation="'.$msg->conversation_partner_id.'"'; ?>
    last-message="<?php echo $msg->id; ?>">
    <p class="preview">
      <span class="conversation-partner<?php if (!isset($msg->conversation_partner_id)) echo ' muted'; ?>">
        <?php
        if (isset($msg->conversation_partner_id)) {
          echo ucwords(strtolower(User::get_from_id($msg->conversation_partner_id)->username));
        } else if (isset($msg->guest_name)) {
          echo '👻 '.ucwords(strtolower($msg->guest_name));
        } else {
          echo '👻';
        }
        ?>
      </span>
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
      <span class="last-message-time right smaller muted"><?php echo date($date_format, strtotime($msg->sent_time)); ?></span>
    </p>
    <p class="last-message-body preview subheading smaller">
      <?php
      if ($msg->from === $_SESSION['id']) {
        echo '<span class="sent'.($msg->unread ? '' : ' seen').'">'.htmlentities($msg->body).'</span>';
      } else {
        echo htmlentities($msg->body);
      }
      ?>
    </p>
  </div>
<?php
  }
?>