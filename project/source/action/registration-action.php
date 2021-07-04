<?php
    // Validate required field presence
    $required_fields = ['name', 'email', 'password', 'confirm-password'];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo $field . ' cannot be empty';
        }
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo 'invalid email';
    }
    // Validate email length
    if (strlen($_POST['email']) > 320) {
        echo 'email must be under 320 characters';
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

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Add user to db
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $mysqli = new mysqli("miniproject", "root", "", "restaurant_review_data");
    $stmt_add_user = $mysqli->prepare("INSERT INTO user(name, email, encrypted_password) VALUES (?, ?, ?)");
    $stmt_add_user->bind_param("sss", $name, $email, $password);
    $stmt_add_user->execute();
?>