<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT get_message(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['id']])->fetch_row()[0];
header("HTTP/1.1 200 OK");
echo nl2br(htmlentities($res));
?>