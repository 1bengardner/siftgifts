<nav class="header">
  <div>
    <h1 class="logo-text inline-block">Sift<span class="accent"> . gifts</span></h1>
    <?php
    if (session_status() === PHP_SESSION_NONE)
      session_start();

    if (isset($_SESSION["id"])) {
      echo '<span class="success-box">'.User::get_from_id($_SESSION['id'])->email.'</span>';
      echo '<a href="logout">Log out</a>';
    } else {
      echo '<p class="inline-block">local</p>';
    }
    ?>
  </div>
</nav>