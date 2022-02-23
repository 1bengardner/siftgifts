<?php
require_once '../util/utilities.php';

// NOTE: If unwanted reserving becomes an issue, change id to GUID or something unguessable

$stmt = "UPDATE gift SET reserved=1, reserved_time=CURRENT_TIMESTAMP WHERE id=?";
Database::run_statement(Database::get_connection(), $stmt, [$_POST["id"]]);
?>