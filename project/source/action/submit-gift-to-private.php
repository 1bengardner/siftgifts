<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT 1 FROM wishlist WHERE owner=? AND uuid=?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id'], $_POST['uuid']])->fetch_object();
if (is_null($res)) {
  $_SESSION["notifications"] = [new Notification(NotificationText::BadPrivateWishlist, NotificationLevel::Error)];
  include '../page/notification-box.php';
  exit;
}

// TODO: Validate fields

$stmt = "CALL add_private_gift(?, ?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], $_POST['comments'], $_SESSION['id'], $_POST['uuid']]);
$_SESSION["notifications"] = [new Notification(NotificationText::AddSuccess, NotificationLevel::Success)];
include '../page/notification-box.php';
?>