<!DOCTYPE html>
<html>
  <?php
  require_once '../util/utilities.php';
  require_once '../data/gift.php';
  require_once '../action/authenticate.php';

  $gift = null;
  if (isset($_POST['gift'])) {
    // Get gift from db
    $stmt = "SELECT * FROM gift WHERE id=? AND user=? AND active=1";
    $res = Database::run_statement(Database::get_connection(), $stmt, [$_POST['gift'], $_SESSION['id']]);
    $gift_data = $res->fetch_assoc();
    if (!is_null($gift_data)) {
      $gift = new Gift($gift_data);
    }    
  }
  ?>
  <?php define('TITLE', 'Edit a gift'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
      <?php
      if (is_null($gift)) {
      ?>
      <h2>Select a gift to edit.</h2>
      <?php
      } else {
      ?>
      <h2>Editing: <em id="name-heading"><?php echo htmlentities($gift->name); ?></em></h2>
      <div>
        <p>Temporarily disabled. Sorary!</p>
      </div>
      <?php
      }
      ?>
      <?php include 'notification-box.php'; ?>
      <div class="links-section">
        <a class="link" href="wishlist">⬅️ Return to wishlist</a>
      </div>
  </body>
  <script src="/page/js/edit.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>