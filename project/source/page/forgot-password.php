<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Forgot password'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include '../action/redirect-to-home.php'; ?>
    <form action="/action/submit-forgot-password.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Forgot your password?</h2>
      <?php include 'notification-box.php'; ?>
      <div>
        <p>That's okay&hellip;as long as you remember your e&#8209;mail!</p>
      </div>
      <div>
        <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="🔃 Request password reset" />
      </div>
      <div class="links-section">
        <a class="link" href="/login">⬅️ Go back to login</a>
      </div>
    </form>
  </body>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>