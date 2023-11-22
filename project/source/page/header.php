<?php
require_once '../action/start-session.php';
if (isset($_SESSION["id"])) {
?>
<nav class="header">
  <div class="nav-grid">
    <h1 class="logo-text unbreakable"><a class="link" href="/" title="Home"><img class="logo-image" src="/page/img/present.png" width="32px" alt="" />Sift<span class="spaced">.</span>gifts</a></h1>
    <?php include 'user-buttons.php'; ?>
  </div>
</nav>
<?php } else { include 'header-with-login.php'; } ?>