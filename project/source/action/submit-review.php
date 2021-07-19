<?php
require_once '../action/login-check.php';
require_once '../util/utilities.php';

// TODO: Validate fields

$stmt = "INSERT INTO review(restaurant, reviewer, rating, content, user) VALUES (?, ?, ?, ?, ?)";
$user_id = Database::run_statement(Database::get_connection(), $stmt, [$_POST["restaurant"], $_POST['name'], $_POST['rating'], $_POST['review-text'], $_SESSION['id']]);

header('Location: ../page/reviews?restaurant='.$_POST["restaurant"])
?>