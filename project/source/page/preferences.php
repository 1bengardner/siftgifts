<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Preferences'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php
      require_once '../action/authenticate.php';
      require_once '../data/user.php';
      $user = User::get_from_id($_SESSION['id']);
    ?>
    <form action="/action/submit-change-preferences.php" method="post">
      <?php include 'standalone-logo.php'; ?>
      <div class="widget settings-widget">
        <h2 class="first-in-series connected-text">Your preferences</h2>
        <?php include 'notification-box.php'; ?>
        <div>
          <span class="purple-box settings-box">
            <input class="toggle-button" id="message-alerts" name="subscribe-to-message-alerts" type="checkbox" <?php if ($user->subscribed) echo "checked"; ?> autocomplete="off" /><label for="message-alerts" title='Do you want to receive an email when you get a new message?'>Subscribe to message notification emails</label>
          </span>
        </div>
        <div>
          <input class="submit-button" type="submit" value="✍ Save preferences" />
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