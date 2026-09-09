<?php
require_once '../util/utilities.php';
require_once '../util/db_enums.php';
require_once 'authenticate.php';

// TODO: Validate fields

$stmt = "CALL add_gift(?, ?, ?, ?, ?, ?)";
Database::run_statement(Database::get_connection(), $stmt, [$_POST['name'], $_POST['url'], strlen($_POST['price']) === 0 ? null : $_POST['price'], $_POST['comments'], $_POST['unreservable'] ? DbEnum\GiftMode::ExternalRegistry : DbEnum\GiftMode::Normal, $_SESSION['id']]);
$_SESSION["notifications"] = [new Notification(NotificationText::AddSuccess, NotificationLevel::Success)];
include '../page/notification-box.php';
?>