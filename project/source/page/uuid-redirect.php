<?php
require_once '../util/utilities.php';

$uuid = $_GET["uuid"];
$stmt = "SELECT * FROM wishlist WHERE uuid = ?";
$wishlist = Database::run_statement(Database::get_connection(), $stmt, [$uuid])->fetch_assoc();
if (is_null($wishlist)) {
  http_response_code(404);
  include "../page/wishlist-not-found.php";
  exit;
}
include "../page/uuid-template.php";
?>