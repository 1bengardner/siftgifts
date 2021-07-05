<?php
    require_once '../action/login-check.php';
    require_once '../util/utilities.php';

    // TODO: Validate fields

    $stmt = "INSERT INTO restaurant(user, name, cuisine, location, url) VALUES (?, ?, ?, ?, ?)";
    $user_id = Database::run_statement($stmt, [$_SESSION["id"], $_POST['name'], $_POST['cuisine'], $_POST['location'], $_POST['url']]);

    header('Location: ../page/restaurants.php')
?>