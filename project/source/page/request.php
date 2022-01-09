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
    <title>Add a new gift</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
      require_once '../util/utilities.php';
      require_once '../action/authenticate.php';

      if(isset($_POST['submit'])) {
        // TODO: Validate fields

        $stmt = "CALL add_gift(?, ?, ?)";
        Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], $_POST['comments']]);
      }
    ?>
    <form id="request-form" enctype="multipart/form-data" onsubmit="request()">
      <?php include 'user-buttons.php'; ?>
      <hr class="large" />
      <h2>Add to your wishlist</h2>
      <div hidden id="message">
        <div class="success-box">
          <p>Added!</p>
        </div>
      </div>
      <div>
        <input id="name" type="name" placeholder="Gift name" maxlength="255" required />
      </div>
      <div>
        <input id="url" type="url" placeholder="URL link" maxlength="255" />
      </div>
      <div>
        <textarea id="comments" class="comments" placeholder="Additional comments?" maxlength="255"></textarea>
      </div>
      <div>
        <input class="submit-button" type="submit" value="Add gift"/>
      </div>
    </form>
  </body>
  <script src="js/request.js" type="text/javascript"></script>
</html>