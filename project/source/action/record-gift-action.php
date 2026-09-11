<?php
require_once '../util/utilities.php';

function recordGiftReservation($what, $got_reserved, $who) {
  $stmt = "INSERT INTO gift_audit(gift, reserve, user, connecting_ip, forwarding_ips) VALUES (?, ?, ?, ?, ?)";
  Database::run_statement(Database::get_connection(), $stmt, [
    $what,
    $got_reserved ? 1 : 0,
    $who,
    empty($_SERVER['REMOTE_ADDR']) ? null : $_SERVER['REMOTE_ADDR'],
    empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? null : $_SERVER['HTTP_X_FORWARDED_FOR'],
  ]);
}
?>