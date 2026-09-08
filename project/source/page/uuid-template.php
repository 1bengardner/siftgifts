<?php
if (!isset($wishlist)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', $wishlist->name); ?>
  <?php include 'head.php'; ?>
  <body>
    <?php include 'header.php' ?>
    <div class="center">
      <h1 class="wishlist-header"><?php echo htmlentities($wishlist->name); ?></h1>
    </div>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift&hellip;" />🔍</span>
    </form>
    <div class="center">
      <?php
        require_once '../action/start-session.php';
        if (isset($_SESSION["id"]) && $_SESSION['id'] === $wishlist->owner) {
          echo '<p><strong>HEY!</strong> No peeking! <a href="/private-wishlist/'.rawurlencode($wishlist->short_name).'">Manage your wishlist</a> instead.</p>';
        } else {
          $_GET['id'] = $wishlist->id;
          include '../action/show-gifts-for-uuid.php';
        }
      ?>
    </div>
  </body>
  <script src="/page/js/search.js" type="text/javascript"></script>
  <script src="/page/js/reserve.js?v=2" type="text/javascript"></script>
</html>