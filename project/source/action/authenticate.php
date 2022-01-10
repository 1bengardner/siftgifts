<?php
require_once '../action/start-session.php';

if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
  $_SESSION["notifications"] = [new Notification(Message::NotLoggedIn, MessageLevel::Error)];
  header("Location: ../page/login");
  exit;
}
?>