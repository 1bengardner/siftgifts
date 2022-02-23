<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Sign up for Sift.gifts'); ?>
  <?php include 'head.php'; ?>
  <body>
    <form action="../action/submit-register.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"><span class="spaced">.</span>gifts</span></h1>
      <h2>Sign up for Sift.gifts!</h2>
      <h3 class="subheading">(It's free!)</h3>
      <?php include 'message-box.php'; ?>
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
      <div>
        <input class="submit-button" type="submit" value="Sign up" />
      </div>
      <hr />
      <div>
        <a href="login">Log in</a>
      </div>
    </form>
  </body>
  <script src="../page/js/extra-flavour.js" type="text/javascript"></script>
</html>