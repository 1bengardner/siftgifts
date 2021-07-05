<?php
    require_once '../util/utilities.php';

    // Validate required field presence
    $required_fields = ['email', 'password'];

    foreach (Validation::get_missing_keys($required_fields) as $field) {
        echo $field . ' cannot be empty';
        return;
    }

    if ($res = Validation::email_error($_POST['email'])) {
        echo $res;
        return;
    }

    // Validate password length
    if (strlen($_POST['password']) > 255) {
        echo 'password must be under 255 characters';
        return;
    }

    if (!Validation::verify_user($_POST['email'], $_POST['password'])) {
        echo 'incorrect email or password';
        return;
    }

    $stmt = "SELECT id FROM user WHERE email = ?";
    $user_id = Database::run_statement($stmt, [$_POST['email']]);
    $id = $user_id->fetch_assoc()['id'];

    session_start();
    $_SESSION["id"] = $id;

    header('Location: ../page/restaurants.php');
?>