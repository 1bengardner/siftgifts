<nav class="header">
  <div>
    <a href="/"><h1 class="logo-text inline-block">Sift<span class="accent"> . gifts</span></h1></a>
    <span class="unbreakable">
      <?php
      require_once '../data/user.php';
      if (session_status() === PHP_SESSION_NONE)
        session_start();

      if (isset($_SESSION["id"])) {
        echo '<span class="special-box">'.ucfirst(User::get_from_id($_SESSION['id'])->username).'</span>';
        echo '<a href="logout">Log out</a>';
      }
      ?>
    </span>
  </div>
</nav>