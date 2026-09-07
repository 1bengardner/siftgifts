<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

$stmt = "SELECT * FROM wishlist WHERE short_name = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET["alias"]])->fetch_assoc();
if (is_null($res)) {
  http_response_code(404);
  // TODO Change "not found" page to reflect that this is an administrative page
  include "../page/wishlist-not-found.php";
  exit;
}
require_once '../data/wishlist.php';
$wishlist = new Wishlist($res);
if ($wishlist->owner !== $_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /private-wishlists");
  exit;
}
include "../page/wishlist-private.php";
?>