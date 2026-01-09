<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT uuid FROM wishlist WHERE owner=?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_object();
if (is_null($res)) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPrivateWishlist, NotificationLevel::Error)];
  include '../page/notification-box.php';
  exit;
}

// TODO: Validate fields

$stmt = "CALL add_private_gift(?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], $_POST['comments'], $_SESSION['id']]);
$_SESSION["notifications"] = [new Notification(NotificationText::AddSuccess, NotificationLevel::Success)];
include '../page/notification-box.php';
?>