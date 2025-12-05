<?php
require_once '../action/xmas-authenticate.php';
require_once '../util/utilities.php';

$stmt = "CALL xmas_get_lottery_ticket(?)";
$res = Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['xmas']])->fetch_all(MYSQLI_NUM);
if (!$res) {
  ob_start();
  $res = include 'xmas-issue-lottery-ticket.php';
  ob_end_clean();
  return $res;
}
$ticket_numbers = $res[0];
array_shift($ticket_numbers); // strip ID
array_pop($ticket_numbers); // strip status
return $ticket_numbers;
?>