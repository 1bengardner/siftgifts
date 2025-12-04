<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT time_to_draw(?)";
$seconds = strtotime(Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_row()[0]) - time();
$hours = (int)($seconds / 60 / 60);
$minutes = (int)($seconds / 60 - $hours * 60);
$seconds = (int)($seconds % 60);
return implode(":", [$hours, $minutes, $seconds]);
?>