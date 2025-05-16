<?php
require_once '../util/utilities.php';
require_once 'authenticate.php';

$stmt = "CALL update_profile(?, ?, ?, ?, ?)";
$db = Database::get_connection();
Database::run_statement($db, $stmt, [$_SESSION['id'], null, null, null, isset($_POST['subscribe-to-message-alerts']) ? 1 : 0]);

$_SESSION["notifications"] = [new Notification(NotificationText::UpdatePreferencesSuccess, NotificationLevel::Success)];

header('Location: /preferences');
?>