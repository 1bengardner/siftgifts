<?php
require_once '../action/login-check.php';
require_once '../util/utilities.php';

// TODO: Validate fields

$stmt = "CALL add_restaurant(?, ?, ?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['cuisine'], $_POST['location'], $_POST['url'], file_get_contents($_FILES['image']['tmp_name']), $_SESSION['id']]);

header('Location: ../page/restaurants')
?>