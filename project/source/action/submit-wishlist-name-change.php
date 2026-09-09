<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "UPDATE wishlist SET name = ? WHERE id = ? AND owner = ?";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['id'], $_SESSION['id']]);

$stmt = "SELECT name FROM wishlist WHERE id = ? AND owner = ?";
$new_title = Database::run_statement(Database::get_connection(), $stmt, [$_POST['id'], $_SESSION['id']])->fetch_row()[0];

http_response_code(200);
echo $new_title;
?>