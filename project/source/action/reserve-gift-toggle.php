<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';
require_once 'start-session.php';

$gift = Gift::get_from_id($_POST["id"]);
if ($gift->belongs_to_user($_SESSION["id"])) {
  $reserved = 1 - $gift->reserved;
  if ($reserved) {
    $stmt = "UPDATE gift SET reserved=?, reserved_time=CURRENT_TIMESTAMP WHERE id=?";
  } else {
    $stmt = "UPDATE gift SET reserved=?, reserved_time=NULL WHERE id=?";    
  }
  Database::run_statement(Database::get_connection(), $stmt, [$reserved, $_POST["id"]]);
  header("HTTP/1.1 200 OK");
  echo $reserved; // new reservation status
}
?>