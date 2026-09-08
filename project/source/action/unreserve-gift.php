<?php
// NOTE: If unwanted unreserving becomes an issue, change id to GUID or something unguessable
require_once '../util/utilities.php';
require_once 'start-session.php';

$stmt = "UPDATE gift SET reserved=0, reserved_time=CURRENT_TIMESTAMP, reserver=? WHERE id=? AND reserved=1";
$affected_rows = Database::run_update_statement_and_get_affected_rows(Database::get_connection(), $stmt, [isset($_SESSION["id"]) ? $_SESSION["id"] : null, $_POST["id"]]);

if ($affected_rows === 1) {
  http_response_code(200);
  $_SESSION["notifications"] = [new Notification(NotificationText::UnreserveSuccess, NotificationLevel::Success)];
} else {
  http_response_code(400);
  // TODO Maybe improve error text to indicate specific state (already unreserved, gift no longer there—SELECT to find out)
  $_SESSION["notifications"] = [new Notification(NotificationText::UnreserveError, NotificationLevel::Error)];
}
include '../page/notification-box.php';
?>