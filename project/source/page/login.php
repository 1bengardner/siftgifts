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
    <title>Login</title>
  </head>
  <body>
    <form action="../action/submit-login.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"> . gifts</span></h1>
      <?php include 'message-box.php'; ?>
      <div>
        <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
        <input type="password" name="password" placeholder="Password" maxlength="255" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Log in" />
      </div>
      <hr />
      <div>
        <a href="register">Sign up</a>
        <a href="mailto:1bengardner@gmail.com?subject=I%20forgot%20my%20password%20on%20sift%20gifts%20what%20do%20i%20do%20lol&body=Please%20help">I forgot my password!</a>
      </div>
    </form>
  </body>
</html>