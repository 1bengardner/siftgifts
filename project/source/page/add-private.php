<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';
if (!isset($_GET["wishlist"])) {
  $_SESSION["notifications"] = [new Notification(NotificationText::WishlistDoesNotExist, NotificationLevel::Error)];
  header("Location: /private-wishlists");
  exit;
}
$stmt = "SELECT * FROM wishlist WHERE short_name = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET["wishlist"]])->fetch_assoc();
if (is_null($res)) {
  $_SESSION["notifications"] = [new Notification(NotificationText::WishlistDoesNotExist, NotificationLevel::Error)];
  header("Location: /private-wishlists");
  exit;
}
require_once '../data/wishlist.php';
$wishlist = new Wishlist($res);
if ($wishlist->owner !== $_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoWishlistAccess, NotificationLevel::Error)];
  header("Location: /private-wishlists");
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', 'Add a new private gift'); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <form id="request-form" enctype="multipart/form-data" onsubmit="request()">
      <h2>Add to <?php echo htmlentities($wishlist->name); ?> wishlist</h2>
      <div>
        <input id="name" type="name" placeholder="Gift name" maxlength="255" required />
      </div>
      <div>
        <input id="url" type="url" placeholder="URL link" maxlength="255" />
      </div>
      <div>
        <textarea id="comments" class="comments" placeholder="Additional comments?" maxlength="255"></textarea>
      </div>
      <input id="wishlist" type="hidden" value="<?php echo htmlentities($wishlist->short_name); ?>">
      <?php include 'notification-box.php'; ?>
      <div>
        <input class="submit-button" type="submit" value="🎁 Add gift"/>
      </div>
      <div class="links-section">
        <a class="link" href="private-wishlist/<?php echo rawurlencode($wishlist->short_name); ?>">⬅️ Return to <?php echo htmlentities($wishlist->name); ?> wishlist</a>
      </div>
    </form>
  </body>
  <script src="/page/js/request-private.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>