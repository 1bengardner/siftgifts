<?php
// NOTE: If unwanted reserving becomes an issue, change id to GUID or something unguessable
require_once '../util/utilities.php';
require_once 'start-session.php';

$stmt = "UPDATE gift SET reserved=1, reserved_time=CURRENT_TIMESTAMP, reserver=? WHERE id=?";
Database::run_statement(Database::get_connection(), $stmt, [$_SESSION["id"], $_POST["id"]]);
?>