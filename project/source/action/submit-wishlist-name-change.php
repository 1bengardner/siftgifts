<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$short_name = $_POST['id'];

$stmt = "UPDATE wishlist SET name = ? WHERE short_name = ? AND owner = ?";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $short_name, $_SESSION['id']]);

$stmt = "SELECT name FROM wishlist WHERE short_name = ? AND owner = ?";
$new_name = Database::run_statement(Database::get_connection(), $stmt, [$short_name, $_SESSION['id']])->fetch_row()[0];

http_response_code(200);
echo $new_name;
?>