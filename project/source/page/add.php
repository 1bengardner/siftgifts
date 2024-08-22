<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Add a new gift'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php require_once '../action/authenticate.php'; ?>
      <h2>Add to your wishlist!</h2>
      <div>
        <p>Temporarily disabled. Sorary!</p>
      </div>
      <?php include 'notification-box.php'; ?>
      <div class="links-section">
        <a class="link" href="wishlist">⬅️ Return to wishlist</a>
      </div>
  </body>
  <script src="/page/js/request.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>