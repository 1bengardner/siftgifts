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
    <title>Registration</title>
  </head>
  <body>
    <form action="../action/submit-register.php" method="post">
      <h1 class="logo-text">Sift<span class="accent"> . gifts</span></h1>
      <h2>Sign up for Sift.gifts!</h2>
      <h3 class="subheading">(It's free!)</h3>
      <?php include 'message-box.php'; ?>
      <div>
        <input type="text" name="name" placeholder="Username" maxlength="30" required />
      </div>
      <div>
        <input type="email" name="email" placeholder="E-mail" maxlength="320" required />
      </div>
      <div>
        <input type="password" name="password" placeholder="Password" minlength="6" maxlength="255" required />
      </div>
      <div>
        <input type="password" name="confirm-password" placeholder="Confirm password" maxlength="255" required />
      </div>
      <div>
        <input class="submit-button" type="submit" value="Sign up" />
      </div>
      <hr />
      <div>
        or <a href="login">log in</a>
      </div>
    </form>
  </body>
</html>