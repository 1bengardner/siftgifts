<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Sift.gifts login'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include '../action/redirect-to-home.php'; ?>
    <form action="../action/submit-login.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Log in</h2>
      <?php include 'message-box.php'; ?>
      <div>
        <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" maxlength="255" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Log in" />
      </div>
      <hr />
      <div class="links-section">
        <a class="link" href="register">Sign up</a>
        <img src="./img/present.svg" />
        <a class="link" href="forgot-password">I forgot my password!</a>
      </div>
    </form>
  </body>
  <script src="../page/js/extra-flavour.js" type="text/javascript"></script>
</html>