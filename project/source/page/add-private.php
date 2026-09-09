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
        <span id="url-link"></span>
      </div>
      <div>
        <input id="price" type="number" step="0.01" placeholder="Price" maxlength="10">
      </div>
      <div>
        <textarea id="comments" class="comments" placeholder="Additional comments?" maxlength="255"></textarea>
      </div>
      <div>
        <input id="unreservable" type="checkbox" /><label for="unreservable">Unreservable?</label>
      </div>
      <div class="unreservable-info">
        <p>Check this box if you want this wish to stay on your wishlist until you remove it.</p>
        <p>It can be useful for links to other wishlists.</p>
      </div>
      <input id="wishlist" type="hidden" value="<?php echo htmlentities($wishlist->short_name); ?>">
      <div>
        <input class="submit-button" type="submit" value="🎁 Add gift"/>
      </div>
      <?php include 'notification-box.php'; ?>
      <div class="links-section">
        <a class="link" href="private-wishlist/<?php echo rawurlencode($wishlist->short_name); ?>">⬅️ Return to <?php echo htmlentities($wishlist->name); ?> wishlist</a>
      </div>
    </form>
  </body>
  <script src="/page/js/gift-config.js" type="text/javascript"></script>
  <script src="/page/js/request-private.js" type="text/javascript"></script>
  <script src="/page/js/extra-flavour.js" type="text/javascript"></script>
</html>