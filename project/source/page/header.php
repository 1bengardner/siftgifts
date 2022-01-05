<nav class="header">
  <div>
    <a href="/"><h1 class="logo-text inline-block">Sift<span class="accent"> . gifts</span></h1></a>
    <?php
    require_once '../data/user.php';
    if (session_status() === PHP_SESSION_NONE)
      session_start();

    if (isset($_SESSION["id"])) {
      echo '<span class="info-box">'.User::get_from_id($_SESSION['id'])->email.'</span>';
      echo '<a href="logout">Log out</a>';
    }
    ?>
  </div>
</nav>