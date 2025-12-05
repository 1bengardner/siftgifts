<?php
require_once '../action/xmas-authenticate.php';
require_once '../util/utilities.php';

$stmt = "SELECT xmas_time_to_draw(?)";
$seconds = strtotime(Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['xmas']])->fetch_row()[0]) - time();
$hours = (int)($seconds / 60 / 60);
$minutes = (int)($seconds / 60 - $hours * 60);
$seconds = (int)($seconds % 60);
return implode(":", [$hours, $minutes, $seconds]);
?>