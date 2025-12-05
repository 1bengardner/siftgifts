<?php
require_once '../action/xmas-authenticate.php';
require_once '../util/utilities.php';

$stmt = "SELECT xmas_was_drawn(?)";
return Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['xmas']])->fetch_row()[0] === 1;
?>