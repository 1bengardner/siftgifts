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
    <div class="center">
      <h2>Messages for <?php echo ucwords(strtolower($user->username)); ?></h2>
    </div>
  </body>
</html>