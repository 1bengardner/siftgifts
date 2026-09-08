<?php
// NOTE: If unwanted reserving becomes an issue, change id to GUID or something unguessable
require_once '../util/utilities.php';
require_once 'start-session.php';

$stmt = "UPDATE gift SET reserved=1, reserved_time=CURRENT_TIMESTAMP, reserver=? WHERE id=? AND reserved=0";
$affected_rows = Database::run_update_statement_and_get_affected_rows(Database::get_connection(), $stmt, [isset($_SESSION["id"]) ? $_SESSION["id"] : null, $_POST["id"]]);

if ($affected_rows === 1) {
  http_response_code(200);
  $_SESSION["notifications"] = [new Notification(NotificationText::ReserveSuccess, NotificationLevel::Success)];
} else {
  http_response_code(400);
  // TODO Maybe improve error text to indicate specific state (already reserved, gift no longer there—select to find out)
  $_SESSION["notifications"] = [new Notification(NotificationText::AlreadyReserved, NotificationLevel::Error)];
}
include '../page/notification-box.php';
?>