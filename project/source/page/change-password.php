<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Change password'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php
      require_once '../action/authenticate.php';
      require_once '../data/user.php';
      $user = User::get_from_id($_SESSION['id']);
    ?>
    <form action="../action/submit-change-password.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Change password for <?php echo $user->username; ?></h2>
      <?php include 'message-box.php'; ?>
      <div>
        <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" required />
        <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Change password" />
      </div>
      <hr />
      <div>
        <a href="#" onclick="history.back();">Go back</a>
      </div>
    </form>
  </body>
  <script src="../page/js/extra-flavour.js" type="text/javascript"></script>
</html>