<?php
require_once '../data/user.php';
require_once '../action/start-session.php';
?>
<div class="user-buttons center">
  <ul class="user-header-buttons-small unbreakable">
    <?php $user = User::get_from_id($_SESSION['id']); ?>
    <li class="username-box"><a class="link" href="/home"><?php echo ucwords(strtolower($user->username)); ?></a></li>
    <?php
      $message_count = include '../action/return-unread-count.php';
      if ($message_count) {
        $message_li = '<li class="check-messages"><a href="/messaging" title="Check messages">📫</a><span class="notification-dot">'.$message_count.'</span></li>';
      } else {
        $message_li = '<li class="check-messages"><a href="/messaging" title="Check messages">📪</a></li>';
      }
      echo $message_li;
    ?><?php
      if (in_array($user->id, [1, 2])) {
        echo '<li><a href="/travel-fund" title="Travel fund">🫙</a></li>';
      }
      if (include '../action/is-admin.php') {
        echo '<li><a href="/lottery-admin" title="Lottery admin">🎰</a></li>';
      }
    ?><li><a href="/settings" title="Change settings">👤</a></li>
    <li><a href="/logout" title="Log out">🚪</a></li>
  </ul>
  <div>
    <ul class="user-header-buttons-large">
      <li class="username-box"><a class="link" href="/home"><?php echo ucwords(strtolower(User::get_from_id($_SESSION['id'])->username)) ?></a></li>
      <?php echo $message_li; ?>
    </ul>
    <ul class="wishlist-header-buttons">
      <li class="wishlist-header-label"><a class="link" href="/wishlist">Wishlist</a></li>
      <li><a href="/wishlist" title="Edit wishlist">📜</a></li>
      <li><a href="/add" title="Add to wishlist">➕</a></li>
    </ul>
    <ul class="user-header-buttons-large"><?php
        if (in_array($user->id, [1, 2])) {
          echo '<li><a href="/travel-fund" title="Travel fund">🫙</a></li>';
        }
        if (include '../action/is-admin.php') {
          echo '<li><a href="/lottery-admin" title="Lottery admin">🎰</a></li>';
        }
      ?><li><a href="/settings" title="Change settings">👤</a></li>
      <li><a href="/logout" title="Log out">🚪</a></li>
    </ul>
  </div>
</div>