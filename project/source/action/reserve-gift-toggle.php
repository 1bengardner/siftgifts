<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';
session_start();

$gift = Gift::get_from_id($_POST["id"]);
if ($gift->belongs_to_user($_SESSION["id"])) {
  $stmt = "UPDATE gift SET reserved=? WHERE id=?";
  Database::run_statement(Database::get_connection(), $stmt, [1 - $gift->reserved, $_POST["id"]]);
  header("HTTP/1.1 200 OK");
  echo 1 - $gift->reserved; // new reservation status
}
?>