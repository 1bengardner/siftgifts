<?php
    require '../action/login-check.php';
    require '../util/utilities.php';

    // TODO: Validate fields

    $stmt = "INSERT INTO restaurant(user, name, cuisine) VALUES (?, ?, ?)";
    $user_id = Database::run_statement($stmt, [$_SESSION["id"], $_POST['name'], $_POST['cuisine']]);
?>