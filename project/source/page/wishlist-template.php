<?php
if (!isset($id)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', ucwords(strtolower($user))."'s wishlist"); ?>
  <?php include '../page/head.php'; ?>
  <body>
    <?php include '../page/header.php' ?>
    <?php
    require_once '../data/user.php';

    $user = User::get_from_id($id)->username;
    ?>
    <h1 class="center"><?php echo ucwords(strtolower($user)) ?>'s Wishlist</h1>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift..." />🔍</span>
    </form>
    <div class="center">
      <?php
        require_once '../action/start-session.php';
        if (isset($_SESSION["id"]) && $_SESSION['id'] === $id) {
          echo '<p><strong>HEY!</strong> No peeking! <a href="../page/wishlist">Manage your wishlist</a> instead.</p>';
        } else {
          $_GET['user']=$id;
          include '../action/show-gifts.php';
        }
      ?>
    </div>
  </body>
  <script src="../page/js/autocomplete.js" type="text/javascript"></script>
  <script src="../page/js/reserve.js" type="text/javascript"></script>
</html>