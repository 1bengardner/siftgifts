<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

// TODO: Validate fields

$stmt = "CALL edit_gift(?, ?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['id'], $_POST['name'], $_POST['url'], $_POST['comments'], $_SESSION['id']]);
$_SESSION["notifications"] = [new Notification(NotificationText::EditSuccess, NotificationLevel::Success)];
header("Location: /wishlist");
exit;
?>