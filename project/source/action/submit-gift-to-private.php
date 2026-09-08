<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT * FROM wishlist WHERE short_name = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_POST["wishlist"]])->fetch_assoc();
if (is_null($res)) {
  $_SESSION["notifications"] = [new Notification(NotificationText::WishlistDoesNotExist, NotificationLevel::Error)];
  include '../page/notification-box.php';
  exit;
}
require_once '../data/wishlist.php';
$wishlist = new Wishlist($res);
if ($wishlist->owner !== $_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoWishlistAccess, NotificationLevel::Error)];
  include '../page/notification-box.php';
  exit;
}

// TODO: Validate fields

$stmt = "CALL add_private_gift(?, ?, ?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], strlen($_POST['price']) === 0 ? null : $_POST['price'], $_POST['comments'], $_SESSION['id'], $wishlist->id]);
$_SESSION["notifications"] = [new Notification(NotificationText::AddSuccess, NotificationLevel::Success)];
include '../page/notification-box.php';
?>