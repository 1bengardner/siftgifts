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
      <?php include 'standalone-logo.php'; ?>
      <h2>Edit profile</h2>
      <p class="subheading">Change your profile details.</p>
      <?php include 'notification-box.php'; ?>
      <div class="widget settings-widget">
        <div>
          <h3 class="first-in-series connected-text">Display name</h3>
          <div>
            <input type="text" name="name" placeholder="Display name" value="<?php echo $user->username; ?>" maxlength="30" />
          </div>
        </div>
        <div>
          <h3 class="connected-text">Password</h3>
          <div>
            <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" />
          </div>
          <div>
            <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" />
          </div>
        </div>
        <div>
          <h3 class="connected-text">Options</h3>
          <div>
            <span class="purple-box settings-box" style="margin: 0.5em;">
              <div>
                <input class="toggle-button" id="show-in-search" name="visible-in-directory" type="checkbox" <?php if ($user->visible) echo "checked"; ?> autocomplete="off" /><label for="show-in-search" title='Do you want to show up in "Find a wishlist"?'>🔍 Appear in wishlist search</label>
              </div>
              <div>
                <input class="toggle-button" id="message-alerts" name="subscribe-to-message-alerts" type="checkbox" autocomplete="off" disabled /><label for="message-alerts" title='Do you want to receive an email when you get a new message?'>📧 Get message notifications</label>
              </div>
            </span>
          </div>
        </div>
        <div>
          <input class="submit-button" type="submit" value="✍ Save profile" />
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