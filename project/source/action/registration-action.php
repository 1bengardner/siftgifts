<?php
    require_once '../util/utilities.php';

    // Validate required field presence
    $required_fields = ['name', 'email', 'password', 'confirm-password'];

    foreach (Validation::get_missing_keys($required_fields) as $field) {
        echo $field . ' cannot be empty';
    }

    if ($res = Validation::email_error($_POST['email'])) {
        echo $res;
    }

    // Verify password and confirm are the same
    if ($_POST['password'] != $_POST['confirm-password']) {
        echo 'password and confirm not the same';
    }
    // Validate password length
    if (strlen($_POST['password']) > 255) {
        echo 'password must be under 255 characters';
    }

    // Validate name length
    if (strlen($_POST['name']) > 255) {
        echo 'full name must be under 255 characters';
    }

    // Verify email does not exist already
    if (Validation::email_exists($_POST['email'])) {
        echo 'email already exists';
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Add user to db
    $stmt = "INSERT INTO user(name, email, encrypted_password) VALUES (?, ?, ?)";
    Database::run_statement($stmt, [$name, $email, $password]);
?>