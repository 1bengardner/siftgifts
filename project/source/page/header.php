<nav class="header">
  <div class="grid-2 center">
    <h1 class="logo-text unbreakable"><a class="link" href="/" title="Home">Sift<span class="accent"> . gifts</span></a></h1>
    <ul class="unbreakable right">
      <?php
      require_once '../data/user.php';
      if (session_status() === PHP_SESSION_NONE)
        session_start();

      if (isset($_SESSION["id"])) {
        echo '<li><span class="special-box"><a class="link" href="../page/home">'.ucfirst(strtolower(User::get_from_id($_SESSION['id'])->username)).'</a></span></li>';
        echo '<li><a href="../page/change-password" title="Change password">🔑</a></li>';
        echo '<li><a href="../page/logout" title="Log out">🚪</a></li>';
      }
      ?>
    </span>
  </div>
</nav>