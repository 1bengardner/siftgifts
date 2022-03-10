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
      <h2><a href="request">Add a gift ➕</a></h2>
      <input id="show-reserve" type="checkbox" onclick="enableToggles();" autocomplete="off" />
      <label for="show-reserve">Click to enable reserve override</label><span class="warning-box"><strong>WARNING:</strong> You will see what's been reserved!</span>
    </div>
    <div class="center wishlist-background">
      <h1 class="center">Your Wishlist</h1>
      <form>
        <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift..." />🔍</span>
      </form>
      <div class="center">
        <?php
          $_GET['user']=$user->id;
          include '../action/show-gifts-admin.php';
        ?>
      </div>
    </div>
  </body>
  <script src="js/search.js" type="text/javascript"></script>
  <script src="js/remove.js" type="text/javascript"></script>
  <script src="js/reserve.js" type="text/javascript"></script>
</html>