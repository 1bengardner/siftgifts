<?php
if (!isset($uuid)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', "Wishlist ".$uuid); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php' ?>
    <div class="center">
      <h1 class="wishlist-header">Wishlist <?php echo $uuid ?></h1>
    </div>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift&hellip;" />🔍</span>
    </form>
    <div class="center">
      <?php
        // require_once '../action/start-session.php';
        // if (isset($_SESSION["id"]) && $_SESSION['id'] === $id) {
          // echo '<p><strong>HEY!</strong> No peeking! <a href="/wishlist">Manage your wishlist</a> instead.</p>';
        // } else {
          $_GET['uuid']=$uuid;
          include '../action/show-gifts-for-uuid.php';
        // }
      ?>
    </div>
  </body>
  <script src="/page/js/search.js" type="text/javascript"></script>
  <script src="/page/js/reserve.js" type="text/javascript"></script>
</html>