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
    <?php include 'notification-box.php'; ?>
    <div class="center">
      <h2 class="messaging-header">Messages for <?php echo ucwords(strtolower($user->username)); ?></h2>
      <a href="/send-message">📝 Compose</a>
    </div>
    <div>
      <?php include '../action/show-messages.php'; ?>
    </div>
  </body>
  <script src="/page/js/messaging.js" type="text/javascript"></script>
</html>