<?php
require_once '../util/utilities.php';
session_start();

// Validate required field presence
$required_fields = ['email', 'password'];
$validation_errors = [];

if ($msg = Validation::keys_missing($required_fields)) {
    array_push($validation_errors, $msg);
}

if ($msg = Validation::email_login_error($_POST['email'])) {
    array_push($validation_errors, $msg);
}

// Validate password length
if ($msg = Validation::password_error($_POST['password'])) {
    array_push($validation_errors, $msg);
}

if (count($validation_errors) === 0 && $msg = Validation::login_error($_POST['email'], $_POST['password'])) {
    array_push($validation_errors, $msg);
}


if (count($validation_errors) > 0) {
    $_SESSION["messages"] = $validation_errors;
    header('Location: ../page/login.php');
    exit;
}

$stmt = "SELECT id FROM user WHERE email = ?";
$user_id = Database::run_statement(Database::get_connection(), $stmt, [$_POST['email']]);
$id = $user_id->fetch_assoc()['id'];

$_SESSION["id"] = $id;

header('Location: ../page/restaurants.php');
?>