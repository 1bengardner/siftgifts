<?php
require_once '../util/utilities.php';
require_once '../action/authenticate.php';

$uuid = $_GET["uuid"];
$stmt = "SELECT * FROM wishlist WHERE uuid = ?";
$wishlist = Database::run_statement(Database::get_connection(), $stmt, [$uuid])->fetch_assoc();
if (is_null($wishlist)) {
  http_response_code(404);
  // TODO Change "not found" page to reflect that this is an administrative page
  include "../page/wishlist-not-found.php";
  exit;
} else if ($wishlist["owner"] !== $_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NoPermission, NotificationLevel::Error)];
  header("Location: /private-wishlists");
  exit;
}
include "../page/wishlist-private.php";
?>