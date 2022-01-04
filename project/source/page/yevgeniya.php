<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Festive&display=swap" rel="stylesheet">
    <title>Yevgeniya's wishlist</title>
  </head>
  <body style="background-color: rgba(255, 0, 0, 0.05);">
    <?php include 'header.php' ?>
    <h1 class="center">Yevgeniya's Wishlist</h1>
    <form>
      <input id="search" type="search" name="q" placeholder="Search for a gift..." />
      🔍
    </form>
    <div class="center">
      <?php
        session_start();
        if (isset($_SESSION["id"]) && $_SESSION['id'] === 1) {
          echo '<p><strong>HEY!</strong> No peeking! Visit your <a href="dashboard">dashboard</a> instead.</p>';
        } else {
          $_GET['user']=1;
          include '../action/show-gifts.php';
        }
      ?>
    </div>
  </body>
  <script src="js/autocomplete.js" type="text/javascript"></script>
  <script src="js/reserve.js" type="text/javascript"></script>
</html>