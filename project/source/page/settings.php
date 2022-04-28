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
    <form action="/action/submit-change-settings.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Edit profile</h2>
      <p class="subheading">Change your display name, password, or both.</p>
      <?php include 'message-box.php'; ?>
      <div>
        <h3>Display name</h3>
        <div class="subheading">
          <input type="text" name="name" placeholder="Display name" value="<?php echo $user->username; ?>" maxlength="30" />
        </div>
        <div>
          <span class="info-box">
            <input id="show-in-wishlist" name="visible-in-directory" type="checkbox" <?php if ($user->visible) echo "checked"; ?> autocomplete="off" /><label for="show-in-wishlist" title='Select this to appear in "Find a wishlist"'>Appear in wishlist search</label>
          </span>
        </div>
      </div>
      <div>
        <h3>Password</h3>
        <div class="subheading">
          <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" />
        </div>
        <div>
          <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" />
        </div>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Update profile" />
      </div>
      <div class="links-section">
        <a class="link" href="home">Return to home</a>
      </div>
    </form>
  </body>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>