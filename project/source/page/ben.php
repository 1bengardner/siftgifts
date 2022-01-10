<!DOCTYPE html>
<html>
  <?php define('TITLE', "Ben's wishlist"); ?>
  <?php include 'head.php'; ?>
  <body style="background-color: rgba(0, 255, 0, 0.05);">
    <?php include 'header.php'; ?>
    <h1 class="center">Ben's Wishlist</h1>
    <form>
      <input id="search" type="search" name="q" placeholder="Search for a gift..." />
      🔍
    </form>
    <div class="center">
      <?php
        require_once '../action/start-session.php';
        if (isset($_SESSION["id"]) && $_SESSION['id'] === 2) {
          echo '<p><strong>HEY!</strong> No peeking! Visit your <a href="home">home</a> instead.</p>';
        } else {
          $_GET['user']=2;
          include '../action/show-gifts.php';
        }
      ?>
    </div>
  </body>
  <script src="js/autocomplete.js" type="text/javascript"></script>
  <script src="js/reserve.js" type="text/javascript"></script>
</html>