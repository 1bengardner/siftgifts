<?php
require_once '../util/utilities.php';
require_once 'start-session.php';

$stmt = "SELECT reserved FROM gift WHERE id=?";
$reserved = Database::run_statement(Database::get_connection(), $stmt, [$_POST["id"]])->fetch_row()[0];
if (is_null($reserved)) {
  http_response_code(400);
  $_SESSION["notifications"] = [new Notification(NotificationText::InvalidGift, NotificationLevel::Error)];
  include '../page/notification-box.php';
} else if ($reserved === 1) {
  http_response_code(409);
  $_SESSION["notifications"] = [new Notification(NotificationText::AlreadyReserved, NotificationLevel::Error)];
  include '../page/notification-box.php';
} else {
  http_response_code(200);
}
exit;
?>