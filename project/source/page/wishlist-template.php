<?php
if (!isset($user) || !isset($id)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <?php define('TITLE', ucfirst(strtolower($user)))."'s wishlist"); ?>
  <?php include '../page/head.php'; ?>
  <body>
    <?php include '../page/header.php' ?>
    <h1 class="center"><?php echo ucfirst(strtolower($user)) ?>'s Wishlist</h1>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift..." />🔍</span>
    </form>
    <div class="center">
      <?php
        require_once '../action/start-session.php';
        if (isset($_SESSION["id"]) && $_SESSION['id'] === $id) {
          echo '<p><strong>HEY!</strong> No peeking! Visit your <a href="../page/home">home</a> instead.</p>';
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