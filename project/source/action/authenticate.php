<?php
require_once '../util/utilities.php';
if (session_status() === PHP_SESSION_NONE)
  session_start();

if (!isset($_SESSION["id"]) || !$_SESSION["id"]) {
  $_SESSION["messages"] = [Message::NotLoggedIn];
  header("Location: ../page/login");
  exit;
}
?>