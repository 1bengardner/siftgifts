<?php
require_once '../data/user.php';
require_once '../action/start-session.php';
?>
<ul class="unbreakable center">
  <li><span class="purple-box"><a class="link" href="../page/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></span></li>
  <li><a href="/page/wishlist" title="Edit wishlist">Your wishlist 📜</a></li>
  <li><a href="/page/settings" title="Change settings">👤</a></li>
  <li><a href="/page/logout" title="Log out">🚪</a></li>
</ul>