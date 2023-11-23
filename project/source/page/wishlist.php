<!DOCTYPE html>
<html>
  <?php
  require_once '../action/authenticate.php';
  require_once '../data/user.php';
  $user = User::get_from_id($_SESSION['id']);
  ?>
  <?php define('TITLE', ucwords(strtolower($user->username))."'s wishlist"); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php'; ?>
    <div class="center">
      <h2><a href="add">➕ Add a gift</a></h2>
      <span class="warning-box">
        <input id="show-reserve" class="toggle-button" type="checkbox" onclick="enableToggles();" autocomplete="off" /><label for="show-reserve">View/modify reserved gifts</label>
      </span>
    </div>
    <div class="center wishlist-background">
      <h1 class="center">Your Wishlist</h1>
      <form>
        <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift&hellip;" />🔍</span>
      </form>
      <div class="center">
        <?php
          include '../action/show-gifts-admin.php';
        ?>
      </div>
    </div>
  </body>
  <script src="/page/js/search.js" type="text/javascript"></script>
  <script src="/page/js/remove.js" type="text/javascript"></script>
  <script src="/page/js/reserve.js" type="text/javascript"></script>
  <script src="/page/js/edit.js" type="text/javascript"></script>
</html>