<?php
require_once 'start-session.php';

if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(NotificationText::NotLoggedIn, NotificationLevel::Error)];
  header("Location: /login");
  exit;
}
?>