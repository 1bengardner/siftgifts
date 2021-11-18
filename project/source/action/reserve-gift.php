<?php
require_once '../util/utilities.php';

// TODO: Validate fields

$stmt = "UPDATE gift SET reserved=1 WHERE id=?";
$user_id = Database::run_statement(Database::get_connection(), $stmt, [$_POST["id"]]);
?>