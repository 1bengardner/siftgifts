<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "CALL get_lottery_ticket(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_NUM);
return $res ? TRUE : FALSE;
?>