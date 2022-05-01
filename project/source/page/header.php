<?php
require_once '../action/start-session.php';
if (isset($_SESSION["id"])) {
?>
<nav class="header">
  <div class="nav-grid">
    <h1 class="logo-text unbreakable"><a class="link" href="/" title="Home">Sift<span class="accent"><span class="spaced">.</span>gifts</span></a></h1>
    <?php include 'user-buttons.php'; ?>
  </div>
</nav>
<?php } else { include 'header-with-login.php'; } ?>