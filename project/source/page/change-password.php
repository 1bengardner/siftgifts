<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Festive&display=swap" rel="stylesheet">
    <title>Change password</title>
  </head>
  <body>
    <?php
      require_once '../action/authenticate.php';
      require_once '../data/user.php';
      $user = User::get_from_id($_SESSION['id']);
    ?>
    <form action="../action/submit-change-password.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"> . gifts</span></h1>
      <h2>Change password for <?php echo $user->username; ?></h2>
      <?php include 'message-box.php'; ?>
      <div>
        <input type="password" name="password" placeholder="New password" maxlength="255" minlength="6" required />
        <input type="password" name="confirm-password" placeholder="New password, again" maxlength="255" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Change password" />
      </div>
      <hr />
      <div>
        <a href="#" onclick="history.back();">Go back</a>
      </div>
    </form>
  </body>
</html>