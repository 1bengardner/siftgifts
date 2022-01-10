<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';
require_once '../action/start-session.php';

$gift = Gift::get_from_id($_POST["id"]);
if ($gift->belongs_to_user($_SESSION["id"])) {
  $stmt = "UPDATE gift SET active=0 WHERE id=?";
  $user_id = Database::run_statement(Database::get_connection(), $stmt, [$_POST["id"]]);
}
?>