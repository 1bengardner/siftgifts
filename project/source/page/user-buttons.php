<?php
require_once '../data/user.php';
require_once '../action/start-session.php';
?>
<ul class="user-buttons center">
  <div class="user-header-buttons">
    <li class="purple-box username-box"><a class="link" href="../page/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></li>
    <li><a href="/page/settings" title="Change settings">👤</a></li>
    <li><a href="/page/logout" title="Log out">🚪</a></li>
  </div>
  <div>
    <span class="user-header-buttons-large">
      <li class="purple-box username-box"><a class="link" href="../page/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></li>
    </span>
    <span class="wishlist-header-buttons">
      <li><a class="link" href="/page/wishlist">Wishlist</a></li>
      <li><a href="/page/wishlist" title="Edit wishlist">📝</a></li>
      <li><a href="/page/request" title="Add to wishlist">➕</a></li>
    </span>
    <span class="user-header-buttons-large">
      <li><a href="/page/settings" title="Change settings">👤</a></li>
      <li><a href="/page/logout" title="Log out">🚪</a></li>
    </span>
  </div>
</ul>