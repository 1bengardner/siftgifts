<?php
require_once '../action/authenticate.php';
require_once '../data/user.php';
$user = User::get_from_id($_SESSION['id']);
if (!in_array($user->id, [2])) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Sift.gifts - Lottery Administration'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>    
    <form action="/action/submit-regenerate-lottery-numbers.php" method="post">
      <div class="widget settings-widget">
        <h2 class="first-in-series connected-text">Lottery Administration</h2>
        <?php include 'notification-box.php'; ?>
        <div>
          <input class="submit-button" type="submit" value="🌀 Generate new numbers for pending lotteries" />
        </div>
      </div>
      <div>
        <div class="links-section">
          <a class="link" href="home">⬅️ Return to home</a>
        </div>
      </div>
    </form>
  </body>
</html>