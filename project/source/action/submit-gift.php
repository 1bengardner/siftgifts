<?php
require_once '../util/utilities.php';

// TODO: Validate fields

$stmt = "CALL add_gift(?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], $_POST['comments']]);
?>