<?php
if (!isset($wishlist)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php
  ?>
  <?php
  require_once '../data/user.php';
  define('TITLE', ucwords(strtolower(User::get_from_id($wishlist->owner)->username))."'s private wishlist");
  ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'notification-box.php'; ?>
    <div class="center">
      <nav><a href="../private-wishlists">🔒 Private wishlists</a></nav>
      <span class="unbreakable">
        <input title="<?php echo htmlentities($wishlist->name); ?> wishlist link" class="wishlist-link" disabled type="url" value='<?php
          $wishlist_url = 'https://sift.gifts/registry/'.rawurlencode($wishlist->short_name);
          echo $wishlist_url;
        ?>'>
        <button class="clipboard-button" title="Copy" url="<?php echo $wishlist_url; ?>">📎</button>
        <div class="clipboard-copy-reaction"></div>
      </span>
      <h2>
        <a href="/add-private?wishlist=<?php echo rawurlencode($wishlist->short_name); ?>">➕ Add a private gift</a>
      </h2>
      <span class="warning-box">
        <input id="show-reserve" class="toggle-button" type="checkbox" onclick="enableToggles(event);" autocomplete="off" /><label for="show-reserve">View/modify reserved gifts</label>
      </span>
    </div>
    <div class="center wishlist-background">
      <h1 class="center" id="wishlist-title"><?php echo htmlentities($wishlist->name); ?></h1>
      <form>
        <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift&hellip;" />🔍</span>
      </form>
      <div class="center">
        <?php
          include '../action/show-gifts-admin-private.php';
        ?>
      </div>
    </div>
  </body>
  <script src="/page/js/search.js" type="text/javascript"></script>
  <script src="/page/js/remove.js" type="text/javascript"></script>
  <script src="/page/js/reserve.js" type="text/javascript"></script>
  <script src="/page/js/share-wishlist.js" type="text/javascript"></script>
  <script src="/page/js/edit-wishlist-title.js?id=<?php echo rawurlencode($wishlist->short_name); ?>" type="text/javascript"></script>
</html>
