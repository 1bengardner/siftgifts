<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Forgot password'); ?>
  <?php include 'head.php'; ?>
  <body>
    <form action="/action/submit-forgot-password.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Forgot your password?</h2>
      <div>
        <p>Please email <object class="email" width="112" height="20" data="/page/img/email.svg" type="image/svg+xml" style="vertical-align: middle;"></object>.</p>
      </div>
      <div class="links-section">
        <a class="link" href="/login">⬅️ Go back to login</a>
      </div>
    </form>
  </body>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>