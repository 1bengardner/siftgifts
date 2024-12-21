<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "CALL get_lottery_ticket(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_all(MYSQLI_NUM);
if (!$res) {
  ob_start();
  include 'issue-lottery-ticket.php';
  ob_end_clean();
  return include 'get-lottery-ticket.php';
}
$ticket_numbers = $res[0];
array_shift($ticket_numbers); // strip ID
array_pop($ticket_numbers); // strip status
return $ticket_numbers;
?>