<?php
require_once '../data/user.php';
require_once '../util/utilities.php';
require_once 'start-session.php';

if (isset($_GET['u']) && $_GET['u']) {
  if (($user = User::get_from_name(trim($_GET['u']))) && isset($user->username)) {
    header('Location: /sg/'.strtolower($user->username));
  } else {
    $_SESSION["notifications"] = [new Notification(NotificationText::WishlistNotFound, NotificationLevel::Info)];
  }
}
?>