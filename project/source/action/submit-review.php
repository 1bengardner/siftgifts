<?php
    require_once '../action/login-check.php';
    require_once '../util/utilities.php';

    // TODO: Validate fields

    $stmt = "INSERT INTO review(restaurant, reviewer, rating, content) VALUES (?, ?, ?, ?)";
    $user_id = Database::run_statement($stmt, [$_POST["restaurant"], $_POST['name'], $_POST['rating'], $_POST['review-text']]);
    
    header('Location: ../page/restaurants.php')
?>