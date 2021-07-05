<?php
    require_once '../util/utilities.php';

    // Validate required field presence
    $required_fields = ['email', 'password'];

    foreach (Validation::get_missing_keys($required_fields) as $field) {
        echo $field . ' cannot be empty';
    }

    if ($res = Validation::email_error($_POST['email'])) {
        echo $res;
    }

    // Validate password length
    if (strlen($_POST['password']) > 255) {
        echo 'password must be under 255 characters';
    }

    if (!Validation::verify_user($_POST['email'], $_POST['password'])) {
        echo 'could not verify';
    }

    $stmt = "SELECT id FROM user WHERE email = ?";
    $user_id = Database::run_statement($stmt, [$_POST['email']]);
    $id = $user_id->fetch_assoc()['id'];

    session_start();
    $_SESSION["id"] = $id;

    header('Location: ../page/restaurants.php');
?>