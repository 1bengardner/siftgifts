<?php
require_once '../data/user.php';
require_once '../action/start-session.php';
?>
<div class="user-buttons center">
  <ul class="user-header-buttons-small">
    <li class="purple-box username-box"><a class="link" href="/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></li>
    <?php
    $message_count = include '../action/check-new-messages.php';
    if ($message_count) {
      $message_li = '<li><a href="/messaging" title="Check messages">📫</a><span class="notification-dot">'.$message_count.'</span></li>';
    } else {
      $message_li = '<li><a href="/messaging" title="Check messages">📪</a></li>';
    }
    echo $message_li;
    ?>
    <li><a href="/settings" title="Change settings">👤</a></li>
    <li><a href="/logout" title="Log out">🚪</a></li>
  </ul>
  <div>
    <ul class="user-header-buttons-large">
      <li class="purple-box username-box"><a class="link" href="/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></li>
      <?php echo $message_li; ?>
    </ul>
    <ul class="wishlist-header-buttons">
      <li class="wishlist-header-label"><a class="link" href="/wishlist">Wishlist</a></li>
      <li><a href="/wishlist" title="Edit wishlist">📜</a></li>
      <li><a href="/request" title="Add to wishlist">➕</a></li>
    </ul>
    <ul class="user-header-buttons-large">
      <li><a href="/settings" title="Change settings">👤</a></li>
      <li><a href="/logout" title="Log out">🚪</a></li>
    </ul>
  </div>
</div>