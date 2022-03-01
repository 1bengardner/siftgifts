<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Change settings'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php
      require_once '../action/authenticate.php';
      require_once '../data/user.php';
      $user = User::get_from_id($_SESSION['id']);
    ?>
    <form action="../action/submit-change-settings.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Profile</h2>
      <?php include 'message-box.php'; ?>
      <div>
        <h3>Display name</h3>
        <input type="text" name="name" placeholder="Display name" value="<?php echo $user->username; ?>" maxlength="30" />
      </div>
      <div>
        <h3>Password</h3>
        <div>
          <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" />
        </div>
        <div>
          <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" />
        </div>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Update profile" />
      </div>
      <hr />
      <div>
        <a href="home">Return</a>
      </div>
    </form>
  </body>
  <script src="../page/js/extra-flavour.js" type="text/javascript"></script>
</html>