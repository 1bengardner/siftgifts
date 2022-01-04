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
    <?php
    require_once '../action/authenticate.php';
    require_once '../data/user.php';
    $user = User::get_from_id($_SESSION['id']);
    ?>
    <title><?php echo $user->email ?>'s wishlist</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php include 'user-buttons.php'; ?>
    <form>
      <input id="search" type="search" name="q" placeholder="Search for a gift..." />
      🔍
    </form>
    <div class="center">
      <?php
        $_GET['user']=$user->id;
        include '../action/show-gifts-admin.php';
      ?>
    </div>
  </body>
  <script src="js/autocomplete.js" type="text/javascript"></script>
  <script src="js/remove.js" type="text/javascript"></script>
</html>