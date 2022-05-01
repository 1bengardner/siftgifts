<?php
if (!isset($_GET['email']) || !isset($_GET['code'])) {
  echo "Invalid request";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Verify account'); ?>
  <?php include 'head.php'; ?>
  <body class="center">
    <?php
    require_once '../util/utilities.php';

    if (Validation::invalid_verification_code($_GET['email'], $_GET['code'])) {
    ?>
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Invalid verification link</h2>
      <?php include 'notification-box.php'; ?>
      <div>
        <p>This verification link is invalid or expired.</p>
      </div>
      <p><a href="/">Return</a></p>
      <?php
    } else {
      $_POST = $_GET;
      include '../action/submit-verify.php';
    }
    ?>
  </body>
</html>