<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "SELECT was_drawn(?)";
return Database::run_statement(Database::get_connection(), $stmt, [$_SESSION['id']])->fetch_row()[0] === 1;
?>