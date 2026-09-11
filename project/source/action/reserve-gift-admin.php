<?php
require_once '../util/utilities.php';
require_once '../data/gift.php';
require_once 'authenticate.php';

if (!Gift::get_from_id($_POST["id"])->belongs_to_user($_SESSION["id"])) {
  http_response_code(400);
  $_SESSION["notifications"] = [new Notification(NotificationText::InvalidGift, NotificationLevel::Error)];
  include '../page/notification-box.php';
  return;
}

$stmt = "UPDATE gift SET reserved=? WHERE id=? AND reserved=?";
$affected_rows = Database::run_update_statement_and_get_affected_rows(Database::get_connection(), $stmt, [$_POST["reserve"], $_POST["id"], $_POST["reserve"] == 1 ? 0 : 1]);

if ($affected_rows === 1) {
  require_once '../action/record-gift-action.php';
  recordGiftReservation($_POST["id"], (bool)$_POST["reserve"], $_SESSION["id"]);
  http_response_code(200);
} else {
  http_response_code(409);
  $_SESSION["notifications"] = [new Notification(NotificationText::GiftReservationModified, NotificationLevel::Error)];
  include '../page/notification-box.php';
}
?>