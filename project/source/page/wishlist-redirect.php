<?php
require_once '../data/user.php';

$user = User::get_from_name($_GET["sg"]);
if (is_null($user)) {
  http_response_code(404);
  include "../page/wishlist-not-found.php";
  exit;
}
$id = $user->id;
include "../page/wishlist-template.php";
?>