<?php
    require_once '../util/utilities.php';
    session_start();

    // Validate required field presence
    $required_fields = ['name', 'email', 'password', 'confirm-password'];
    $validation_errors = [];

    if ($msg = Validation::keys_missing($required_fields)) {
        array_push($validation_errors, $msg);
    }

    if ($msg = Validation::email_registration_error($_POST['email'])) {
        array_push($validation_errors, $msg);
    }

    // Verify password and confirm are the same
    if ($msg = Validation::passwords_differ($_POST['password'], $_POST['confirm-password'])) {
        array_push($validation_errors, $msg);
    }
    // Validate password length
    if ($msg = Validation::password_error($_POST['password'])) {
        array_push($validation_errors, $msg);
    }

    // Validate name length
    if ($msg = Validation::name_error($_POST['name'])) {
        array_push($validation_errors, $msg);
    }


    if (count($validation_errors) > 0) {
        $_SESSION["messages"] = $validation_errors;
        header('Location: ../page/registration.php');
        exit;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Add user to db
    $stmt = "INSERT INTO user(name, email, encrypted_password) VALUES (?, ?, ?)";
    Database::run_statement($stmt, [$name, $email, $password]);

    header('Location: ../page/login.php');
?>