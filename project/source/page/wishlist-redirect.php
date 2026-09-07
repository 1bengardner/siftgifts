<?php
function respondWithWishlistNotFound() {
  http_response_code(404);
  include "../page/wishlist-not-found.php";
  exit;
}

if (isset($_GET["sg"])) {
  require_once '../data/user.php';
  $user = User::get_from_name($_GET["sg"]);
  if (is_null($user)) {
    respondWithWishlistNotFound();
  }
  $id = $user->id;
  include "../page/wishlist-template.php";
  exit;
}
require_once '../util/utilities.php';
$stmt = "SELECT * FROM wishlist WHERE short_name = ?";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET["alias"]])->fetch_assoc();
if (is_null($res)) {
  respondWithWishlistNotFound();
}
require_once '../data/wishlist.php';
$wishlist = new Wishlist($res);
include "../page/uuid-template.php";
?>