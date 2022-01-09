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
    <?php
    require_once '../action/authenticate.php';
    require_once '../data/user.php';
    $user = User::get_from_id($_SESSION['id']);
    ?>
    <title><?php echo ucfirst(strtolower($user->username)) ?>'s dashboard</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <?php
    if (session_status() === PHP_SESSION_NONE)
      session_start();
    if (isset($_SESSION["messages"])) {
    ?>
    <div class="center">
      <div class="success-box">
        <?php
        foreach ($_SESSION["messages"] as $message) {
        ?>
        <p>
          <?php echo $message; ?>
        </p>
        <?php
        }
        unset($_SESSION["messages"]);
        ?>
      </div>
    </div>
    <?php
    }
    ?>
    <?php include 'user-buttons.php'; ?>
    <div class="center">
      <div>
        <?php $wishlist = 'https://sift.gifts/wishlist/'.strtolower($user->username); ?>
        <p>Share your wishlist:<span class="unbreakable"><input class="wishlist-link" disabled id="foo" type="url" value='<?php echo $wishlist; ?>'><button class="clipboard-button" title="Copy" onclick="navigator.clipboard.writeText('<?php echo $wishlist; ?>')">📋</button></span></p>
      </div>
      <div class="home-greeting">
        <h1>
          <?php
          if (!isset($_SESSION['greeted'])) {
            $_SESSION['greeted'] = true;
            echo 'Welcome, '.ucfirst(strtolower($user->username));
          } else {
            $greetings = array('Hello', 'Hi there', 'Howdy', 'Greetings', 'Ahoy there', 'So good to see you', 'Fancy seeing you here', "Well, if it isn't you again");
            echo $greetings[array_rand($greetings)].', '.ucfirst(strtolower($user->username));
          }
          ?>!
        </h1>
        <svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 783.79 812" xmlns:xlink="http://www.w3.org/1999/xlink"><title>Hello!</title><polygon points="728.72 0 721.41 7.04 641.89 83.67 507.08 213.58 513.43 769.66 0.67 643.42 0.67 275.37 194.1 52.39 728.72 0" fill="#373e46"/><polygon points="728.72 0 721.41 7.04 641.89 83.67 507.08 213.58 513.43 769.66 0.67 643.42 0.67 275.37 194.1 52.39 728.72 0" opacity="0.1"/><polygon points="783.79 353.28 769.02 730.73 239.77 811.33 0.67 643.42 0.67 280.74 507.08 213.58 783.79 353.28" fill="#373e46"/><polygon points="783.12 353.28 768.34 730.73 239.1 811.33 0 643.42 0 280.74 506.41 213.58 783.12 353.28" fill="#373e46"/><polygon points="239.77 421.78 239.77 811.33 0.67 643.42 0.67 280.98 239.77 421.78" opacity="0.1"/><polygon points="721.41 7.04 641.89 83.67 258.58 126.27 190.07 59.1 721.41 7.04" opacity="0.1"/><polygon points="507.08 213.58 512.45 773.72 769.02 730.73 783.79 353.28 507.08 213.58" opacity="0.1"/><polygon points="783.79 353.28 680.36 343.87 431.91 220.86 507.08 213.58 783.79 353.28" fill="#373e46"/><polygon points="194.1 52.39 262.61 119.55 722 68.51 728.72 0 194.1 52.39" fill="#373e46"/><path d="M556,303.92a43.49,43.49,0,0,1-1,9.47,42.71,42.71,0,0,1-7,15.63,45.23,45.23,0,0,1-3.7,4.47A42.7,42.7,0,0,1,518,346.62a42.3,42.3,0,0,1-4.94.28,42.81,42.81,0,0,1-15.73-3,41.86,41.86,0,0,1-4.2-1.91,43.07,43.07,0,0,1-20.71-24.09,38.65,38.65,0,0,1-1.29-4.54c-.27-1.18-.48-2.38-.65-3.59a44,44,0,0,1-.4-5.88,42.7,42.7,0,0,1,1.87-12.56c.24-.82.52-1.63.82-2.44a43,43,0,0,1,75.79-9.23h0A42.75,42.75,0,0,1,556,303.92Z" transform="translate(-208.1 -44)" fill="#eeeff0"/><ellipse cx="344.55" cy="211.56" rx="57.09" ry="79.25" fill="#c1afd5"/><ellipse cx="344.55" cy="211.56" rx="57.09" ry="79.25" opacity="0.1"/><path d="M650,64.82a119.55,119.55,0,0,0-90.65,197.49c2.31,2.7,4.75,5.29,7.3,7.73a119.17,119.17,0,0,0,48.25,28.64c3,.93,6.1,1.75,9.21,2.42a120.15,120.15,0,0,0,48.35.7c3.18-.59,6.34-1.32,9.43-2.19a119.09,119.09,0,0,0,50.19-28.34q4.15-3.91,7.91-8.21A119.54,119.54,0,0,0,650,64.82Zm0,22.84a8.06,8.06,0,1,1,8.06-8.06A8.06,8.06,0,0,1,650,87.66Z" transform="translate(-208.1 -44)" fill="#c1afd5"/><ellipse cx="549.39" cy="229.03" rx="40.3" ry="61.79" fill="#b3b0a9"/><ellipse cx="549.39" cy="229.03" rx="21.49" ry="32.95" opacity="0.1"/><ellipse cx="441.93" cy="435.89" rx="139.7" ry="154.47" fill="#b3b0a9"/><ellipse cx="441.93" cy="435.89" rx="139.7" ry="154.47" opacity="0.1"/><ellipse cx="334.47" cy="229.03" rx="40.3" ry="61.79" fill="#b3b0a9"/><ellipse cx="334.47" cy="229.03" rx="21.49" ry="32.95" opacity="0.1"/><polygon points="350.52 217.98 351.92 67.83 343.23 210.25 350.52 217.98" opacity="0.1"/><path d="M617.78,111.83,616.09,293c-3.11-.67-6.19-1.49-9.21-2.42Z" transform="translate(-208.1 -44)" opacity="0.1"/><path d="M675.54,111.83l-1.67,179.72c-3.09.87-6.25,1.6-9.43,2.19Z" transform="translate(-208.1 -44)" opacity="0.1"/><polygon points="523.87 211 525.2 67.83 515.96 219.21 523.87 211" opacity="0.1"/><rect x="322.38" y="137.68" width="239.1" height="77.91" rx="12" opacity="0.1"/><path d="M760.18,294.52a110,110,0,1,1-4.07-29.77A110.15,110.15,0,0,1,760.18,294.52Z" transform="translate(-208.1 -44)" fill="#b3b0a9"/><path d="M756.11,264.75a16.4,16.4,0,0,1-2.64.22H546.61a16.53,16.53,0,0,1-2.65-.22,110.27,110.27,0,0,1,81.83-77.69h48.49A110.27,110.27,0,0,1,756.11,264.75Z" transform="translate(-208.1 -44)" opacity="0.1"/><rect x="322.38" y="140.37" width="239.1" height="77.91" rx="16.12" fill="#eeeff0"/><polygon points="348.8 210.22 351.92 159.18 351.45 210.22 348.8 210.22" opacity="0.1"/><polygon points="409.21 210.22 409.68 159.18 406.56 210.22 409.21 210.22" opacity="0.1"/><polygon points="467.44 159.18 466.96 210.22 464.32 210.22 467.44 159.18" opacity="0.1"/><polygon points="522.08 210.22 525.2 159.18 524.73 210.22 522.08 210.22" opacity="0.1"/><circle cx="400.29" cy="237.09" r="14.78" opacity="0.1"/><circle cx="400.29" cy="235.74" r="14.78" fill="#eeeff0"/><circle cx="400.29" cy="235.74" r="6.72" fill="#373e46"/><circle cx="401.63" cy="233.06" r="1.34" fill="#fff"/><circle cx="488.95" cy="237.09" r="14.78" opacity="0.1"/><circle cx="488.95" cy="235.74" r="14.78" fill="#eeeff0"/><circle cx="488.95" cy="235.74" r="6.72" fill="#373e46"/><circle cx="486.26" cy="233.06" r="1.34" fill="#fff"/><circle cx="444.62" cy="281.41" r="44.33" opacity="0.1"/><circle cx="444.62" cy="278.73" r="44.33" fill="#361f5c"/><polygon points="783.12 355.29 777.01 486.53 774.54 539.56 765.66 730.06 236.41 812 236.41 421.11 783.12 355.29" fill="#373e46"/><polygon points="0.67 280.74 102.66 267.21 317.68 382.83 239.77 421.78 0.67 280.74" fill="#373e46"/><polygon points="0.67 280.74 102.66 267.21 317.68 382.83 239.77 421.78 0.67 280.74" opacity="0.05"/><path d="M449.82,358.59l-13.54-7.25a3,3,0,0,0-3.46.48l-11.07,10.63a3,3,0,0,1-5-2.66l2.71-15.11a3,3,0,0,0-1.52-3.14l-13.54-7.25a3,3,0,0,1,1-5.56l15.21-2.09a3,3,0,0,0,2.52-2.42l2.7-15.11a3,3,0,0,1,5.6-.77l6.69,13.82a3,3,0,0,0,3.08,1.64l15.2-2.09a3,3,0,0,1,2.47,5.08l-11.08,10.63a3,3,0,0,0-.61,3.44l6.69,13.82A3,3,0,0,1,449.82,358.59Z" transform="translate(-208.1 -44)" opacity="0.1"/><path d="M447.81,355.79l-12-6.42a2.64,2.64,0,0,0-3.07.42l-9.82,9.43a2.63,2.63,0,0,1-4.41-2.36l2.4-13.4a2.63,2.63,0,0,0-1.35-2.79l-12-6.42a2.63,2.63,0,0,1,.88-4.93l13.49-1.86a2.63,2.63,0,0,0,2.23-2.14l2.4-13.41a2.63,2.63,0,0,1,5-.68l5.94,12.25a2.62,2.62,0,0,0,2.73,1.46l13.48-1.85a2.63,2.63,0,0,1,2.19,4.5L446,337a2.61,2.61,0,0,0-.55,3l5.94,12.26A2.63,2.63,0,0,1,447.81,355.79Z" transform="translate(-208.1 -44)" fill="#eeeff0"/><path d="M948.12,744.08l-8.36-4.48a1.83,1.83,0,0,0-2.14.29l-6.85,6.58a1.83,1.83,0,0,1-3.07-1.65l1.67-9.34a1.83,1.83,0,0,0-.94-1.94l-8.37-4.48a1.84,1.84,0,0,1,.62-3.44l9.4-1.29a1.85,1.85,0,0,0,1.56-1.5l1.67-9.34a1.84,1.84,0,0,1,3.46-.48l4.13,8.55a1.85,1.85,0,0,0,1.91,1l9.4-1.29a1.83,1.83,0,0,1,1.52,3.14L946.89,731a1.85,1.85,0,0,0-.39,2.13l4.14,8.54A1.84,1.84,0,0,1,948.12,744.08Z" transform="translate(-208.1 -44)" opacity="0.1"/><path d="M946.89,742.35l-7.43-4a1.62,1.62,0,0,0-1.89.26l-6.07,5.83a1.63,1.63,0,0,1-2.73-1.46l1.48-8.29a1.62,1.62,0,0,0-.83-1.72L922,729a1.63,1.63,0,0,1,.55-3l8.33-1.15a1.61,1.61,0,0,0,1.38-1.32l1.49-8.29a1.63,1.63,0,0,1,3.07-.42l3.66,7.58a1.63,1.63,0,0,0,1.69.9l8.34-1.15a1.63,1.63,0,0,1,1.35,2.79l-6.07,5.83a1.62,1.62,0,0,0-.34,1.88l3.67,7.58A1.62,1.62,0,0,1,946.89,742.35Z" transform="translate(-208.1 -44)" fill="#31a"/><path d="M511.56,543.93l-8.36-4.48a1.85,1.85,0,0,0-2.14.3l-6.85,6.57a1.83,1.83,0,0,1-3.07-1.65l1.67-9.34a1.84,1.84,0,0,0-.94-1.94l-8.37-4.48a1.83,1.83,0,0,1,.62-3.43l9.4-1.3a1.84,1.84,0,0,0,1.56-1.49l1.67-9.35a1.84,1.84,0,0,1,3.46-.47l4.14,8.54a1.82,1.82,0,0,0,1.9,1l9.4-1.3a1.84,1.84,0,0,1,1.52,3.15l-6.84,6.57A1.82,1.82,0,0,0,510,533l4.13,8.54A1.84,1.84,0,0,1,511.56,543.93Z" transform="translate(-208.1 -44)" opacity="0.1"/><path d="M510.33,542.21l-7.42-4a1.65,1.65,0,0,0-1.9.26l-6.07,5.83a1.63,1.63,0,0,1-2.73-1.46l1.48-8.28a1.61,1.61,0,0,0-.83-1.72l-7.42-4a1.62,1.62,0,0,1,.55-3l8.33-1.15a1.62,1.62,0,0,0,1.38-1.33l1.49-8.28a1.63,1.63,0,0,1,3.07-.42l3.66,7.57a1.62,1.62,0,0,0,1.69.9L514,522a1.62,1.62,0,0,1,1.35,2.78l-6.07,5.83a1.63,1.63,0,0,0-.34,1.89l3.67,7.57A1.63,1.63,0,0,1,510.33,542.21Z" transform="translate(-208.1 -44)" fill="#f00"/><path d="M948.12,664.83l-8.36-4.48a1.83,1.83,0,0,0-2.14.29l-6.85,6.57a1.83,1.83,0,0,1-3.07-1.64l1.67-9.34a1.85,1.85,0,0,0-.94-2l-8.37-4.47a1.84,1.84,0,0,1,.62-3.44l9.4-1.3a1.83,1.83,0,0,0,1.56-1.49l1.67-9.34a1.84,1.84,0,0,1,3.46-.48l4.13,8.54a1.84,1.84,0,0,0,1.91,1l9.4-1.29a1.83,1.83,0,0,1,1.52,3.14l-6.84,6.57a1.85,1.85,0,0,0-.39,2.13l4.14,8.54A1.84,1.84,0,0,1,948.12,664.83Z" transform="translate(-208.1 -44)" opacity="0.1"/><path d="M946.89,663.1l-7.43-4a1.61,1.61,0,0,0-1.89.26l-6.07,5.83a1.63,1.63,0,0,1-2.73-1.46l1.48-8.29a1.62,1.62,0,0,0-.83-1.72l-7.42-4a1.63,1.63,0,0,1,.55-3l8.33-1.15a1.61,1.61,0,0,0,1.38-1.32l1.49-8.29a1.63,1.63,0,0,1,3.07-.42l3.66,7.57a1.64,1.64,0,0,0,1.69.91l8.34-1.15a1.63,1.63,0,0,1,1.35,2.79l-6.07,5.83a1.61,1.61,0,0,0-.34,1.88l3.67,7.57A1.63,1.63,0,0,1,946.89,663.1Z" transform="translate(-208.1 -44)" fill="#ff0"/><ellipse cx="371.41" cy="421.78" rx="27.54" ry="45" fill="#b3b0a9"/><ellipse cx="523.2" cy="405.66" rx="27.54" ry="45" fill="#b3b0a9"/><polygon points="777.01 486.53 774.54 539.56 236.41 594.89 0.67 487.51 0.67 435.89 236.41 538.79 777.01 486.53" fill="#c1afd5"/><polygon points="236.41 538.79 236.41 594.89 0.67 487.51 0.67 435.89 236.41 538.79" opacity="0.1"/></svg>
      </div>
    </div>
  </body>
  <script src="js/autocomplete.js" type="text/javascript"></script>
  <script src="js/reserve.js" type="text/javascript"></script>
</html>