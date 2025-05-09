<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Sign up for Sift.gifts'); ?>
  <?php include 'head.php'; ?>
  <body>
    <form action="/action/submit-register.php" method="post">
      <?php include 'standalone-logo.php'; ?>
      <h2>Sign up for Sift.gifts!</h2>
      <h3 class="subheading">(It's free!)</h3>
      <?php include 'notification-box.php'; ?>
      <div>
        <input type="text" name="name" placeholder="Display name" maxlength="30" required />
      </div>
      <div>
        <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" minlength="6" maxlength="255" required />
      </div>
      <div>
        <input type="password" name="confirm-password" placeholder="Confirm password" maxlength="255" required />
      </div>
      <input type="password" name="confirm-password-again" style="display:none !important" tabindex="-1" autocomplete="off">
      <div>
        <input class="submit-button" type="submit" value="✨ Sign up" />
      </div>
      <div class="links-section">
        <a class="link" href="login">Log in</a>
      </div>
    </form>
  </body>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>