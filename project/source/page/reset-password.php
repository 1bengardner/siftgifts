<?php
if (!isset($_GET['email']) || !isset($_GET['code'])) {
  echo "Invalid request";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Reset password'); ?>
  <?php include 'head.php'; ?>
  <body>
    <form action="../action/submit-reset-password.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Reset password for <?php echo $_GET['email']; ?></h2>
      <?php include 'message-box.php'; ?>
      <?php
      require_once '../util/utilities.php';

      if (Validation::invalid_reset_code($_GET['email'], $_GET['code'])) {
      ?>
      <div>
        <p>This reset link is invalid or expired.</p>
        <p>Please <a href="forgot-password">request</a> a new one.</p>
      </div>
      <?php
      } else {
      ?>
      <div>
        <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" required />
        <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" required />
        <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>" />
        <input type="hidden" name="code" value="<?php echo $_GET['code'] ?>" />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Reset password" />
      </div>
      <?php
      }
      ?>
      <hr />
      <div>
        <a href="/">Cancel</a>
      </div>
    </form>
  </body>
  <script src="../page/js/extra-flavour.js" type="text/javascript"></script>
</html>