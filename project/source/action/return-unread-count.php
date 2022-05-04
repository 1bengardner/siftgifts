<?php
require_once 'authenticate.php';
require_once '../util/utilities.php';

$stmt = "SELECT SUM(unread) FROM message WHERE `to`=?";
return Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_row()[0];
?>