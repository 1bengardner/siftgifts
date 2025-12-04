<?php
require_once '../util/utilities.php';

if (!include '../action/is-admin.php') {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /home");
  exit;
}
$stmt = "CALL get_prizes(?)";
$prizes = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_ASSOC);
$prizes = $prizes ? $prizes[0] : $prizes = array_fill(1, 7, "prize missing from db");
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Lottery administration'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <form action="/action/submit-regenerate-lottery-numbers.php" method="post">
    <?php include 'notification-box.php'; ?>
      <div class="widget settings-widget">
        <h2 class="first-in-series connected-text">Lottery Administration</h2>
        <div>
          <input class="submit-button" type="submit" value="🌀 Generate new numbers for pending lotteries" />
        </div>
      </div>
    </form>
    <form action="/action/submit-change-prizes.php" method="post">
      <div class="widget settings-widget">
        <h2 class="first-in-series">Prize Administration</h2>
        <div>
          <input name="1" placeholder="Prize 1" value="<?php echo htmlentities($prizes[1]); ?>" required />
        </div>
        <div>
          <input name="2" placeholder="Prize 2" value="<?php echo htmlentities($prizes[2]); ?>" required />
        </div>
        <div>
          <input name="3" placeholder="Prize 3" value="<?php echo htmlentities($prizes[3]); ?>" required />
        </div>
        <div>
          <input name="4" placeholder="Prize 4" value="<?php echo htmlentities($prizes[4]); ?>" required />
        </div>
        <div>
          <input name="5" placeholder="Prize 5" value="<?php echo htmlentities($prizes[5]); ?>" required />
        </div>
        <div>
          <input name="6" placeholder="Prize 6" value="<?php echo htmlentities($prizes[6]); ?>" required />
        </div>
        <div>
          <input name="7" placeholder="Prize 7" value="<?php echo htmlentities($prizes[7]); ?>" required />
        </div>
        <div>
          <input class="submit-button" type="submit" value="🏆 Update prizes" />
        </div>
      </div>
      <div>
        <div class="links-section">
          <a class="link" href="home">⬅️ Return to home</a>
        </div>
      </div>
    </form>
  </body>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>