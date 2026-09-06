<!DOCTYPE html>
<html>
  <?php
  require_once '../action/authenticate.php';
  require_once '../data/user.php';
  $user = User::get_from_id($_SESSION['id']);
  ?>
  <?php define('TITLE', ucwords(strtolower($user->username))."'s private wishlist"); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'notification-box.php'; ?>
    <div class="center">
      <nav><a href="../private-wishlists">🔒 Private wishlists</a></nav>
      <span class="unbreakable">
        <input title="Your private wishlist link" class="wishlist-link" disabled type="url" value='<?php echo 'https://sift.gifts/uuid/'.$uuid; ?>'>
        <button class="clipboard-button" title="Copy" url="<?php echo $private_wishlist; ?>">📎</button>
        <div class="clipboard-copy-reaction"></div>
      </span>
      <h2>
        <a href="/add-private?uuid=<?php echo $uuid; ?>">➕ Add a private gift</a>
      </h2>
      <span class="warning-box">
        <input id="show-reserve" class="toggle-button" type="checkbox" onclick="enableToggles(event);" autocomplete="off" /><label for="show-reserve">View/modify reserved gifts</label>
      </span>
    </div>
    <div class="center wishlist-background">
      <h1 class="center">Your Private Wishlist</h1>
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
</html>
