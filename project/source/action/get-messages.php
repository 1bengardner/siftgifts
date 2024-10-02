<?php
require_once '../util/utilities.php';
require_once '../data/user-message.php';
require_once 'authenticate.php';

$stmt = "CALL read_messages(?, ?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id'], $_GET['from']])->fetch_all(MYSQLI_ASSOC);
header("HTTP/1.1 200 OK");
echo json_encode(array_map(function($message) {
  $msg = new UserMessage($message);
  return [
    'is_sender' => $msg->from === $_SESSION['id'],
    'message' => nl2br(htmlentities($msg->body)),
    'sent_time' => $msg->sent_time,
    'unread' => $msg->unread];
}, $res));
?>