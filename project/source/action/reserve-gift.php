<?php
// NOTE: If unwanted reserving becomes an issue, change id to GUID or something unguessable
require_once '../util/utilities.php';
require_once 'start-session.php';

$stmt = "UPDATE gift SET reserved=1, reserved_time=CURRENT_TIMESTAMP, reserver=? WHERE id=? AND reserved=0";
$user = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$affected_rows = Database::run_update_statement_and_get_affected_rows(Database::get_connection(), $stmt, [$user, $_POST["id"]]);

if ($affected_rows === 1) {
  require_once '../action/record-gift-action.php';
  recordGiftReservation($_POST["id"], true, $user);
  http_response_code(200);
  $_SESSION["notifications"] = [new Notification(NotificationText::ReserveSuccess, NotificationLevel::Success)];
} else {
  http_response_code(400);
  // TODO Maybe improve error text to indicate specific state (already reserved, gift no longer there—SELECT to find out)
  $_SESSION["notifications"] = [new Notification(NotificationText::AlreadyReserved, NotificationLevel::Error)];
}
include '../page/notification-box.php';
?>