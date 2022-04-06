<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "CALL get_messages(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_GET['id']])->fetch_all(MYSQLI_ASSOC);
header("HTTP/1.1 200 OK");
echo json_encode(array_map(function($message) { return nl2br(htmlentities($message['body'])); }, $res));
?>