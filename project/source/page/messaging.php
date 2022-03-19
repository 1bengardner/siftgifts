<!DOCTYPE html>
<html>
  <?php
  require_once '../action/authenticate.php';
  require_once '../data/user.php';
  $user = User::get_from_id($_SESSION['id']);
  ?>
  <?php define('TITLE', 'Sift.gifts - '.ucwords(strtolower($user->username)).'\'s messages'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'message-box.php'; ?>
    <div>
      <h2 class="center">Messages for <?php echo ucwords(strtolower($user->username)); ?></h2>
      <strong>
        <ul>TODO:
          <li>Make messages selectable</li>
          <li>Load messages from whoever sent the selected one</li>
          <li>Display only messages sent by selected sender</li>
        </ul>
      </strong>
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
      }
      ?>
      <div class="message-grid">
        <div class="message-chooser">
          <?php
          $stmt = "SELECT * FROM message WHERE `to`=? ORDER BY id DESC";
          $res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']]);
          $msgs = $res->fetch_all(MYSQLI_ASSOC);

          foreach ($msgs as $msg_data) {
            $msg = ($msg_data);
          ?>
          <div class="message-chooser-message">
            <div class="right">
              <?php
              $date = strtotime($msg['sent_time']);
              $date_format = 'g:i A';
              if ($date < strtotime('today')) {
                $date_format = 'M j '.$date_format;
              }
              if ($date < strtotime('first day of january this year')) {
                $date_format = '(Y) '.$date_format;
              }
              ?>
              <span><?php echo date($date_format, strtotime($msg['sent_time'])); ?></span>
            </div>
            <div>
              <p><strong><?php echo ucwords(strtolower(User::get_from_id($msg['from'])->username)); ?></strong></p>
              <p class="preview"><?php echo $msg['body']; ?></p>
            </div>
          </div>
          <?php
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
    </div>
  </body>
</html>