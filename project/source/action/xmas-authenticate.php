<?php
require_once 'start-session.php';

if (!isset($_SESSION["xmas"]) || !$_SESSION["xmas"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::MissingCode, NotificationLevel::Error)];
  header("Location: /landing");
  exit;
}
?>