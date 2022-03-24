<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once '../action/authenticate.php';

?>
<div class="message-grid">
  <div class="message-chooser">
    <?php
    $stmt = "SELECT * FROM message WHERE `to`=? ORDER BY id DESC";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
    $msgs = $res->fetch_all(MYSQLI_ASSOC);
    if (count($msgs) === 0) {
    ?>
      <div class="widget focused center">
        <h2>No messages.</h2>
      </div>
    <?php
    } else {
      foreach ($msgs as $msg_data) {
        $msg = ($msg_data);
    ?>
        <div class="message-chooser-message">
          <div class="right">
            <?php
            $date = strtotime($msg['sent_time']);
            $date_format = 'g:i A';
            if ($date < strtotime('today')) {
              $date_format = 'M j';
            }
            if ($date < strtotime('first day of january this year')) {
              $date_format .= ', Y';
            }
            ?>
            <span><?php echo date($date_format, strtotime($msg['sent_time'])); ?></span>
          </div>
          <div>
            <p><strong><?php echo ucwords(strtolower(User::get_from_id($msg['from'])->username)); ?></strong></p>
            <p class="preview subheading"><?php echo $msg['body']; ?></p>
          </div>
        </div>
      <?php
      }
    }
    ?>
  </div>
  <div class="message-content">
    <?php
    $stmt = "SELECT * FROM message WHERE `to`=? ORDER BY id DESC";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
    $msgs = $res->fetch_all(MYSQLI_ASSOC);

    foreach ($msgs as $msg_data) {
      $msg = ($msg_data);
    ?>
    <p><?php echo nl2br($msg['body']); ?></p>
    <?php
    }
    ?>
  </div>
</div>
