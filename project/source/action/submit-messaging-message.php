<?php
require_once '../action/authenticate.php';
require_once '../util/utilities.php';
require_once '../data/user.php';

$stmt = "INSERT INTO message(`to`, `from`, body) VALUES (?, ?, ?)";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$_POST['to'], $_SESSION['id'], $_POST['message']]);
$_SESSION['last_message_to'] = $_POST['to'];
?>