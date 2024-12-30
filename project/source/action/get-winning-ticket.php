<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "CALL get_winning_ticket(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_NUM);
if (!$res) {
  return ["🚫", "🚫", "🚫", "🚫", "🚫", "🚫", "🚫"];
}
$ticket_numbers = $res[0];
array_shift($ticket_numbers); // strip ID
array_pop($ticket_numbers); // strip draw time
return $ticket_numbers;
?>