<?php
if (!isset($user) || !isset($id)) {
  echo "how did u find me";
  exit;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../page/css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Festive&display=swap" rel="stylesheet">
    <title><?php echo ucfirst(strtolower($user)) ?>'s wishlist</title>
  </head>
  <body>
    <?php include '../page/header.php' ?>
    <h1 class="center"><?php echo ucfirst(strtolower($user)) ?>'s Wishlist</h1>
    <form>
      <span class="unbreakable"><input id="search" type="search" name="q" placeholder="Search for a gift..." />🔍</span>
    </form>
    <div class="center">
      <?php
        if (session_status() === PHP_SESSION_NONE)
          session_start();
        if (isset($_SESSION["id"]) && $_SESSION['id'] === $id) {
          echo '<p><strong>HEY!</strong> No peeking! Visit your <a href="../page/dashboard">dashboard</a> instead.</p>';
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